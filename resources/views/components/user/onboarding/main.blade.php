<div
    id="onboarding"
    dir="rtl"
    @class([
        'flex flex-col sm:flex-col flex-grow fade-in-fwd p-4 md:p-8 m-4 md:m-8
         bg-white border-1 shadow-lg rounded-xl main-user-accordion-panel persol-farsi-font',
        'bg-[#1F2937]' => isDarkMode(),
    ])
    x-data="{
        open: true,
        activeTab: 'welcome',
        currentFontSizeIndex: 0,
        fontSizes : ['text-base', 'text-lg', 'text-xl'],
        currentFontSizeClass() {
            return this.fontSizes[this.currentFontSizeIndex];
        },
        adjustFontSize(direction) {
            const newIndex = this.currentFontSizeIndex + direction;
            if (newIndex >= 0 && newIndex < this.fontSizes.length) {
                this.currentFontSizeIndex = newIndex;
            }
        }
    }"
    @tab-changed.window="activeTab = $event.detail.tab"
    x-cloak>

    <div class="relative w-full">
        <div
            x-show="open"
            x-transition
            class="absolute top-0 right-0 h-full w-1 border-r-4 rounded-r-full bg-blue-500 border-blue-500">
        </div>

        <button
            id="flush-headingOnboarding"
            type="button"
            title="فرآیند اولیه پس از استخدام شما"
            @click="open = !open"
            aria-controls="flush-collapseOnboarding"
            :aria-expanded="open"
            class="flex items-center justify-between w-full py-2 pr-4 text-left transition-colors duration-200">
            <span class="flex items-center">
                <i @class([
                    'fa fa-road text-md md:text-xl ml-3 md:ml-4',
                    'text-gray-500' => !isDarkMode(),
                    'text-gray-400' => isDarkMode(),
                ])></i>
                <span @class([
                    'font-medium text-md md:text-xl',
                    'text-gray-800' => !isDarkMode(),
                    'text-white' => isDarkMode(),
                ])>
                    آنبوردینگ (همسوسازی)
                </span>
            </span>
            <i
                class="fa fa-chevron-down text-gray-500 transform transition-transform duration-300"
                :class="{ '-rotate-180': open }">
            </i>
        </button>
    </div>

    <div
        id="flush-collapseOnboarding"
        aria-labelledby="flush-headingOnboarding"
        x-show="open"
        x-collapse
        @class([
            'accordion-collapse border-0 animate-[fade-in_1s_ease-in-out] mt-3 pr-4',
            'text-gray-300' => isDarkMode(),
        ])>
        <x-user.font-size :return-url="route('user.toggleModule', ['module' => 'onboarding'])"/>
        <div class="flex flex-col md:flex-row items-start">
            <x-user.onboarding.nav></x-user.onboarding.nav>
            <div class="tab-content w-full @if ( isDarkMode())text-gray-300 @endif"
                 id="tabs-tabContentVertical"
                 :class="currentFontSizeClass">
                @foreach([
                    'welcome',
                    'schedule',
                    'info',
                    'files',
                    'accounts',
                    'office',
                    'guide'
                ] as $step)
                    <div x-show="activeTab === '{{ $step }}'">
                        <x-dynamic-component :component="'user.onboarding.' . $step"/>
                    </div>
                @endforeach
                <div x-show="activeTab === 'documents'">
                    @livewire('document-uploader')
                </div>
            </div>
        </div>
    </div>
    <x-user.bg-shapes />
</div>
