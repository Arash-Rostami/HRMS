<div
    id="personnel"
    data-id="6"
    title="move me ↑ ↓"
    dir="rtl"
    x-data="{ open: false }"
    x-cloak
    @class([
        'flex flex-col sm:flex-col flex-grow fade-in-fwd p-4 md:p-8 m-4 md:m-8
         bg-white border-1 shadow-lg rounded-xl main-user-accordion-panel
         persol-farsi-font',
        'bg-[#1F2937]' => isDarkMode(),
    ])>

    <div class="relative w-full">
        <div
            x-show="open"
            x-transition
            class="absolute top-0 right-0 h-full w-1 border-r-4 rounded-r-full bg-blue-500 border-blue-500">
        </div>

        <button
            id="flush-headingPersonnel"
            type="button"
            title="مشاهده وضعیت و موقعیت همکاران"
            @click="open = !open"
            aria-controls="flush-collapsePersonnel"
            :aria-expanded="open"
            class="flex items-center justify-between w-full py-2 pr-4 text-left transition-colors duration-200">
            <span class="flex items-center">
                <i @class([
                    'fa fa-users text-md md:text-xl ml-3 md:ml-4',
                    'text-gray-500' => !isDarkMode(),
                    'text-gray-400' => isDarkMode(),
                ])></i>
                <span @class([
                    'font-medium text-md md:text-xl',
                    'text-gray-800' => !isDarkMode(),
                    'text-white' => isDarkMode(),
                ])>
                    پرسنل
                </span>
            </span>
            <i
                class="fa fa-chevron-down text-gray-500 transform transition-transform duration-300"
                :class="{ '-rotate-180': open }">
            </i>
        </button>
    </div>

    <div
        id="flush-collapsePersonnel"
        aria-labelledby="flush-headingPersonnel"
        x-show="open"
        x-collapse
        @class([
            'accordion-collapse border-0 animate-[fade-in_1s_ease-in-out] mt-3 pr-4',
            'text-gray-300' => isDarkMode(),
        ])>
        <x-user.status.avatars :users="$users"/>
    </div>
    <x-user.bg-shapes/>
</div>
