<div x-data="{
        canProceed: @entangle('canProceed').defer,
        canSubmit: @entangle('canSubmit').defer,
        step: @entangle('step'),
        categoryKeys: @js($categoryKeys),
        prompts: @js($prompts),
        sections: @js($sections),
        activeTab: 'survey',

        get nextTitle() {
            if (!this.canProceed) return 'ابتدا گزینه (های) مورد نظر را انتخاب نموده';

            const nextStepIndex = this.step;
            if (nextStepIndex >= this.categoryKeys.length) return 'پایان';

            const nextCatKey = this.categoryKeys[nextStepIndex];
            return 'رفتن به سوالات دسته بندی ' + this.sections[nextCatKey];
        },
        get previousTitle() {
            const prevStepIndex = this.step - 2;
            if (prevStepIndex < 0) return 'ابتدا';

            const prevCatKey = this.categoryKeys[prevStepIndex];
            return 'بازگشت به سوالات دسته بندی ' + this.sections[prevCatKey];
        },
        animateCheckbox(el) {
            el.style.transform = 'scale(1.1)';
            setTimeout(() => el.style.transform = 'scale(1)', 150);
        },
        animateButton(el, fromColor, toColor) {
            el.style.backgroundColor = fromColor;
            setTimeout(() => el.style.backgroundColor = toColor, 150);
        }
}">
    {{--    Tab selectors --}}
    <div class="w-1/2 mx-auto border border-dotted border-b-1 border-t-0 border-l-0 border-r-0 pb-1">
        <ul class="mx-auto flex justify-around">
            <li>
                <button
                    title="پرسشنامه"
                    @click="activeTab = 'survey'"
                    :class="{ 'bg-main-mode text-white': activeTab === 'survey', 'bg-gray-200 text-gray-700': activeTab !== 'survey' }"
                    class="px-4 py-2 rounded-md shadow focus:outline-none">
                    <i class="fas fa-poll-h"></i>
                </button>
            </li>
            <li>
                <button
                    title="آمار"
                    @click="activeTab = 'chart'"
                    :class="{ 'bg-main-mode text-white': activeTab === 'chart', 'bg-gray-200 text-gray-700': activeTab !== 'chart' }"
                    class="px-4 py-2 rounded-md shadow focus:outline-none">
                    <i class="fas fa-chart-bar"></i>
                </button>
            </li>
        </ul>
    </div>

    {{--    Tab panel --}}
    <div class="flex flex-col"
         x-show="activeTab === 'survey'"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        @include('components.user.energy.' . ($showSurvey ? 'test' : 'block'))
    </div>
    <div class="flex flex-col"
         x-show="activeTab === 'chart'"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        @livewire('energy-chart')
    </div>
</div>
