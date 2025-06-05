<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-signup-logo class="w-20 h-20 fill-current"/>
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>

        <!-- Form Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            <div class="secureTip text-xs text-gray-500 text-right">
                <small>
                    Secure.<br>We use HTTPS to protect your information.
                </small>
            </div>

            <!-- Email Address -->
            <div>
                <x-label class="main-color" for="email" :value="__('Email')"/>
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                         required
                         autofocus/>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label class="main-color" for="password" :value="__('Password')"/>
                <x-input id="password" class="block mt-1 w-full"
                         type="password"
                         name="password"
                         required autocomplete="current-password"/>
            </div>

            <!-- Remember Me -->
            <div class="block mt-4 main-color">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                           class="rounded border-gray-300 main-color shadow-sm focus:border-main focus:ring focus:ring-main focus:ring-opacity-50"
                           name="remember">
                    <span class="ml-2 text-sm text-gray-400">{{ __('Remember me') }}</span>
                </label>
                <br>
            </div>
            <div class="flex items-center justify-center m-4"></div>

            <!-- Submit Button and Spinner -->
            <div class="flex items-center justify-between md:justify-end md:gap-x-4">
                <x-button class="text-gray-300" title="Log me in 🔑" type="submit" id="submitButton">
                    <i class="fas fa-sign-in-alt text-larger"></i>
                </x-button>

                <div id="spinner" class="hidden text-xs">
                    <i class="fas fa-spinner fa-spin text-gray-300 text-larger"></i> logging in ...
                </div>

                <div class="border-r-2 border-slate-100 h-8"></div>

                @if (Route::has('password.request'))
                    <x-button class="text-gray-500 hover:text-gray-300" title="Forgot password? 🥴"
                              onclick="event.preventDefault();location.href='{{ route('password.request') }}'">
                        <i class='fas fa-lock-open text-larger'></i>
                    </x-button>
                @endif

                <x-button class="text-gray-500 hover:text-gray-300" title="Sign me up 📝"
                          onclick="event.preventDefault();location.href='{{ route('register') }}'">
                    <i class="fas fa-user-plus text-larger"></i>
                </x-button>

                <x-button class="text-gray-300" title="Log me in via 📞"
                          onclick="event.preventDefault();location.href='{{ route('otp.handle') }}'">
                    <i class="fas fa-mobile-alt text-larger"></i>
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>

<script>
    const form = document.getElementById('loginForm');
    const button = document.getElementById('submitButton');
    const spinner = document.getElementById('spinner');

    form.addEventListener('submit', function () {
        button.style.display = 'none';
        spinner.classList.remove('hidden');
    });
</script>

<style>
    .hidden {
        display: none;
    }
</style>
