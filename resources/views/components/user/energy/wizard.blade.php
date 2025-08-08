@php
    $cat = $categoryKeys[$step - 1];
    $qs = $questions[$cat];
    $lastIdx = count($qs) - 1;
@endphp
{{-- Progress bar --}}
<div class="text-center mt-8 font-semibold text-gray-700" dir="ltr">
    {{ $step }} / {{ $totalSteps }}
</div>
<div class="w-2/3 mx-auto bg-gray-200 rounded-full h-2.5 shadow-inner mt-4">
    <div
        title="{{  ceil($progress) }}٪ تکمیل"
        class="bg-main-mode h-3.5 rounded-full transition-all duration-700 ease-out shadow-sm cursor-help"
        style="width: {{ $progress }}%"></div>
</div>

{{-- Question title --}}
<h1 class="mt-16 mb-8 font-bold text-gray-800 transition-all duration-500 ease-in-out">
    {{ $prompts[$cat] }}
</h1>
{{-- Multiple choices --}}
@foreach($qs as $idx => $question)
    <div class="mt-3 transform transition-all duration-300 hover:translate-x-1">
        <label class="flex items-center cursor-pointer p-3 rounded-lg transition-all duration-300 group">
            <input type="checkbox"
                   wire:model="answers.{{ $cat }}.{{ $idx }}"
                   @click="animateCheckbox($event.target)"
                   class="form-checkbox h-5 w-5 text-{{ $idx === $lastIdx ? 'green' : 'red' }}-600 cursor-pointer transform transition-all duration-200 ease-out focus:ring-blue-500 focus:ring-offset-0 hover:scale-110">

            <span @class([
                        'mr-3',
                        'select-none',
                        'transition-all',
                        'duration-300',
                        'font-semibold' => $idx === $lastIdx,
                    ])>
                    {{ $question }}
                </span>
        </label>
    </div>
@endforeach

{{-- Navigation buttons --}}
<div class="flex justify-between mt-8 gap-4">
    <button wire:click="previousStep"
            :title="previousTitle"
            :disabled="$wire.step === 1"
            @click="animateButton($event.target, '#1d4ed8', '#3b82f6')"
            class="px-4 py-2 bg-main-mode text-white rounded-lg cursor-pointer transform transition-all
            duration-300 ease-in-out hover:bg-blue-600 hover:shadow-lg hover:-translate-y-0.5
            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50
             disabled:cursor-not-allowed disabled:hover:transform-none">
        <span> « </span>
    </button>
    @if($step < $totalSteps)
        <button wire:click="nextStep"
                :title="nextTitle"
                :disabled="!canProceed"
                @click="animateButton($event.target, '#1d4ed8', '#3b82f6')"
                class="px-4 py-2 bg-main-mode text-white rounded-lg cursor-pointer transform transition-all
                duration-300 ease-in-out hover:bg-blue-600 hover:shadow-lg hover:-translate-y-0.5 focus:outline-none
                 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed
                 disabled:hover:transform-none">
            <span> » </span>
        </button>
    @else
        <button wire:click="submitTest"
                :disabled="!canSubmit"
                @click="animateButton($event.target, '#15803d', '#22c55e')"
                class="px-4 py-2 bg-green-500 text-white rounded-lg cursor-pointer transform transition-all
                 duration-300 ease-in-out hover:bg-green-600 hover:shadow-lg hover:-translate-y-0.5 focus:outline-none
                 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed
                  disabled:hover:transform-none">
            <span wire:loading wire:target="submitTest"><i class="fas fa-spinner fa-spin"></i></span>
            <span wire:loading.remove wire:target="submitTest">ارسال<i class="fas fa-check mr-2"></i></span>
        </button>
    @endif
</div>
