<div dir="rtl"
     @class([
     'flex flex-col sm:flex-col flex-grow fade-in-fwd p-4 md:p-8 m-4 md:m-8
      bg-white border-1 shadow-lg rounded-xl main-user-accordion-panel
      persol-farsi-font',
     'bg-[#1F2937]' => isDarkMode(),
   ])
     x-data="{
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
    {{-- Rubric --}}
    <div class="mb-5 w-1/2 md:w-1/4">
        <h2
            @class([
               'accordion-header rounded-lg px-4 py-2 cursor-pointer
                hover:bg-gray-100 focus:ring focus:ring-offset-2
                focus:ring-blue-500 transition duration-300',
               'bg-gray-700 text-gray-200 hover:bg-gray-900' => isDarkMode(),
             ])
            title="این فرآیند اولیه پس از استخدام شما است."
            data-te-collapse-init
            type="button" data-bs-toggle="collapse" data-te-target="#flush-collapseOne"
            aria-expanded="true" aria-controls="flush-collapseOne">
            <span class="flex items-center justify-between bg-inherit">
            <span>آنبوردینگ (همسوسازی)</span>
            <i class="fa fa-road text-gray-400"></i>
        </span>
        </h2>
        <x-user.bg-shapes/>
    </div>
    {{-- Main body content --}}
    <div id="flush-collapseOne" class="accordion-collapse border-0 !visible"
         data-te-collapse-show
         data-te-collapse-item
         aria-labelledby="flush-headingOne"
         data-te-parent="#accordionFlushExample">
        <x-user.font-size :return-url="route('user.panel.onboarding') "/>
        <div class="flex items-start">
            {{--nav links--}}
            <x-user.onboarding.nav></x-user.onboarding.nav>
            <div class="tab-content w-full @if ( isDarkMode())text-gray-300 @endif" id="tabs-tabContentVertical"
                 :class="currentFontSizeClass">
                @foreach([
                    'welcome',
                    'schedule',
                    'info',
                    'charts',
                    'files',
                ] as $step)
                    <x-dynamic-component :component="'user.onboarding.' . $step"/>
                @endforeach
            </div>
        </div>
    </div>
</div>

