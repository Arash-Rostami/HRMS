<div
    id="dms"
    dir="rtl"
    @class([
        'flex flex-col sm:flex-col flex-grow fade-in-fwd p-4 md:p-8 m-4 md:m-8
         bg-white border-1 shadow-lg rounded-xl main-user-accordion-panel
         persol-farsi-font',
        'bg-[#1F2937]' => isDarkMode(),
    ])
    x-data="{
        open: true,
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
    x-cloak>

    <div class="relative w-full">
        <div
            x-show="open"
            x-transition
            class="absolute top-0 right-0 h-full w-1 border-r-4 rounded-r-full bg-blue-500 border-blue-500">
        </div>

        <button
            id="flush-headingDMS"
            type="button"
            title="سرویس مشاهده و تایید اسناد سازمانی پرسال"
            @click="open = !open"
            aria-controls="flush-collapseDMS"
            :aria-expanded="open"
            class="flex items-center justify-between w-full py-2 pr-4 text-left transition-colors duration-200">
            <span class="flex items-center">
                <i @class([
                    'fa fa-archive text-md md:text-xl ml-3 md:ml-4',
                    'text-gray-500' => !isDarkMode(),
                    'text-gray-400' => isDarkMode(),
                ])></i>
                <span @class([
                    'font-medium text-md md:text-xl',
                    'text-gray-800' => !isDarkMode(),
                    'text-white' => isDarkMode(),
                ])>
                    مدیریت اسناد
                </span>
            </span>
            <i
                class="fa fa-chevron-down text-gray-500 transform transition-transform duration-300"
                :class="{ '-rotate-180': open }">
            </i>
        </button>
    </div>

    <div
        id="flush-collapseDMS"
        aria-labelledby="flush-headingDMS"
        x-show="open"
        x-collapse
        @class([
            'accordion-collapse border-0 animate-[fade-in_1s_ease-in-out] mt-3 pr-4',
            'text-gray-300' => isDarkMode(),
        ])>
        <x-user.font-size :return-url="route('user.toggleModule', ['module' => 'dms'])" />
        <div :class="currentFontSizeClass">
            @livewire('d-m-s')
        </div>
    </div>
    <x-user.bg-shapes/>
</div>
