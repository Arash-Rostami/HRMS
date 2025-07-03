<div class="hidden  transition-opacity duration-150 ease-linear data-[te-tab-active]:block data-[te-tab-active]:opacity-100
p-2 pr-4 persol-farsi-font animate-[fade-in_1s_ease-in-out]"
     dir="rtl"
     id="pills-accounts"
     role="tabpanel"
     aria-labelledby="pills-accounts">
    <div class="accounts-bg">
        <div class="mb-8">
            <h2 class="text-main font-bold mb-2">اطلاعات ورود به سامانه‌ها</h2>
            <p @class(['text-gray-600' => !isDarkMode(), 'text-gray-400' => isDarkMode()])>
                اطلاعات کاربری شما برای ورود به سامانه‌های مختلف سازمانی در این بخش قرار داده شده است.
            </p>
            <p class="text-red-500 mt-4 p-3 rounded-lg bg-red-500/10">
                <i class="fa fa-exclamation-triangle ml-2"></i>
                <span class="font-bold">مهم:</span>
                به‌منظور حفظ امنیت اطلاعات، لطفاً این داده‌ها را کاملاً محرمانه نگه‌داشته و از اشتراک‌گذاری آن‌ها با
                سایر همکاران جددا خودداری نمایید.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse(auth()->user()->appCredentials as $app)
                <div @class([
                        'p-5 rounded-lg border shadow-lg flex flex-col',
                        'bg-white border-gray-100' => !isDarkMode(),
                        'text-gray-300 bg-gray-800 border-gray-700' => isDarkMode(),
                       ])>
                    {{-- Card Header --}}
                    <div class="flex items-center mb-4">
                        <div @class([
                                'benefit-icon w-10 h-10 text-xl',
                                'text-indigo-500' => !isDarkMode(),
                                'text-indigo-400' => isDarkMode(),
                               ])>
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <h3 class="font-bold text-lg">{{ $app->app_name }}</h3>
                    </div>

                    {{-- Card Body --}}
                    <div class="space-y-3 flex-grow">
                        {{-- Username --}}
                        <div class="flex justify-between items-center" x-data="{ copiedUsername: false }">
                            <span @class(['text-gray-500' => !isDarkMode(), 'text-gray-400' => isDarkMode()])>
                                حساب کاربری:
                            </span>
                            <div class="flex items-center gap-x-2">
                                <span class="font-semibold tracking-wider">{{ $app->username }}</span>

                                @if($app->username !== '-')
                                    <button
                                        @click="
                                        navigator.clipboard.writeText('{{ $app->username }}');copiedUsername = true;setTimeout(() => copiedUsername = false, 2000);"
                                        title="کپی کردن نام کاربری"
                                        @class(['text-main hover:text-blue-400' => !isDarkMode(), 'text-main hover:text-yellow-400' => isDarkMode()])>
                                        <i class="far fa-copy" x-show="!copiedUsername"></i>
                                        <i class="fas fa-check text-green-500" x-show="copiedUsername" x-cloak
                                           x-transition.opacity.duration.500ms></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        {{-- Password --}}
                        <div class="flex justify-between items-center" x-data="{ copied: false, showPassword: false }">
                            <span @class(['text-gray-500' => !isDarkMode(), 'text-gray-400' => isDarkMode()])>رمز عبور:</span>
                            <div class="flex items-center gap-x-3">
                                <span x-show="!showPassword"
                                      class="font-semibold tracking-widest text-lg">********</span>
                                <span x-show="showPassword" x-cloak
                                      class="font-semibold tracking-wider">{{ $app->password }}</span>

                                @if($app->password !== '-')
                                    {{-- Action Buttons --}}
                                    <div class="flex items-center gap-x-2">
                                        {{-- Toggle Visibility Button --}}
                                        <button
                                            @click="showPassword = !showPassword"
                                            title="نمایش/مخفی کردن"
                                            @class(['text-main hover:text-blue-400' => !isDarkMode(), 'text-main hover:text-yellow-400' => isDarkMode()])>
                                            <i class="far fa-eye" x-show="!showPassword"></i>
                                            <i class="far fa-eye-slash" x-show="showPassword" x-cloak></i>
                                        </button>

                                        {{-- Copy Button --}}
                                        <button
                                            @click="navigator.clipboard.writeText('{{ $app->password }}'); copied = true; setTimeout(() => copied = false, 2000);"
                                            title="کپی کردن رمز عبور"
                                            @class(['text-main hover:text-blue-400' => !isDarkMode(), 'text-main hover:text-yellow-400' => isDarkMode()])>
                                            <i class="far fa-copy" x-show="!copied"></i>
                                            <i class="fas fa-check text-green-500" x-show="copied" x-cloak
                                               x-transition.opacity.duration.500ms></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>


                        {{-- Note --}}
                        @if($app->note)
                            <div class="pt-2 text-sm text-gray-500 border-t border-gray-200/50">
                                <i class="fa fa-info-circle ml-1"></i> {{ $app->note }}
                            </div>
                        @endif
                    </div>

                    {{-- Card Footer (Link) --}}
                    @if($app->link)
                        <div class="mt-4 pt-4 border-t border-dashed"
                            @class(['border-gray-200' => !isDarkMode(), 'border-gray-700' => isDarkMode()])>
                            <a href="{{ $app->link }}"
                               target="_blank"
                                @class([
                                     'block text-center w-full px-4 py-2 rounded-lg transition-colors',
                                     'bg-gray-100 hover:bg-gray-200 text-gray-800' => !isDarkMode(),
                                     'bg-gray-700 hover:bg-gray-600 text-gray-200' => isDarkMode()
                                ])>
                                ورود به سامانه
                                <i class="fa fa-external-link-alt mr-2"></i>
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="md:col-span-2 text-center py-16 px-6 rounded-lg border-2 border-dashed"
                    @class([
                           'bg-gray-50 border-gray-200 text-gray-500' => !isDarkMode(),
                           'bg-gray-800/50 border-gray-700 text-gray-500' => isDarkMode()
                       ])
                >
                    <i class="fas fa-eye-slash fa-3x mb-4"></i>
                    <h3 class="text-xl font-bold mb-2"
                        @class(['text-gray-700' => !isDarkMode(), 'text-gray-300' => isDarkMode()])>
                        اطلاعاتی برای نمایش وجود ندارد
                    </h3>
                    <p>در حال حاضر، هیچ حساب کاربری برای سامانه‌ها توسط ادمین برای شما تعریف نشده است.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
