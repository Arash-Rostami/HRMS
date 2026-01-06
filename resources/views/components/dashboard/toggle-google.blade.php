@props(['translatePage'])

<button @click="location.href='?translatePage={{ !$translatePage }}'"
    @class([
           'button user-panel-badge px-4 py-1 rounded md:w-auto mx-auto scale-[0.8] box-shadow-customized
            group relative overflow-hidden rounded-lg hover:from-[#4a8a8a] hover:via-[#5a6a7a] hover:to-[#4f6873]
            shadow-[0_8px_32px_rgba(94,161,161,0.25)] hover:shadow-[0_12px_48px_rgba(94,161,161,0.35)]
            transform hover:scale-[0.9] active:scale-[0.85] transition-all duration-300 ease-out',
           'bg-main-mode'=> !isDarkMode(),
           'from-gray-700 via-gray-800 to-gray-900 hover:from-gray-600 hover:via-gray-700 hover:to-gray-800
            shadow-[0_8px_32px_rgba(0,0,0,0.4)] hover:shadow-[0_12px_48px_rgba(0,0,0,0.6)] text-gray-300' => isDarkMode(),
       ])
>
    @if (!$translatePage)
        <span class="translate-toggle" title="در صورت نیاز، ترجمه فعال شود">
        <i class="fa fa-language" aria-hidden="true"></i>
                        <hr/>

        <i class="fa fa-toggle-on mx-2" aria-hidden="true" style="color:red!important;"></i>
    </span>
    @else
        <span class="translate-toggle" title="ترجمه فعال است، برای بازگشت کلیک کنید">
        <i class="fa fa-language" aria-hidden="true"></i>
            <hr/>
        <i class="fa fa-toggle-off mx-2" aria-hidden="true" style="color:green!important;"></i>
    </span>
    @endif

</button>
@if ($translatePage)
    <x-notification-modal/>
    <x-user.google-translate/>
@endif
