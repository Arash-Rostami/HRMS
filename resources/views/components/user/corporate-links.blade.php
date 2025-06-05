@if($links->filter(fn($link) => $link['link'] === 'external')->isNotEmpty())
    <div
        id="tools"
        class="flex flex-col sm:flex-col flex-grow fade-in-fwd p-4 md:p-8 m-4 md:m-8 bg-white border-1 shadow-lg rounded-xl sortable @if ( isDarkMode()) bg-[#1F2937] @endif main-user-accordion-panel" data-id="7" title="move me ↑ ↓"
         x-cloak>
        {{--rubric--}}
        <div class="mb-5 w-1/2 md:w-1/4">
            <h2
                class="accordion-header rounded-lg px-4 py-2 cursor-pointer hover:bg-gray-100 focus:ring focus:ring-offset-2 focus:ring-blue-500 transition duration-300 @if (isDarkMode()) bg-gray-700 text-gray-200 @endif"
                title="This is the main hub to connect you to tools you need in your office."
                data-te-collapse-init
                data-te-target="#flush-collapseTwo"
                type="button" data-te-toggle="collapse" data-bs-target="#flush-collapseTwo"
                aria-expanded="false" aria-controls="flush-collapseTwo">
                 <span class="flex items-center justify-between">
                    <span>Tools</span>
                    <i class="fas fa-external-link-alt text-gray-400"></i>
                  </span>
            </h2>
            <!-- Background Shapes -->
            <x-user.bg-shapes/>
        </div>
        {{-- main body content--}}
        <div id="flush-collapseTwo"
             class="accordion-collapse border-0 !visible @if ( isDarkMode())text-gray-300 @endif"
             data-te-collapse-item
             data-te-collapse-show
             aria-labelledby="flush-headingOne" data-te-parent="#accordionFlushExample">
            <x-user.external-links :links="$links"/>
        </div>
    </div>
@endif
