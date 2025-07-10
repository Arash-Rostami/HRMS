<div class="my-auto flex items-center"
     title="{{ config('app.name') }}">
    <img
        width="25"
        alt="{{ config('app.name') }} logo"
        class="-ml-1"
        src="{{ asset(isAdminPage()
            ? 'img/logo-light-persol.svg'
            : 'img/logo-dark-persol.svg') }}"
    >
    <img
        width="45"
        alt="PERSOL logo"
        class="p-2 -mr-1"
        src="{{ asset('img/persol-sms-logo-admin.png') }}"
    >
</div>
