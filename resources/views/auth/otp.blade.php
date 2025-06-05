<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-signup-logo class="w-20 h-20 fill-current"/>
            </a>
        </x-slot>

        @if(session('message'))
            <div class="mb-4 text-sm font-medium text-gray-600">
                {{ session('message') }}
            </div>
        @elseif($errors->any())
            <div class="mb-4 text-sm font-medium text-red-600">
                *** {!! $errors->first() !!}
            </div>
        @else
            <div class="mb-4 text-sm font-medium text-gray-600">
                <i class="fas fa-bell text-lg text-gray-700"></i><br>
                OTP Login: we will send a code to your cellphone number.
            </div>
        @endif

        <form method="POST" action="{{ route('otp.handle') }}">
            @csrf

            @if(!session('message'))
                <div id="phone-container" class="mb-4">
                    <x-label class="my-2 main-color" for="phone" :value="__('Write your phone number')"/>
                    <x-input class="block mt-1 w-full py-2 text-center focus:border-main-color"
                             id="phone"
                             type="tel"
                             name="phone"
                             required
                             autofocus
                             pattern="^0\d{10}$"
                             placeholder="___-___-____" />
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-button title="Send the code">
                        <i class="fas fa-paper-plane text-larger text-gray-300"></i>
                    </x-button>
                </div>
            @else
                <div id="code-container" class="mb-4">
                    <x-label class="my-2 main-color" for="code" :value="__('Enter verification code')"/>
                    <div class="flex space-x-2">
                        @for($i = 0; $i < 4; $i++)
                            <x-input class="block mt-1 w-full py-2 text-center focus:border-main-color"
                                     id="code-{{ $i }}"
                                     type="text"
                                     name="code[]"
                                     maxlength="1"
                                     required
                                     autofocus />
                        @endfor
                    </div>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-button title="Verify the code" id="verify-code-button">
                        <i class="fas fa-check text-larger text-gray-300"></i>
                    </x-button>
                </div>
            @endif
        </form>
    </x-auth-card>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputs = document.querySelectorAll('#code-container input[type="text"]');
            const submitButton = document.getElementById('verify-code-button');

            inputs.forEach((input, index) => {
                input.addEventListener('input', () => {
                    let value = input.value;
                    if (value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    } else if (
                        value.length === 1 &&
                        index === inputs.length - 1 &&
                        Array.from(inputs).every(input => input.value !== '')
                    ) {
                        submitButton.click();
                        submitButton.style.display = 'none';
                    }
                });
            });

        });
    </script>
</x-guest-layout>
