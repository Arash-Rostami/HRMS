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
            <div dir="rtl" role="region" aria-label="راهنما" @class([
                        "mt-4 p-4 rounded-2xl border shadow-sm",
                        "border-yellow-300 bg-yellow-50 text-yellow-900" => !isDarkMode(),
                        "border-yellow-600 bg-yellow-900/20 text-yellow-100" => isDarkMode(),
                    ])>
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <i class="fa fa-exclamation-triangle text-xl" aria-hidden="true"></i>
                        <div>
                            <h3 class="text-base font-extrabold leading-tight">توجه بسیار مهم</h3>
                        </div>
                    </div>
                    <span
                        class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium ring-1 ring-inset"
                      @class([
                        "bg-yellow-100 text-yellow-800 ring-yellow-200" => !isDarkMode(),
                        "bg-yellow-700/30 text-yellow-100 ring-yellow-600/40" => isDarkMode(),
                      ])>یک‌بار آپلود</span>
                </div>

                <ul class="mt-4 list-inside list-disc space-y-2 text-sm">
                    <li class="leading-tight">
                        <strong class="tracking-wide">یکبار آپلود:</strong>
                        پس از تأیید فایل، امکان تغییر یا حذف وجود ندارد. قبل از آپلود فایل را کنترل کنید.
                    </li>
                    <li class="leading-tight">
                        <strong class="tracking-wide">تعویض از طریق واحد اداری:</strong>
                        برای اصلاح یا جایگزینی فایل، صرفاً از مسیر اداری اقدام نمایید.
                    </li>
                    <li class="leading-tight">
                        <strong class="tracking-wide">ادغام صفحات:</strong>
                        اگر مدارک چندصفحه‌ای‌اند، پیش از آپلود آن‌ها را در یک فایل واحد ادغام کنید.
                    </li>
                </ul>
                <div class="mt-4 pt-4 border-t" @class([
                        "border-yellow-200" => !isDarkMode(),
                        "border-yellow-700/40" => isDarkMode(),
                    ])>
                    <div class="flex items-center gap-3">
                        <i class="fa fa-info-circle text-lg" aria-hidden="true"></i>
                        <h4 class="font-extrabold text-sm">راهنمای دریافت سوابق بیمهٔ تأمین اجتماعی</h4>
                    </div>
                    <ol class="mt-3 list-decimal list-inside space-y-2 text-sm">
                        <li>
                            <strong>ورود به سامانه:</strong>
                            به سایت «سوابق من تأمین اجتماعی» وارد شوید:
                            <a href="https://account.tamin.ir/auth/login"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="ml-1 underline font-semibold"
                                @class([
                                   "text-blue-700 hover:text-blue-900" => !isDarkMode(),
                                   "text-blue-300 hover:text-blue-100" => isDarkMode(),
                               ])>account.tamin.ir</a>
                        </li>
                        <li>
                            <strong>دانلود فایل‌ها:</strong>
                            پس از ورود، هر دو فایل «کلیه سوابق بیمه» و «سابقه بیمه تلفیقی» را دانلود کنید.
                        </li>
                        <li>
                            <strong>نکتهٔ مهم آپلود:</strong>
                            هر دو فایل باید به‌صورت تفکیکی ذخیره و در جای مشخص خود آپلود شوند.
                        </li>
                    </ol>

                    <p class="mt-3 text-xs opacity-90">در صورت نیاز به کمک بیشتر، با واحد اداری تماس بگیرید.</p>
                </div>
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
                    <div class="flex items-start mb-4">
                        <div @class([
                    'benefit-icon w-10 h-10 text-xl flex-shrink-0',
                    'text-cyan-500' => !isDarkMode(),
                    'text-cyan-400' => isDarkMode(),
                ])><i class="fas {{ $doc['icon'] }}"></i>
                        </div>
                        <div class="ml-4 rtl:mr-4 rtl:ml-0">
                            <h3 class="font-bold">{{ $doc['title'] }}</h3>
                            @if(isset($doc['help_text']) && empty($doc['uploaded']))
                                <small @class([
                                        'text-sm',
                                        'text-red-600' => !isDarkMode(),
                                        'text-red-400' => isDarkMode(),
                                    ])>
                                    {{ $doc['help_text'] }}
                                </small>
                            @endif
                        </div>
                    </div>

                    @if($doc['uploaded'])
                        <div class="flex-grow flex flex-col items-center justify-center space-y-4">
                            <div class="text-center p-4 rounded-lg w-full" @class([
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
                            <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                <a href="{{ $doc['file_url'] ?? '#' }}" download @class([
                            'flex-1 text-center font-bold px-4 py-2 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2',
                            'bg-gray-600 hover:bg-gray-700 text-white focus:ring-gray-600' => !isDarkMode(),
                            'bg-gray-500 hover:bg-gray-600 text-white focus:ring-gray-500' => isDarkMode(),
                        ])>
                                    <i class="fas fa-download ml-2"></i>
                                    دانلود
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="flex-grow flex items-center justify-center">
                            <div class="w-full text-center my-auto"
                                 x-data="{
                             fileName: '',
                             previewUrl: '',
                             handleFileSelect(event) {
                                 if (this.previewUrl) {
                                     URL.revokeObjectURL(this.previewUrl);
                                 }
                                 const file = event.target.files[0];
                                 if (!file || file.size > 5242880) {
                                     this.fileName = '';
                                     this.previewUrl = '';
                                     event.target.value = null;
                                     return;
                                 }
                                 this.fileName = file.name;
                                 if (['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf'].includes(file.type)) {
                                     this.previewUrl = URL.createObjectURL(file);
                                 } else {
                                     this.previewUrl = '';
                                 }
                             }
                         }">
                                <input
                                    type="file"
                                    class="hidden"
                                    id="file-{{ $doc['key'] }}"
                                    wire:model="file.{{ $doc['key'] }}"
                                    @change="handleFileSelect($event)"
                                    accept=".pdf,.jpg,.jpeg,.png"
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
                                   class="h-5 text-center mt-2 truncate"
                                   @class(['text-gray-600' => !isDarkMode(),'text-gray-400' => isDarkMode()])
                                   x-cloak>
                                </p>
                                <div class="flex items-center space-x-2 rtl:space-x-reverse mt-2" x-show="fileName"
                                     x-cloak>
                                    <a x-show="previewUrl"
                                       :href="previewUrl"
                                       target="_blank"
                                        @class([
                                            'flex-1 text-center font-bold px-4 py-2 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2',
                                            'bg-sky-600 hover:bg-sky-700 text-white focus:ring-sky-600' => !isDarkMode(),
                                            'bg-sky-500 hover:bg-sky-600 text-white focus:ring-sky-500' => isDarkMode(),
                                        ])>
                                        <i class="fas fa-eye ml-1"></i>
                                        پیش‌نمایش
                                    </a>
                                    <button
                                        type="button"
                                        wire:click="showUploadConfirmation('{{ $doc['key'] }}')"
                                        class="flex-1 font-bold px-4 py-2 rounded-lg transition-colors bg-main-theme hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-main-theme">
                                        بارگذاری نهایی
                                    </button>
                                </div>
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
