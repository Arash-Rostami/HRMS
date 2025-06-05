<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-signup-logo class="w-20 h-20 fill-current"/>
            </a>
        </x-slot>

        <!-- Form Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Forename -->
            <div>
                <x-label class="main-color" for="forename" :value="__('Forename')"/>

                <x-input id="foremane" class="block mt-1 w-full" type="text" name="forename" :value="old('forename')" required
                         autofocus/>
            </div>

            <!-- Surname -->
            <div>
                <x-label class="main-color" for="surname" :value="__('Surname')"/>

                <x-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" required
                         autofocus/>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label class="main-color" for="email" :value="__('Email')"/>

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required/>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label class="main-color" for="password" :value="__('Password')"/>

                <x-input id="password" class="block mt-1 w-full"
                         type="password"
                         name="password"
                         required autocomplete="new-password"></x-input>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label class="main-color" for="password_confirmation" :value="__('Confirm Password')"/>

                <x-input id="password_confirmation" class="block mt-1 w-full"
                         type="password"
                         name="password_confirmation" required/>
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-button class="ml-3" title="Log me in"
                          onclick="event.preventDefault();location.href='{{ route('login') }}'">
                        <i class="fas fa-backward text-larger text-gray-300"></i>
                </x-button>


                <x-button class="ml-4" title="Sign me up">
                    <i class="fa fa-plus text-larger text-gray-300"></i>
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
