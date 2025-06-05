@if(count($jobs) > 0)
    <div
        class="flex flex-col sm:flex-col flex-grow fade-in-fwd p-4 md:p-8 m-4 md:m-8 bg-white border-1 shadow-lg rounded-xl sortable @if ( isDarkMode()) bg-[#1F2937] @endif main-user-accordion-panel" data-id="4" title="move me ↑ ↓"
         x-cloak>
        <!-- Background Shapes -->
        <x-user.bg-shapes/>
        {{--rubric--}}
        <div class="mb-5 w-1/2 md:w-1/4">
            <h2
                class="accordion-header rounded-lg px-4 py-2 cursor-pointer hover:bg-gray-100 focus:ring focus:ring-offset-2 focus:ring-blue-500 transition duration-300 @if (isDarkMode()) bg-gray-700 text-gray-200 @endif"
                title="This is the main place to find the most recent employment opportunities."
                onclick="(!this.classList.contains('before:content-[\'+\']')) ?
               this.classList.add('before:content-[\'+\']') : this.classList.remove('before:content-[\'+\']'); "
                data-te-collapse-init
                data-te-target="#flush-collapseSeven"
                type="button" data-te-toggle="collapse" data-bs-target="#flush-collapseSeven"
                aria-expanded="false" aria-controls="flush-collapseTwo">
                 <span class="flex items-center justify-between">
                <span>Ads</span>
                <i class="fas fa-handshake text-gray-400"></i>
                </span>
            </h2>
        </div>
        {{-- main body content--}}
        <div id="flush-collapseSeven"
             class="accordion-collapse border-0 !visible hidden @if ( isDarkMode())text-gray-300 @endif"
             data-te-collapse-item
             data-te-collapse-show
             aria-labelledby="flush-headingOne" data-te-parent="#accordionFlushExample">
            <x-user.job-lists :jobs="$jobs"/>
        </div>
    </div>
@endif


