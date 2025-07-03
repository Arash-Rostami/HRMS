{{--  Stepper for desktop view--}}
<div class="hidden md:block md:w-[15%]">
    <ol class="relative text-gray-500 border-r border-gray-500">
        <li class="mb-12 mr-6">
                    <span
                        title="{{ $stepCompletionStatus[1] ?  'تکمیل شده - اطلاعات شغلی': 'مرا به مرحله ۱ ببر - اطلاعات شغلی' }}"
                        class="absolute cursor-pointer flex items-center justify-center w-8 h-8 rounded-full -right-4 ring-4
                        {{ $stepCompletionStatus[1] ? 'bg-main-mode' : (isDarkMode() ? 'bg-gray-700' :'bg-gray-300') }}"
                        x-on:click="$refs.step1.scrollIntoView({ behavior: 'smooth' }); ">
                        <i @class([
                                'fas fa-briefcase text-white',
                                'text-gray-500' => isDarkMode()
                            ])></i>
                    </span>
            <h3 class="font-medium leading-tight">گام ۱:</h3>
            <p>اطلاعات شغلی</p>
        </li>
        <li class="mb-12 mr-6">
                    <span
                        title=" {{ $stepCompletionStatus[2] ?  'تکمیل شده - اطلاعات شخصی' : 'مرا به مرحله ۲ ببر - اطلاعات شخصی'}}"
                        class="absolute cursor-pointer flex items-center justify-center w-8 h-8 rounded-full -right-4 ring-4 {{ $stepCompletionStatus[2] ? 'bg-main-mode' : (isDarkMode() ? 'bg-gray-700' :'bg-gray-300') }}"
                        x-on:click="$refs.step2.scrollIntoView({ behavior: 'smooth' }); ">
                        <i @class([
                                    'fas fa-id-card text-white',
                                    'text-gray-500' => isDarkMode()
                                ])></i>
                    </span>
            <h3 class="font-medium leading-tight">گام ۲:</h3>
            <p>اطلاعات شخصی</p>
        </li>
        <li class="mb-12 mr-6">
                    <span
                        title="{{ $stepCompletionStatus[3] ?  'تکمیل شده - اطلاعات تکمیلی' : 'مرا به مرحله ۳ ببر - اطلاعات تکمیلی'}}"
                        class="absolute cursor-pointer bottom-1 flex items-center justify-center w-8 h-8 rounded-full -right-4 ring-4 {{ $stepCompletionStatus[3] ? 'bg-main-mode' : (isDarkMode() ? 'bg-gray-700' :'bg-gray-300') }}"
                        x-on:click="$refs.step3.scrollIntoView({ behavior: 'smooth' }); ">
                        <svg @class([
                                    'w-3.5 h-3.5 text-white',
                                    'text-gray-500' => isDarkMode()
                                ])
                             aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                            <path
                                d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                        </svg>
                    </span>
            <h3 class="font-medium leading-tight">گام ۳:</h3>
            <p>اطلاعات تکمیلی</p>
        </li>
    </ol>
</div>
{{--    Stepper for cellphone view--}}
<div class="flex w-full mx-auto md:hidden pb-2 mb-4 justify-center">
    <ol class="flex w-full items-center">
        <li class="flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-300 after:inline-block dark:after:border-gray-500">
                    <span
                        title="{{ $stepCompletionStatus[1] ?  'تکمیل شده - اطلاعات شغلی': 'مرا به مرحله ۱ ببر - اطلاعات شغلی' }}"
                        class="flex cursor-pointer items-center justify-center w-10 h-10 rounded-full lg:h-12 lg:w-12 shrink-0 {{ $stepCompletionStatus[1] ? 'bg-main-mode' : (isDarkMode() ? 'bg-gray-700' :'bg-gray-300') }}"
                        x-on:click="$refs.step1.scrollIntoView({ behavior: 'smooth' }); ">
                        <i class="fas fa-briefcase"></i>
                    </span>
        </li>
        <li class="flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:inline-block dark:after:border-gray-500">
                    <span
                        title=" {{ $stepCompletionStatus[2] ?  'تکمیل شده - اطلاعات شخصی' : 'مرا به مرحله ۲ ببر - اطلاعات شخصی'}}"
                        class="flex cursor-pointer items-center justify-center w-10 h-10 rounded-full lg:h-12 lg:w-12 shrink-0 {{ $stepCompletionStatus[2] ? 'bg-main-mode' : (isDarkMode() ? 'bg-gray-700' :'bg-gray-300') }}"
                        x-on:click="$refs.step2.scrollIntoView({ behavior: 'smooth' }); ">
                        <i class="fas fa-id-card"></i>
                    </span>
        </li>
        <li class="flex items-center">
                    <span
                        title="{{ $stepCompletionStatus[3] ?  'تکمیل شده - اطلاعات اضافی' : 'مرا به مرحله ۳ ببر - اطلاعات اضافی'}}"
                        class="flex cursor-pointer items-center justify-center w-10 h-10 rounded-full lg:h-12 lg:w-12 shrink-0 {{ $stepCompletionStatus[3] ? 'bg-main-mode' : (isDarkMode() ? 'bg-gray-700' :'bg-gray-300') }}"
                        x-on:click="$refs.step3.scrollIntoView({ behavior: 'smooth' }); ">
                            <svg class="w-3.5 h-3.5" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path
                                    d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                            </svg>
                    </span>
        </li>
    </ol>
</div>
