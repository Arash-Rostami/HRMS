
<div class="p-6 rounded-lg mx-auto persol-farsi-font rtl-direction transition-colors duration-300 ease-in-out
    @if(isDarkMode()) hover:bg-gray-900/20 @else hover:bg-gray-200  @endif ">
    <div class="flex flex-col md:flex-row pb-6 md:pb-0 md:p-3 w-full">
        <div class="m-4 md:w-[25%]">
            <label for="requestType" class="block mb-2">
                <i class="fa fa-cogs text-xs text-main mr-1"></i>
                نوع درخواست:
            </label>
            <select id="requestType" wire:model="ticket.requestType"
                    class="w-full border border-gray-300 text-gray-500 rounded-md p-1 md:p-2 text-center font-bold">
                <option class="font-bold" value="support">پشتیبانی</option>
                <option class="font-bold" value="access">دسترسی</option>
            </select>
            @error('ticket.requestType')
            <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="m-4 md:w-[25%]">
            <label for="requestArea" class="block mb-2">
                <i class="fa fa-map-marker text-xs text-main mr-1"></i>
                حوزه درخواست:
            </label>
            <select id="requestArea" wire:model="ticket.requestArea"
                    class="w-full border border-gray-300 text-gray-500 rounded-md p-1 md:p-2 text-center font-bold">
                @foreach($requestAreas as $value => $label)
                    <option class="font-bold" value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            @error('ticket.requestArea')
            <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="m-4 md:w-[25%]">
            <label for="priority" class="block mb-2">
                <i class="fa fa-exclamation-triangle text-xs text-main mr-1"></i>
                اولویت:
            </label>
            <select id="priority" wire:model="ticket.priority"
                    class="w-full border border-gray-300 text-gray-500 rounded-md p-1 md:p-2 text-center font-bold">
                <option class="font-bold" value="low">کم</option>
                <option class="font-bold" value="medium">متوسط</option>
                <option class="font-bold" value="high">زیاد</option>
            </select>
            @error('ticket.priority')
            <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
    </div>


    <div class="flex flex-col md:flex-row">
        <div class="flex flex-col pb-6 md:pb-0 md:p-3 w-full md:w-[50%]">
            <div class="m-4 md:w-full">
                <label for="subject" class="block mb-2">
                    <i class="fas fa-tag text-xs text-main"></i>
                    موضوع تیکت:
                </label>
                <input type="text" id="subject" wire:model="ticket.subject"
                       class="w-full border border-gray-300 text-gray-500 rounded-md p-1 md:p-2"
                       placeholder="موضوع را وارد کنید">
                @error('ticket.subject')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="m-4 md:w-full">
                <label for="description" class="block mb-2">
                    <i class="fa fa-edit text-xs text-main"></i>
                    توضیحات تیکت:
                </label>
                <textarea id="description" wire:model="ticket.description"
                          class="w-full border border-gray-300 text-gray-500 rounded-md p-2"
                          rows="3" placeholder="توضیحات خود را وارد کنید"></textarea>
                @error('ticket.description')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="flex flex-col pb-6 md:pb-0 md:p-3 w-full md:w-[10%]"></div>


        <div class="flex flex-col pb-6 md:pb-0 md:p-3 w-full md:w-[30%]">
            <div class="w-full md:w-2/3 m-auto md:mx-0 text-justify">
                <label class="block mb-2">
                    <i class="fas fa-paperclip text-xs text-main"></i>
                    فایل‌های ضمیمه:
                </label>
                @foreach ($fileInputs as $index => $key)
                    <div class="flex items-center mb-2"
                         x-data="{
                        isUploading: false,
                        isUploaded: false,
                        file: null,
                        fileType: '',
                        fileUrl: '',
                        handleFileSelected(event) {
                            const file = event.target.files[0];
                            if (file) {
                                this.file = file;
                                this.fileType = file.type;
                                if (file.type.startsWith('image/')) {
                                    this.fileUrl = URL.createObjectURL(file);
                                } else {
                                    this.fileUrl = '';
                                }
                            }
                        }
                    }"
                         x-on:livewire-upload-start="isUploading = true"
                         x-on:livewire-upload-finish="isUploading = false; isUploaded = true"
                         x-on:livewire-upload-error="isUploading = false"
                    >
                        <div class="flex items-center w-full">
                            <label for="dropzone-file-{{ $key }}"
                                   class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg
                              cursor-pointer bg-gray-100 hover:bg-gray-200 dark:border-gray-600">
                                <template x-if="!fileUrl">
                                    <svg aria-hidden="true" class="w-8 h-8 mb-3 text-gray-400" fill="none"
                                         stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                </template>
                                <template x-if="fileUrl">
                                    <img :src="fileUrl" alt="Preview" class="w-16 h-16 rounded-md object-cover">
                                </template>
                                <p x-show="!isUploaded" class="text-sm text-gray-500 px-4">
                                    <span class="font-semibold">فایل ضمیمه</span>
                                </p>
                                <p x-show="!isUploaded" class="text-xs hidden md:inline text-gray-500 px-4">
                                    PDF, PNG, JPG (MAX 4MB)
                                </p>
                                <div x-show="isUploaded" title="uploaded successfully">✔️</div>
                                <input id="dropzone-file-{{ $key }}" class="hidden" type="file"
                                       wire:model="files.{{ $key }}"
                                       x-on:change="handleFileSelected"
                                />
                            </label>
                        </div>
                        @error('files.' . $key)
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach

                <button type="button" wire:click="addFileInput" title="افزودن فایل"
                        class="mt-2 text-success-500">
                    <i class="fa fa-plus"></i>
                </button>

                @if($index > 0)
                    <button type="button" wire:click="removeFileInput('{{ $key }}')" title="حذف فایل"
                            class="ml-2 text-red-500">
                        <i class="fa fa-trash"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row pb-6 md:pb-0 md:p-3 m-4">
        <button type="submit"
                @if(session('success')) disabled @endif
                wire:click="submitTicket"
                wire:loading.attr="disabled"
                wire:loading.class="bg-red-700"
                wire:loading.class.remove="bg-main-mode"
                wire:target="submitTicket"
                class="bg-main-mode text-white py-2 px-4 rounded-md mt-4">
                <span wire:loading.remove wire:target="submitTicket">ثبت تیکت<i
                        class="fa fa-paper-plane mr-2"></i></span>
            <span wire:loading wire:target="submitTicket"><i class="fas fa-spinner fa-spin"></i> ارسال...</span>
        </button>
    </div>
</div>


