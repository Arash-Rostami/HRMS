<div
    id="personnel"
    class="flex flex-col fade-in-fwd active sm:flex-col flex-grow p-4 md:p-8 m-4 md:m-8 bg-white border-1 shadow-lg rounded-xl sortable @if ( isDarkMode()) bg-[#1F2937] @endif main-user-accordion-panel"
    data-id="3"
    title="move me ↑ ↓"
    x-cloak>
    {{--rubric--}}
    <div class="mb-5 w-1/2 md:w-1/4">
        <h2
            class="accordion-header rounded-lg px-4 py-2 cursor-pointer hover:bg-gray-100 focus:ring focus:ring-offset-2 focus:ring-blue-500 transition duration-300 @if (isDarkMode()) bg-gray-700 text-gray-200 @endif"
            title="This is the main hub to see the status of your respected coworkers."
            data-te-collapse-init
            data-te-target="#flush-collapseStatus"
            type="button"
            aria-expanded="false" aria-controls="flush-collapseStatus">
            <span class="flex items-center justify-between">
                <span>Personnel</span>
                 <i class="fa fa-users text-gray-400"></i>
              </span>
        </h2>
        <!-- Background Shapes -->
        <x-user.bg-shapes/>
    </div>
    {{-- main body content--}}
    <div id="flush-collapseStatus"
         class="slideOutDown accordion-collapse border-0 !visible @if ( isDarkMode())text-gray-300 @endif"
         data-te-collapse-item
         data-te-collapse-show
         data-te-parent="#accordionFlush"
         aria-labelledby="flush-headingOne">
        <x-user.avatars :users="$users"/>
    </div>
</div>
