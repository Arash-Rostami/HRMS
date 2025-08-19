<div
    id="feed"
    data-id="1"
    title="Move me ↑ ↓"
    dir="rtl"
    @class([
    'flex flex-col sm:flex-col flex-grow fade-in-fwd p-4 md:p-8 m-4 md:m-8
     bg-white border-1 shadow-lg rounded-xl main-user-accordion-panel persol-farsi-font',
    'bg-[#1F2937]' => isDarkMode(),
  ])
    x-data
    x-cloak
>
        <span
            class="absolute top-0 -left-4 -rotate-12 bg-green-500 text-white text-xs px-1 py-1 rounded-full animate-pulse">
            جدید
        </span>
    {{-- Rubric / Header --}}
    <div class="mb-5 w-full md:w-1/4">
        <h2
            @class([
              'accordion-header rounded-lg px-4 py-2 cursor-pointer
               hover:bg-gray-100 focus:ring focus:ring-offset-2
               focus:ring-blue-500 transition duration-300',
              'bg-gray-700 text-gray-200 hover:bg-gray-900' => isDarkMode(),
            ])
            type="button"
            data-te-collapse-init
            data-te-target="#flush-collapseFeed"
            aria-expanded="true"
            aria-controls="flush-collapseFeed"
        >
          <span class="flex items-center justify-between">
            <span>اخبار </span>
            <i class="fa fa-rss text-gray-400"></i>
          </span>
        </h2>
    </div>
    {{-- Main Body Content --}}
    <div
        id="flush-collapseFeed"
        @class([
         'accordion-collapse collapse show border-0',
         'text-gray-300 ' => isDarkMode(),
       ])
        data-te-collapse-item
        data-te-collapse-show
        data-te-parent="#feed"
        aria-labelledby="flush-collapseFeed"
    >
        @livewire('feed-timeline')

        <!-- Background Shapes -->
        <x-user.bg-shapes/>
    </div>
</div>

