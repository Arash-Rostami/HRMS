<?php

namespace App\Http\Livewire;

use App\Http\Livewire\TaskBoard\WithBaseData;
use App\Http\Livewire\TaskBoard\WithValidation;
use App\Models\Task;
use App\Models\User;
use App\Services\Date;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Morilog\Jalali\CalendarUtils;

class TaskBoard extends Component
{
    use WithBaseData, WithValidation;


    public $listeners = ['refreshBoard' => 'loadTasks'];

    public function createTask()
    {
        $this->validate();

        $deadline = null;
        if ($this->deadlineYear && $this->deadlineMonth && $this->deadlineDay) {
            try {
                $farsiDate = sprintf('%s/%02d/%02d', $this->deadlineYear, $this->deadlineMonth, $this->deadlineDay);
                $deadline = CalendarUtils::createCarbonFromFormat('Y/m/d', $farsiDate);
            } catch (\Exception $e) {
                $this->addError('deadline', 'تاریخ وارد شده معتبر نیست');
                return;
            }
        }

        Task::create([
            'title' => $this->newTitle,
            'description' => $this->newDescription,
            'status' => 'todo',
            'deadline' => $deadline,
            'user_id' => auth()->id(),
            'assigned_to' => $this->selectedAssignee,
        ]);

        $this->reset(['newTitle', 'newDescription', 'deadlineYear', 'deadlineMonth', 'deadlineDay', 'selectedAssignee']);
        $this->loadTasks();
    }

    public function deleteTask($taskId)
    {
        $task = Task::find($taskId);

        if ($task && $task->can_delete) {
            $task->delete();
            $this->loadTasks();
        }
    }

    public function editTask($taskId)
    {
        $this->editingTaskId = $taskId;
        $this->emit('open-edit-modal', taskId: $taskId);
    }

    public function loadTasks()
    {
        $userId = auth()->id();

        foreach ($this->columns as $column) {
            $skip = ($this->page[$column] - 1) * $this->perPage;

            $query = Task::query()
                ->where('status', $column)
                ->when($this->activeTab === 'my-tasks', function ($q) use ($userId) {
                    $q->where(function ($sub) use ($userId) {
                        $sub->where('assigned_to', $userId)
                            ->orWhere(function ($sub2) use ($userId) {
                                $sub2->where('user_id', $userId)->whereNull('assigned_to');
                            });
                    });
                })
                ->when($this->activeTab === 'assigned-tasks', function ($q) use ($userId) {
                    $q->where('user_id', $userId)
                        ->whereNotNull('assigned_to')
                        ->where('assigned_to', '!=', $userId);
                });

            $this->totalCount[$column] = (clone $query)->count();

            $this->tasks[$column] = $query->orderBy('created_at', 'desc')
                ->skip($skip)
                ->take($this->perPage)
                ->with($this->relationsToLoad)
                ->get($this->columnsToSelect)
                ->toArray();
        }
    }

    public function mount()
    {
        $currentYear = Date::getFarsiYear();
        $this->years = range($currentYear, $currentYear + 3);
        $this->staffMembers = Cache::remember("staff_" . auth()->id(), 3600, fn() => collect(User::getActiveNonGuestUsers())
            ->except(auth()->id())
            ->map(fn($full_name, $id) => ['id' => $id, 'full_name' => $full_name])
            ->values()
            ->toArray()
        );
        $this->loadTasks();
    }


    public function nextPage(string $column)
    {
        $maxPage = (int)ceil($this->totalCount[$column] / $this->perPage);
        if ($this->page[$column] < $maxPage) {
            $this->page[$column]++;
            $this->loadTasks();
        }
    }

    public function prevPage(string $column)
    {
        if ($this->page[$column] > 1) {
            $this->page[$column]--;
            $this->loadTasks();
        }
    }

    public function render()
    {
        return view('components.user.tasks.board');
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->loadTasks();
    }

    public function undoAssignment($taskId)
    {
        $task = Task::find($taskId);

        if ($task && $task->is_delegator) {
            $task->update(['assigned_to' => null]);
            $this->activeTab = 'my-tasks';
            $this->page = ['todo' => 1, 'in-progress' => 1, 'done' => 1];
            $this->loadTasks();
        }
    }

    public function updateTaskStatus($taskId, $newColumn)
    {
        $task = Task::find($taskId);

        if ($task && $task->can_change_status) {
            $task->update(['status' => $newColumn]);
            $this->loadTasks();
        }
    }
}
