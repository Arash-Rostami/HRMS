<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/"b  >
                <x-entry.signup-logo class="w-20 h-20 fill-current"/>
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
            <div class="relative mt-2">
                <x-label class="main-color" for="email" :value="__('Email')"/>
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                         required autofocus/>
                <i class="fas fa-envelope absolute top-2/3 right-0 -translate-y-1/2 px-3 text-gray-400 hover:text-gray-800 transition-colors duration-300"></i>
            </div>

            <!-- Password -->
            <div class="mt-4 relative">
                <x-label class="main-color" for="password" :value="__('Password')"/>
                <x-input id="password"
                         class="block mt-1 w-full pr-10"
                         type="password"
                         name="password"
                         required
                         autocomplete="current-password"/>
                <button type="button"
                        id="togglePassword"
                        class="absolute top-2/3 right-0 -translate-y-1/2 px-3 text-gray-400 hover:text-gray-800 transition-colors duration-300">
                    <i class="fas fa-eye"></i>
                </button>
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
            <div class="flex justify-center">
                <x-button class="w-1/2 text-gray-300 bg-main-mode hover:opacity-60 flex justify-center shadow-xl"
                          type="submit" id="submitButton" title=" 🔑 ورود">
                    <i class="fas fa-sign-in-alt text-larger"></i>
                </x-button>
                <div id="spinner" class="hidden ml-3 text-xs text-gray-300">
                    <i class="fas fa-spinner fa-spin text-larger"></i> logging in...
                </div>
            </div>
            <!-- Divider -->
            <div class="border-t border-gray-300 opacity-30 my-3"></div>
            <!-- Extra actions -->
            <div class="flex justify-center gap-3 w-1/2 mx-auto">
                <x-button
                    class="text-gray-500 hover:text-gray-300 bg-main-mode hover:opacity-60 w-full flex justify-center shadow-xl"
                    title="🥴 رمز را فراموش کردم"
                    onclick="event.preventDefault();location.href='{{ route('password.request') }}'">
                    <i class='fas fa-lock-open text-larger'></i>
                </x-button>
                <x-button class="text-gray-300 bg-main-mode hover:opacity-60 w-full flex justify-center shadow-xl"
                          title="📞 ورود با پیامک از طریق موبایل "
                          onclick="event.preventDefault();location.href='{{ route('otp.handle') }}'">
                    <i class="fas fa-mobile-alt text-larger"></i>
                </x-button>
                <x-button
                    class="text-gray-500 hover:text-gray-300 bg-main-mode hover:opacity-60 w-full flex justify-center shadow-xl"
                    title=" 📝 ثبت نام کاربر جدید"
                    onclick="event.preventDefault();location.href='{{ route('register') }}'">
                    <i class="fas fa-user-plus text-larger"></i>
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>

<script>
    const form = document.getElementById('loginForm');
    const button = document.getElementById('submitButton');
    const spinner = document.getElementById('spinner');
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    form.addEventListener('submit', function () {
        button.style.display = 'none';
        spinner.classList.remove('hidden');
    });


    togglePassword.addEventListener('click', () => {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        togglePassword.innerHTML =
            type === 'password'
                ? '<i class="fas fa-eye"></i>'
                : '<i class="fas fa-eye-slash"></i>';
    });
</script>
