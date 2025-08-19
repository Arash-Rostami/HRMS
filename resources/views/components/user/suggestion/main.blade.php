<div
    id="suggestion"
    dir="rtl"
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
    {{--rubric--}}
    <div class="mb-5 w-1/2 md:w-1/4">
        <h2
            @class([
                'accordion-header rounded-lg px-4 py-2 cursor-pointer
                 hover:bg-gray-100 focus:ring focus:ring-offset-2
                 focus:ring-blue-500 transition duration-300',
                'bg-gray-700 text-gray-200 hover:bg-gray-900' => isDarkMode(),
              ])
            title="سرویس ارسال و تایید پیشنهادات واحدی/سازمانی"
            data-te-collapse-init
            data-te-target="#flush-collapseSuggestion"
            type="button"
            data-te-toggle="collapse"
            data-bs-target="#flush-collapseTwo"
            aria-expanded="true"
            aria-controls="flush-collapseSuggestion">
           <span class="flex items-center justify-between">
            <span>پیشنهادات</span>
            <i class="fa fa-bullhorn text-gray-400"></i>
          </span>
        </h2>
    </div>
    {{-- main body content--}}
    <div id="flush-collapseSuggestion"
         @class([
                  'accordion-collapse collapse show border-0',
                  'text-gray-300 ' => isDarkMode(),
                ])
         data-te-collapse-item
         data-te-collapse-show
         data-te-collapse-collapsed
         aria-labelledby="flush-collapseSuggestion"
         data-te-parent="#suggestion">
        <x-user.font-size :return-url="route('user.toggleModule', ['module' => 'suggestion']) "/>
        <div :class="currentFontSizeClass">
            @livewire('suggestion-process')
        </div>
        <!-- Background Shapes -->
        <x-user.bg-shapes/>
    </div>
</div>
