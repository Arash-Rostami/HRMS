<img class="inline-block p-2" src="/img/persol-sms-logo-admin.png" width="50" alt="persol-logo" >
<div class="inline-block my-auto" title="{{ config('app.name') }}">
    <img class="relative right-2 top-2"  width="25" alt="new-logo"
         @if(isAdminPage() or isDarkMode())
             src="/img/logo-light-persol.svg"
         @else
             src="/img/logo-dark-persol.svg"
         @endif
        >
</div>

