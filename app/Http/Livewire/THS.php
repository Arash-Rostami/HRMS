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


    public $stats;
    public $selectedTicket = [];
    public $activeTab = 'request';
    public $requestAreas = [];
    public $fileInputs = [];
    public $files = [];
    public $ticketToRate;
    public $satisfactionScore;
    public $satisfactionComment;


    public $ticket = [
        'requester' => '',
        'department' => '',
        'requestType' => 'support',
        'requestArea' => '',
        'priority' => 'low',
        'subject' => '',
        'description' => '',
    ];

    public function getFormattedTicketId($ticket)
    {
        return 'PS-T-' . Carbon::parse($ticket['created_at'])->format('Y-m') . '-' . str_pad($ticket['id'], 4, '0', STR_PAD_LEFT);
    }

    public function getFormattedTimeStamp($ticket, $col)
    {
        return Carbon::parse($ticket[$col])->diffForHumans();
    }

    public function getRequestAreaLabel($requestType, $requestArea)
    {
        if (!isset(Ticket::$requestAreaOptions[$requestType]) || !isset(Ticket::$requestAreaOptions[$requestType][$requestArea])) {
            return 'Not Found';
        }
        return Ticket::$requestAreaOptions[$requestType][$requestArea];
    }


    public function mount()
    {
        $this->ticket['department'] = auth()->user() && auth()->user()->profile && auth()->user()->profile->department
            ? DepartmentDetails::getName(auth()->user()->profile->department)
            : 'N/A';;

        $this->addFileInput();
        $this->loadRequestAreas();
        $this->ticketToRate = $this->loadTicketToRate();

        if ($this->ticketToRate) {
            $this->activeTab = 'rate';
        }
    }

    public function addFileInput()
    {
        $this->fileInputs[] = uniqid();
    }

    public function removeFileInput($key)
    {
        unset($this->files[$key]);
        $this->fileInputs = array_filter($this->fileInputs, function ($input) use ($key) {
            return $input !== $key;
        });
    }

    public function loadRequestAreas()
    {
        $this->requestAreas = Ticket::$requestAreaOptions[$this->ticket['requestType']] ?? [];
    }

    public function loadTickets()
    {
        return Ticket::where('requester_id', auth()->id())
            ->orderByRaw("FIELD(status, 'open', 'in-progress', 'closed')")
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function updatedTicketRequestType($value)
    {
        $this->requestAreas = Ticket::$requestAreaOptions[$value] ?? [];
    }

    public function submitTicket()
    {
        $validatedData = $this->validateTicket();

        $filePaths = $this->storeAttachment();

        $this->persistTicket($validatedData['ticket'], $filePaths);

        showFlash("success", "درخواست با موفقیت ثبت شد.");

        return redirect()->route('user.panel');
    }

    public function rate($score)
    {
        $this->satisfactionScore = $score;
    }


    public function submitRating()
    {
        $this->validateRate();

        $this->persistRate();

        $this->activeTab = 'request';

        showFlash('success', 'از بازخورد شما سپاسگزاریم.');
        return redirect()->route('user.panel');
    }


    public function viewTicket($ticketId)
    {
        $ticket = Ticket::with('assignee')->find($ticketId);
        $this->selectedTicket = $ticket ? $ticket->toArray() : [];
    }

    public function render()
    {
        return view('livewire.t-h-s', [
            'requestAreas' => $this->requestAreas,
            'tickets' => $this->loadTickets(),
            'ticketToRate' => $this->ticketToRate,
        ]);
    }


    protected function validateTicket()
    {
        $rules = [
            'ticket.requestType' => 'required|string',
            'ticket.requestArea' => 'required|string',
            'ticket.priority' => 'required|string',
            'ticket.subject' => 'required|string|max:255',
            'ticket.description' => 'required|string',
            'files' => 'array',
            'files.*' => 'file|max:4096|mimes:jpeg,png,gif,bmp,svg,webp,pdf,doc,docx,xls,xlsx,ods,odt'
        ];
        $messages = [
            'ticket.requestType.required' => 'نوع درخواست را انتخاب کنید.',
            'ticket.requestArea.required' => 'حوزه درخواست را انتخاب کنید.',
            'ticket.priority.required' => 'اولویت را انتخاب کنید.',
            'ticket.subject.required' => 'موضوع تیکت را وارد کنید.',
            'ticket.subject.max' => 'حداکثر طول مجاز برای موضوع ۲۵۵ کاراکتر است.',
            'ticket.description.required' => 'توضیحات تیکت را وارد کنید.',
            'files.*.file' => 'فایل ضمیمه باید یک فایل معتبر باشد.',
            'files.*.max' => 'حجم هر فایل نباید بیشتر از ۴ مگابایت باشد.',
            'files.*.mimes' => 'فرمت فایل مجاز نیست.',
        ];
        return $this->validate($rules, $messages);
    }

    /**
     * @return array|null
     */
    protected function storeAttachment(): ?array
    {
        $filePaths = [];
        foreach ($this->files as $file) {
            $fileName = Admin::forgeNameOfFile($file);
            $filePath = $file->storeAs('files/ths/requester', $fileName, 'filament');
            $filePaths[] = ['file' => $filePath];
        }

        return $filePaths;
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

    /**
     * @return mixed
     */
    protected function loadTicketToRate()
    {
        return Ticket::where('requester_id', auth()->user()->id)
            ->where('status', 'closed')
            ->where('satisfaction_score', 0)
            ->first();
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
}
