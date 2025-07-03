{{-- Check if there is no profile record --}}
@if (!isset($profile))
    <div class="flex flex-col items-center justify-center w-full mx-auto p-10">
        <i class="fas fa-exclamation-circle text-red-500 text-4xl mb-4"></i>
        <h1 class="text-red-500 text-center font-bold mt-2 mb-4">
            پروفایلی برای شما وجود ندارد!
            <br>
            لطفاً از ادمین بخواهید برای شما پروفایل ایجاد کند.
        </h1>
    </div>
@else
    <div class="flex flex-col md:flex-row w-full mx-auto p-10">
        {{--  Steppers--}}
        <x-user.profile.steppers :stepCompletionStatus="$stepCompletionStatus"/>
        {{--    Form--}}
        <div class="w-full md:w-[85%]">
            <h1 class="mb-8 text-justify">لطفاً اطلاعات پروفایل خود را تا حد امکان دقیق و کامل پر کنید.</h1>
            <!-- Form -->
            <form wire:submit.prevent class="profile-form">
                {{-- Step I --}}
                @include('components.user.profile.step-one')
                {{-- Step II--}}
                @include('components.user.profile.step-two')
                {{-- Step III & Submit--}}
                @include('components.user.profile.step-three')
            </form>
        </div>
    </div>
@endif
