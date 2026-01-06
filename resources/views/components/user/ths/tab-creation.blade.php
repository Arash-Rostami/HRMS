<div
    class="p-6 rounded-lg mx-auto transition-colors duration-300 ease-in-out @if(isDarkMode()) hover:bg-gray-900/20 @else hover:bg-gray-200  @endif">
    <div class="flex flex-col md:flex-row pb-6 md:pb-0 md:p-3 w-full">
        <div class="m-4 md:w-[25%]">
            <label for="requestType" class="block mb-2">
                <i class="fa fa-cogs text-main mr-1"></i>
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
                <i class="fa fa-map-marker text-main mr-1"></i>
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
                <i class="fa fa-exclamation-triangle text-main mr-1"></i>
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
                    <i class="fas fa-tag text-main"></i>
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
                    <i class="fa fa-edit text-main"></i>
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
                    <i class="fas fa-paperclip text-main"></i>
                    فایل‌های ضمیمه:
                </label>

                @foreach ($fileInputs as $index => $key)
                    <div class="flex items-center mb-3"
                         x-data="{
                                file: null,
                                url: '',
                                name: '',
                                sizeMb: null,
                                type: '',
                                prevUrl: '',
                                setFile(ev) {
                                    const f = ev?.target?.files?.[0] ?? null;
                                    if(!f) return;
                                    if (this.prevUrl) { URL.revokeObjectURL(this.prevUrl); this.prevUrl = ''; }
                                    this.file = f;
                                    this.name = f.name;
                                    this.sizeMb = (f.size / 1024 / 1024).toFixed(2);
                                    this.type = f.type;
                                    this.url = URL.createObjectURL(f);
                                    this.prevUrl = this.url;
                                },
                                clear() {
                                    if (this.prevUrl) { URL.revokeObjectURL(this.prevUrl); this.prevUrl = ''; }
                                    this.file = null; this.url = ''; this.name = ''; this.sizeMb = null; this.type = '';
                                    const input = $el.querySelector('input[type=file]');
                                    if (input) input.value = '';
                                }
                             }"
                         x-init="$watch('file', (v) => {})"
                    >
                        <div class="flex-1">
                            <label
                                @class([
                                  'flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer border-gray-300 bg-gray-100 hover:bg-gray-200'
                                ])
                                for="dropzone-file-{{ $key }}"
                                :class="{'border-red-400': @js($errors->has('files.' . $key))}">
                                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                    <template x-if="url && type.startsWith('image/')">
                                        <img :src="url" alt="Preview" class="w-16 h-16 rounded-md object-cover">
                                    </template>

                                    <template x-if="url && !type.startsWith('image/')">
                                        <div class="flex flex-col">
                                            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="1.5" d="M7 7h10v10H7z"/>
                                                </svg>
                                                <div class="text-sm text-gray-700 font-medium" x-text="name"></div>
                                            </div>
                                            <div class="text-xs text-gray-500"
                                                 x-text="sizeMb ? sizeMb + ' MB' : ''"></div>
                                        </div>
                                    </template>

                                    <template x-if="!url">
                                        <div class="text-gray-600">
                                            <div class="font-semibold">بارگذاری فایل</div>
                                            <div class="text-xs hidden md:block">PDF, PNG, JPG, DOCX (حداکثر ۴
                                                مگابایت)
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <input id="dropzone-file-{{ $key }}" class="hidden" type="file"
                                       wire:model="files.{{ $key }}"
                                       x-on:change="setFile($event)"
                                       wire:key="files-input-{{ $key }}"/>
                            </label>

                            @error('files.' . $key)
                            <div aria-live="polite"
                                 class="mb-4 p-3 rounded border-l-4 bg-red-50 text-red-700">
                                <div class="font-semibold mb-1">خطا در آپلود فایل</div>
                                <div class="text-sm">
                                    این فایل امکان ارسال ندارد. درصورت تمایل برای ارسال آن، لطفاً فرمت و یا حجم آنرا را
                                    بررسی کنید.
                                </div>
                            </div>
                            @enderror
                        </div>

                        <div class="flex flex-col items-center mr-3 rtl:mr-0 rtl:ml-3 space-y-2">
                            <button type="button"
                                    x-show="url"
                                    x-on:click.prevent="window.open(url, '_blank')"
                                    class="px-3 py-1 text-sm border rounded hover:bg-gray-100"
                                    title="مشاهده فایل">
                                <i class="fa fa-eye"></i>
                            </button>

                            <a x-show="url" :href="url" :download="name"
                               class="px-3 py-1 text-sm border rounded hover:bg-gray-100"
                               title="دانلود فایل">
                                <i class="fa fa-download"></i>
                            </a>

                            @if($index > 0)
                                <button type="button" wire:click="removeFileInput('{{ $key }}')" class="text-red-500"
                                        title="حذف فایل">
                                    <i class="fa fa-trash"></i>
                                </button>
                            @endif
                        </div>
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
                <span wire:loading.remove wire:target="submitTicket">ثبت تیکت
                    <i class="fa fa-paper-plane mr-2"></i></span>
            <span wire:loading
                  wire:target="submitTicket">
                <i class="fas fa-spinner fa-spin"></i> ارسال...
            </span>
        </button>
    </div>
</div>


