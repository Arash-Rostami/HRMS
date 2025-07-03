<div
    class="transition-opacity duration-150 ease-linear data-[te-tab-active]:block data-[te-tab-active]:opacity-100 p-2 pr-4 persol-farsi-font animate-[fade-in_1s_ease-in-out]"
    dir="rtl"
    id="pills-documents"
    role="tabpanel"
    aria-labelledby="pills-documents"
>
    <div class="documents-bg">
        <div class="mb-8">
            <h2 class="text-main font-bold mb-2">بارگذاری مدارک پرسنلی</h2>
            <p @class(['text-gray-600' => !isDarkMode(),'text-gray-400' => isDarkMode() ])>
                لطفاً مدارک مورد نیاز زیر را با دقت بارگذاری نمایید. این مدارک برای تکمیل پرونده پرسنلی شما ضروری است.
            </p>
            <div @class([
                    "mt-4 p-4 rounded-lg border border-yellow-500/50",
                    "text-yellow-800 bg-yellow-400/20"  => !isDarkMode(),
                    "text-gray-900 bg-yellow-400/20"  => isDarkMode(),
                ])>
                <i class="fa fa-exclamation-triangle ml-2"></i>
                <span class="font-extrabold">توجه بسیار مهم:</span>
                <ul class="mt-2 list-disc list-inside space-y-1">
                    <li><strong class="tracking-wide">یک‌بار آپلود:</strong>
                        پس از تأیید، امکان تغییر یا حذف فایل وجود ندارد. قبل از آپلود مطمئن شوید فایل صحیح را انتخاب
                        کرده‌اید.
                    </li>
                    <li>
                        <strong class="tracking-wide">تعویض از طریق واحد اداری:</strong>
                        برای اصلاح یا جایگزینی فایل، صرفاً از مسیر اداری اقدام نمایید.
                    </li>
                    <li>
                        <strong class="tracking-wide">ادغام صفحات:</strong>
                        اگر مدارک چندصفحه‌ای‌اند, پیش از آپلود آن‌ها را در یک فایل واحد ادغام کنید.
                    </li>
                </ul>
            </div>
            @if($errorMessage)
                <div class="text-red-600 mt-2">{{ $errorMessage }}</div>
            @endif
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($documents as $doc)
                <div @class([
                    'p-5 rounded-lg border shadow-sm flex flex-col',
                    'bg-white border-gray-100' => !isDarkMode(),
                    'text-gray-300 bg-gray-800 border-gray-700' => isDarkMode(),
                ])>
                    <div class="flex items-center mb-4">
                        <div @class([
                            'benefit-icon w-10 h-10 text-xl',
                            'text-cyan-500' => !isDarkMode(),
                            'text-cyan-400' => isDarkMode(),
                        ])><i class="fas {{ $doc['icon'] }}"></i>
                        </div>
                        <h3 class="font-bold">{{ $doc['title'] }}</h3>
                    </div>
                    @if($doc['uploaded'])
                        <div class="flex-grow flex items-center justify-center">
                            <div class="text-center p-4 rounded-lg" @class([
                                'bg-green-50'    => !isDarkMode(),
                                'bg-green-800/20' => isDarkMode(),
                            ])>
                                <i class="fas fa-check-circle text-green-500 text-3xl mb-2 inline-block"></i>
                                <p class="font-semibold" @class([
                                    'text-gray-800' => !isDarkMode(),
                                    'text-gray-200' => isDarkMode(),
                                ])>فایل بارگذاری شد
                                    @if($doc['uploadedTime'])
                                        <span class="inline-block">
                                            در: <span dir="ltr"> {{ $doc['uploadedTime'] }}</span>
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex-grow flex items-center justify-center">
                            <div class="w-full text-center my-auto"
                                 x-data="{ fileName: '' }">
                                <input
                                    type="file"
                                    class="hidden"
                                    id="file-{{ $doc['key'] }}"
                                    wire:model="file.{{ $doc['key'] }}"
                                    @change="$event.target.files[0].size < 5242880 ? fileName = $event.target.files[0]?.name || '' : '';"
                                />
                                <label
                                    for="file-{{ $doc['key'] }}"
                                    @class([
                                        'w-full text-center cursor-pointer px-4 py-2 rounded-lg transition-colors border-2 border-dashed',
                                        'bg-gray-50 hover:bg-gray-100 border-gray-300 text-gray-700' => !isDarkMode(),
                                        'bg-gray-700/50 hover:bg-gray-700 border-gray-600 text-gray-300' => isDarkMode(),
                                    ])
                                ><i class="fas fa-cloud-upload-alt ml-2"></i>
                                    انتخاب فایل
                                </label>
                                <p x-show="fileName"
                                   x-text="fileName"
                                   class="h-5 text-center mt-2"
                                   @class(['text-gray-600' => !isDarkMode(),'text-gray-400' => isDarkMode()])
                                   x-cloak>
                                </p>
                                <button
                                    type="button"
                                    wire:click="showUploadConfirmation('{{ $doc['key'] }}')"
                                    x-show="fileName"
                                    class="w-full font-bold px-4 py-2 rounded-lg transition-colors bg-main-theme hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-main-theme mt-2"
                                    x-cloak>
                                    بارگذاری نهایی
                                </button>
                                <!-- Upload Confirmation Modal -->
                                @error("file.{$doc['key']}")
                                <div class="mt-3 text-red-500">
                                    {{ Str::contains($message, 'failed to upload') ? 'حجم فایل نباید بیشتر از 5 مگابایت باشد' : $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @include('components.user.onboarding.confirmation')
</div>
