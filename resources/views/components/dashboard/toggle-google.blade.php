@props(['translatePage'])

<button @click="location.href='?translatePage={{ !$translatePage }}'"
        class="button user-panel-badge px-2 py-1 rounded md:w-1/6 mx-auto scale-[0.8] box-shadow-customized @if ( isDarkMode())text-gray-300 @endif">
    @if (!$translatePage)
        Need translation? <i class="fa fa-thumbs-up"></i>
    @else
        No, no, just revert <i class="fa fa-thumbs-down"></i>
    @endif

</button>
@if ($translatePage)
    <x-notification-modal/>
    <x-user.google-translate/>
@endif
