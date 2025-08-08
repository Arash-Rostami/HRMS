<div class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block
 w-full p-2 pr-4 persol-farsi-font animate-[fade-in_1s_ease-in-out]"
     id="pills-guide"
     role="tabpanel"
     aria-labelledby="pills-guide-tab">

    <div class="p-4 md:p-6 lg:p-8">
        <div class="text-right mb-6 md:mb-10">
            <h2 @class([
                'text-2xl font-bold mb-3',
                'text-gray-100' => isDarkMode(),
                'text-gray-800' => !isDarkMode(),
                ])>
                <i class="fa fa-book-open text-teal-500 ml-2"></i>
                راهنمای اپ HRMS
            </h2>
            <p @class([
                'inline-block text-right text-main',
                'text-gray-400' => isDarkMode(),
                'text-gray-600' => !isDarkMode(),
                ])>
                این راهنما به شما کمک می‌کند تا با قابلیت‌ها و ماژول‌های مختلف سیستم مدیریت منابع انسانی (HRMS) آشنا
                شوید. هر ماژول برای هدف خاصی طراحی شده تا فرآیندها را ساده‌تر و کارآمدتر کند.
            </p>
        </div>

        <div id="accordionModules">
            @php($modules = config('modules'))

            @foreach($modules as $index => $module)
                <div @class(['rounded-lg mb-2', 'bg-gray-700' => isDarkMode(), 'bg-white' => !isDarkMode()])>
                    <h2>
                        <button
                            type="button"
                            data-te-collapse-init
                            data-te-target="#collapse-{{ $module['id'] }}"
                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                            aria-controls="collapse-{{ $module['id'] }}"
                            @class([
                                'group relative flex w-full items-center rounded-t-[15px] border-0 px-5 py-4 text-left text-base transition [overflow-anchor:none] hover:z-[2] focus:z-[3] focus:outline-none',
                                'text-gray-200' => isDarkMode(),
                                'text-neutral-800' => !isDarkMode(),
                            ])>
                            <i class="fa {{ $module['icon'] }} text-teal-500 ml-3 transition-transform duration-300 ease-in-out group-data-[te-collapse-expanded]:rotate-[-360deg]"></i>
                            {{ $module['title'] }}
                            <span
                                class="mr-auto -ml-1 h-5 w-5 shrink-0 rotate-[-180deg] transition-transform duration-200 ease-in-out group-data-[te-collapse-expanded]:mr-0 group-data-[te-collapse-expanded]:rotate-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="h-6 w-6"><path
                                        stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                            </span>
                        </button>
                    </h2>
                    <div
                        id="collapse-{{ $module['id'] }}"
                        class="!visible"
                        data-te-collapse-item
                        data-te-collapse-show
                        aria-labelledby="heading-{{ $module['id'] }}"
                        data-te-parent="#accordionModules">
                        <div @class([
                            'px-5 py-4',
                            'text-gray-300' => isDarkMode(),
                            'text-gray-700' => !isDarkMode(),
                            ])>
                            {{ $module['content'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 md:mt-12 pt-4 md:pt-6 border-t border-gray-700 text-right">
            <p @class([
                'font-medium mb-2 md:mb-4',
                'text-gray-300' => isDarkMode(),
                'text-gray-600' => !isDarkMode(),
                ])>
                امیدواریم این راهنما به شما در استفاده بهینه از امکانات سیستم کمک کند.
                <br>
                <span class="font-bold text-teal-500">در صورت وجود هرگونه مشکل فنی، می‌توانید از ماژول سیستم تیکت استفاده نمایید. </span>
            </p>
        </div>
    </div>
</div>
