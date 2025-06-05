<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-signup-logo class="w-20 h-20 fill-current"/>
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-500">
            <i class="fas fa-sync-alt text-lg text-gray-500"></i><br>
            Password Reset: we will email a password reset link to you.
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>

        <!-- Form Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label class="main-color" for="email" :value="__('Your email')"/>

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                         required autofocus></x-input>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-3" title="Email password link">
                    <i class="fas fa-mail-bulk text-larger text-gray-300"></i>
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
