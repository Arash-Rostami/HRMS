<div
    id="bulletin"
    class="notranslate flex flex-col fade-in-fwd active sm:flex-col flex-grow p-4 md:p-8 m-4 md:m-8 bg-white border-1 shadow-lg rounded-xl sortable hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 @if (isDarkMode()) bg-gray-800 text-gray-300 @endif main-user-accordion-panel relative"
    data-id="2"
    title="move me ↑ ↓"
    x-cloak>
    {{--rubric--}}
    <div class="mb-5 w-1/2 md:w-1/4">
        <h2
            class="accordion-header rounded-lg px-4 py-2 cursor-pointer hover:bg-gray-100 focus:ring focus:ring-offset-2 focus:ring-blue-500 transition duration-300 @if (isDarkMode()) bg-gray-700 text-gray-200 @endif"
            title="This is the main place to get updates on your office notifications."
            data-te-collapse-init
            data-te-target="#flush-collapseZero"
            type="button"
            aria-expanded="true"
            data-te-toggle="collapse"
            data-bs-target="#flush-collapseZero"
            aria-controls="flush-collapseZero">
        <span class="flex items-center justify-between">
        <span>Bulletin</span>
            <i class="fa fa-newspaper-o text-gray-400"></i>
        </span>
        </h2>
        <!-- Background Shapes -->
        <x-user.bg-shapes/>
    </div>
    {{-- main body content--}}
    <div id="flush-collapseZero"
         class="slideOutDown accordion-collapse border-0 !visible  @if ( isDarkMode())text-gray-300 @endif"
         data-te-collapse-item
         data-te-collapse-show
         data-te-parent="#accordionFlush">
        <x-user.news :posts="$posts" :pins="$pins"/>
    </div>
</div>
