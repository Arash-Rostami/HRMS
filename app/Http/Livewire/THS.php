<?php

namespace App\Http\Livewire;

use App\Filament\Resources\TicketResource\Pages\Admin;
use App\Models\Ticket;
use App\Services\DepartmentDetails;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class THS extends Component
{
    use WithFileUploads, WithPagination;

    public $stats = null;
    public $ticketToRate = null;
    public ?array $selectedTicket = null;
    public string $activeTab = 'request';
    public array $requestAreas = [];
    public array $fileInputs = [];
    public array $files = [];
    public ?int $satisfactionScore = null;
    public ?string $satisfactionComment = null;


    public array $ticket = [
        'requester' => '',
        'department' => '',
        'requestType' => 'support',
        'requestArea' => '',
        'priority' => 'low',
        'subject' => '',
        'description' => '',
    ];

    public function addFileInput(): void
    {
        $this->fileInputs[] = uniqid('', true);
    }

    public function getFormattedTicketId($ticket): string
    {
        return sprintf(
            'PS-T-%s-%04d',
            Carbon::parse($ticket['created_at'])->format('Y-m'),
            (int)$ticket['id']
        );
    }

    public function getFormattedTimeStamp($ticket, $col): string
    {
        return Carbon::parse($ticket[$col])->diffForHumans();
    }

    public function getRequestAreaLabel($requestType, $requestArea): string
    {
        return (Ticket::$requestAreaOptions[$requestType] ?? [])[$requestArea]
            ?? 'Not Found';
    }

    public function loadRequestAreas()
    {
        $this->requestAreas = Ticket::$requestAreaOptions[$this->ticket['requestType']] ?? [];
    }

    public function loadTickets()
    {
        return Ticket::where('requester_id', auth()->id())
            ->orderByRaw("FIELD(status, 'open', 'in-progress', 'closed')")
            ->orderByDesc('created_at')
            ->simplePaginate(10);
    }

    public function mount(): void
    {
        $dept = data_get(auth()->user(), 'profile.department');

        $this->ticket['department'] = $dept
            ? DepartmentDetails::getName($dept)
            : 'N/A';

        $this->addFileInput();
        $this->loadRequestAreas();
        $this->ticketToRate = $this->loadTicketToRate();

        if ($this->ticketToRate) {
            $this->activeTab = 'rate';
        }
    }

    public function rate($score): void
    {
        $this->satisfactionScore = (int)$score;
    }

    public function removeFileInput($key): void
    {
        unset($this->files[$key]);

        $this->fileInputs = array_values(array_filter(
            $this->fileInputs,
            fn($input) => $input !== $key
        ));
    }

    public function render()
    {
        return view('components.user.ths.table', [
            'requestAreas' => $this->requestAreas,
            'tickets' => $this->loadTickets(),
            'ticketToRate' => $this->ticketToRate,
        ]);
    }

    public function submitRating()
    {
        $this->validateRate();
        $this->persistRate();

        $this->activeTab = 'request';
        showFlash('success', 'از بازخورد شما سپاسگزاریم.');
        return redirect()->route('user.panel');
    }

    public function submitTicket()
    {
        $this->files = collect($this->files)
            ->map(fn($file) => is_array($file) ? reset($file) : $file)
            ->filter()
            ->toArray();

        $data = $this->validateTicket();

        try {
            $paths = $this->storeAttachment();
            $this->persistTicket($data['ticket'], $paths);
            showFlash('success', 'درخواست با موفقیت ثبت شد.');
            return redirect()->route('user.panel');

        } catch (\Exception $e) {
            showFlash('error', 'خطایی رخ داده است. لطفا دوباره تلاش کنید.');
        }
    }

    public function updated($propertyName)
    {
        if (str_starts_with($propertyName, 'files.')) {
            $this->resetErrorBag($propertyName);
        }
    }

    public function updatedTicketRequestType($value)
    {
        $this->requestAreas = Ticket::$requestAreaOptions[$value] ?? [];
    }

    public function viewTicket($ticketId)
    {
        $ticket = Ticket::with('assignee')->find($ticketId);
        $this->selectedTicket = $ticket ? $ticket->toArray() : [];
    }

    protected function loadTicketToRate()
    {
        return Ticket::where('requester_id', auth()->id())
            ->where('status', 'closed')
            ->where('satisfaction_score', 0)
            ->first();
    }

    /**
     * @return void
     */
    protected function persistRate(): void
    {
        $existingExtra = $this->ticketToRate->extra ?? [];

        $updatedExtra = array_merge($existingExtra, [
            'satisfaction_comment' => $this->satisfactionComment,
        ]);

        $this->ticketToRate->update([
            'satisfaction_score' => $this->satisfactionScore,
            'extra' => $updatedExtra,
        ]);
    }

    /**
     * @param $ticket
     * @param array $filePaths
     * @return void
     */
    protected function persistTicket($ticket, array $filePaths): void
    {
        Ticket::create([
            'request_type' => $ticket['requestType'],
            'request_area' => $ticket['requestArea'],
            'priority' => $ticket['priority'],
            'request_subject' => $ticket['subject'],
            'description' => $ticket['description'],
            'requester_files' => $filePaths,
            'requester_id' => auth()->id(),
            'extra' => ['department' => $this->ticket['department']]
        ]);
    }

    protected function storeAttachment(): array
    {
        if (empty($this->files)) return [];

        $paths = [];
        foreach ($this->files as $file) {
            $name = Admin::forgeNameOfFile($file);
            $paths[] = ['file' => $file->storeAs('files/ths/requester', $name, 'filament')];
        }

        return $paths;
    }

    /**
     * @return void
     */
    protected function validateRate(): void
    {
        $this->validate([
            'satisfactionScore' => 'required|integer|min:1|max:5',
            'satisfactionComment' => 'nullable|string|max:1000',
        ], [
            'satisfactionScore.required' => 'لطفا امتیاز رضایت را انتخاب کنید.',
            'satisfactionScore.integer' => 'امتیاز باید یک عدد صحیح باشد.',
            'satisfactionScore.min' => 'امتیاز باید حداقل ۱ باشد.',
            'satisfactionScore.max' => 'امتیاز نمی‌تواند بیشتر از ۵ باشد.',
            'satisfactionComment.max' => 'توضیحات نمی‌تواند بیش از ۱۰۰۰ کاراکتر باشد.',
        ]);
    }

    protected function validateTicket()
    {
        return $this->validate([
            'ticket.requestType' => 'required|string',
            'ticket.requestArea' => 'required|string',
            'ticket.priority' => 'required|string',
            'ticket.subject' => 'required|string|max:255',
            'ticket.description' => 'required|string',
            'files' => 'array',
            'files.*' => 'file|max:4096|mimes:jpeg,png,gif,bmp,svg,webp,pdf,doc,docx,xls,xlsx,ods,odt'
        ], [
            'ticket.requestType.required' => 'نوع درخواست را انتخاب کنید.',
            'ticket.requestArea.required' => 'حوزه درخواست را انتخاب کنید.',
            'ticket.priority.required' => 'اولویت را انتخاب کنید.',
            'ticket.subject.required' => 'موضوع تیکت را وارد کنید.',
            'ticket.subject.max' => 'حداکثر طول مجاز برای موضوع ۲۵۵ کاراکتر است.',
            'ticket.description.required' => 'توضیحات تیکت را وارد کنید.',
            'files.*.file' => 'فایل ضمیمه باید یک فایل معتبر باشد.',
            'files.*.max' => 'حجم هر فایل نباید بیشتر از ۴ مگابایت باشد.',
            'files.*.mimes' => 'فرمت فایل مجاز نیست.',
        ]);
    }
}
