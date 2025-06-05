<div
    id="calendar"
    class="notranslate flex flex-col fade-in-fwd active sm:flex-col flex-grow p-4 md:p-8 m-4 md:m-8 bg-white border-1 shadow-lg rounded-xl sortable hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 @if (isDarkMode()) bg-gray-800 text-gray-300 @endif main-user-accordion-panel relative"
    data-id="1"
    title="move me ↑ ↓"
    x-cloak
>
    {{-- Rubric --}}
    <div class="mb-5 w-full md:w-1/4">
        <h2
            class="accordion-header rounded-lg px-4 py-2 cursor-pointer hover:bg-gray-100 focus:ring focus:ring-offset-2 focus:ring-blue-500 transition duration-300 @if (isDarkMode()) bg-gray-700 text-gray-200 @endif"
            title="This is the main calendar to view PERSOL's events."
            data-te-collapse-init
            data-te-target="#flush-collapseCalender"
            aria-expanded="true"
            aria-controls="flush-collapseCalender"
        >
      <span class="flex items-center justify-between">
        <span>Calendar</span>
        <i class="far fa-calendar-alt text-gray-400"></i>
      </span>
        </h2>
        <!-- Background Shapes -->
        <x-user.bg-shapes/>
    </div>
    {{-- Main Body Content --}}
    <div
        id="flush-collapseCalender"
        class="accordion-collapse collapse show border-0 @if (isDarkMode()) text-gray-300 @endif"
        data-te-collapse-item
        data-te-collapse-show
        data-te-parent="#accordionFlush"
        aria-labelledby="flush-collapseCalender"
    >
        @livewire('event-calendar')
    </div>
</div>
