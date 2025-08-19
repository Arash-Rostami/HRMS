<div
    id="calendar"
    data-id="2"
    title="move me ↑ ↓"
    dir="rtl"
    @class([
    'flex flex-col sm:flex-col flex-grow fade-in-fwd p-4 md:p-8 m-4 md:m-8
     bg-white border-1 shadow-lg rounded-xl main-user-accordion-panel
     persol-farsi-font',
    'bg-[#1F2937]' => isDarkMode(),
  ])
    x-data>
    {{-- Rubric --}}
    <div class="mb-5 w-full md:w-1/4">
        <h2
            @class([
              'accordion-header rounded-lg px-4 py-2 cursor-pointer
               hover:bg-gray-100 focus:ring focus:ring-offset-2
               focus:ring-blue-500 transition duration-300',
              'bg-gray-700 text-gray-200 hover:bg-gray-900' => isDarkMode(),
            ])
            title=" تقویم اصلی برای مشاهده رویدادها، تولدها و سالگردهای شغلی پرسنل "
            type="button"
            data-te-collapse-init
            data-te-target="#flush-collapseCalender"
            aria-expanded="true"
            aria-controls="flush-collapseCalender"
        >
          <span class="flex items-center justify-between">
            <span>تقویم</span>
            <i class="far fa-calendar-alt text-gray-400"></i>
          </span>
        </h2>
    </div>
    {{-- Main Body Content --}}
    <div
        id="flush-collapseCalender"
        @class([
         'accordion-collapse collapse show border-0 animate-[fade-in_1s_ease-in-out]',
         'text-gray-300 ' => isDarkMode(),
       ])
        data-te-collapse-item
        data-te-collapse-show
        data-te-parent="#calendar"
        aria-labelledby="flush-collapseCalender"
    >
        @livewire('timetable')

        <!-- Background Shapes -->
        <x-user.bg-shapes/>
    </div>
</div>
