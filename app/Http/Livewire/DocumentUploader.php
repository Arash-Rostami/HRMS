<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class DocumentUploader extends Component
{
    use WithFileUploads;

    public bool $showConfirmDialog = false;
    public string $pendingUploadKey = '';
    public string $pendingFileName = '';
    public array $documents = [];
    public array $file = [];
    public ?string $errorMessage = null;

    protected $listeners = ['documentUploaded' => 'fetchDocuments'];


    private const DOCUMENT_DEFINITIONS = [
        ['key' => 'shenasnameh', 'title' => 'تمام صفحات شناسنامه', 'icon' => 'fa-id-card'],
        ['key' => 'national_id', 'title' => 'پشت و روی کارت ملی', 'icon' => 'fa-address-card'],
        ['key' => 'diploma', 'title' => 'آخرین مدرک تحصیلی', 'icon' => 'fa-graduation-cap'],
        ['key' => 'military_service', 'title' => 'کارت پایان خدمت یا معافیت', 'icon' => 'fa-user-shield'],
        ['key' => 'accumulated_insurance', 'title' => 'سابقه بیمه تلفیقی', 'icon' => 'fa-user-tie', 'help_text' => 'راهنمای دریافت سوابق بیمهٔ تأمین اجتماعی در بالای صفحه مطالعه کنید.'],
        ['key' => 'insurance_record', 'title' => 'کلیه سوابق بیمه‌', 'icon' => 'fa-file-invoice', 'help_text' => 'راهنمای دریافت سوابق بیمهٔ تأمین اجتماعی در بالای صفحه مطالعه کنید.'],
        ['key' => 'bank_account', 'title' => 'شماره حساب یا کارت بانکی', 'icon' => 'fa-landmark', 'help_text' => 'نیازی به ارسال عکس کارت بانکی خود ندارید. لطفا شماره را خوانا روی کاغذ نوشته و از آن عکس گرفته و سپس آپلود کنید.'],
    ];


    protected function rules(): array
    {
        return [
            'file.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    protected function messages(): array
    {
        return [
            'file.*.required' => 'لطفاً یک فایل انتخاب کنید.',
            'file.*.file'     => 'یک فایل معتبر بارگذاری کنید.',
            'file.*.mimes'    => 'فرمت فایل باید PDF, JPG, JPEG یا PNG باشد.',
            'file.*.max'      => 'حجم فایل نباید بیشتر از 5 مگابایت باشد.',
        ];
    }

    public function mount(): void
    {
        $this->fetchDocuments();
    }

    public function fetchDocuments(): void
    {
        $profile = auth()->user()?->profile;
        $allPaths = $profile->attachments ?? [];

        $this->documents = collect(self::DOCUMENT_DEFINITIONS)->map(function ($def) use ($allPaths) {
            $attachmentInfo = $this->parseAttachmentInfo($def['key'], $allPaths);
            return array_merge($def, $attachmentInfo);
        })->toArray();
    }

    public function upload(string $key): void
    {
        $this->validate(["file.{$key}" => $this->rules()['file.*']]);

        $profile = auth()->user()?->profile;
        if (!$profile) {
            $this->errorMessage = 'پروفایل یافت نشد.';
            return;
        }

        $uploadedFile = $this->file[$key];
        $timestamp = time();
        $extension = $uploadedFile->getClientOriginalExtension();
        $fileName = "HR-profile-doc-{$profile->id}-{$key}-{$timestamp}.{$extension}";
        $newPath = $uploadedFile->storeAs('docs/profile', $fileName, 'filament');

        $currentAttachments = collect($profile->attachments ?? []);

        // Reject old attachments for this key, push the new one, and get the updated array.
        $profile->attachments = $currentAttachments
            ->reject(fn ($path) => str_contains($path, "-{$key}-"))
            ->push($newPath)
            ->all();

        $profile->save();

        $this->reset('file');
        $this->fetchDocuments();
    }

    public function showUploadConfirmation(string $key): void
    {
        $this->validate(["file.{$key}" => $this->rules()['file.*']]);

        $this->pendingUploadKey = $key;
        $this->pendingFileName = $this->file[$key]->getClientOriginalName() ?? 'فایل انتخاب شده';
        $this->showConfirmDialog = true;
    }

    public function confirmUpload(): void
    {
        if ($this->pendingUploadKey) {
            $this->upload($this->pendingUploadKey);
            $this->resetConfirmDialog();
        }
    }

    public function cancelUpload(): void
    {
        $this->resetConfirmDialog();
    }

    private function resetConfirmDialog(): void
    {
        $this->showConfirmDialog = false;
        $this->pendingUploadKey = '';
        $this->pendingFileName = '';
    }


    private function parseAttachmentInfo(string $key, array $allPaths): array
    {
        $matchedPath = collect($allPaths)->last(fn ($path) => str_contains($path, "-{$key}-"));

        if (!$matchedPath) {
            return ['uploaded' => false, 'fileName' => null, 'uploadedTime' => null, 'file_url' => null];
        }

        $fileName = basename($matchedPath);
        $uploadedTime = null;

        if ($fileName && preg_match('/(\d{10,})/', $fileName, $m)) {
            $uploadedTime = Carbon::createFromTimestamp(
                (int)$m[1],
                'Asia/Tehran'
            )->format('Y/m/d H:i');
        }

        return [
            'uploaded'     => true,
            'fileName'     => $fileName,
            'uploadedTime' => $uploadedTime,
            'file_url'     => Storage::disk('filament')->url($matchedPath),

        ];
    }

    public function render()
    {
        return view('components.user.onboarding.documents');
    }
}
