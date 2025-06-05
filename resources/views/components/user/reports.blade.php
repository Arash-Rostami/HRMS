@if(count($reports) > 0)
    <div
        id="report"
        class="flex flex-col sm:flex-col flex-grow fade-in-fwd p-4 md:p-8 m-4 md:m-8 bg-white border-1 shadow-lg rounded-xl @if ( isDarkMode()) bg-[#1F2937] @endif main-user-accordion-panel"
        data-id="5" title="move me ↑ ↓"
        x-cloak>
        {{--rubric--}}
        <div class="mb-5 w-1/2 md:w-1/4">
            <h2
                class="accordion-header rounded-lg px-4 py-2 cursor-pointer hover:bg-gray-100 focus:ring focus:ring-offset-2 focus:ring-blue-500 transition duration-300 @if (isDarkMode()) bg-gray-700 text-gray-200 @endif"
                title="This is the place to view the reports of Persol teams."
                data-te-collapse-init
                data-bs-toggle="collapse"
                data-te-target="#flush-collapseReports"
                type="button" data-te-toggle="collapse" data-bs-target="#flush-collapseReports"
                aria-expanded="false" aria-controls="flush-collapseReports">
                 <span class="flex items-center justify-between">
                <span>Reports</span>
                <i class="fas fa-chart-line text-gray-400"></i>
              </span>
            </h2>
            <!-- Background Shapes -->
            <x-user.bg-shapes/>
        </div>
        {{-- main body content--}}
        <div id="flush-collapseReports"
             class="accordion-collapse border-0 !visible  @if ( isDarkMode())text-gray-300 @endif"
             data-te-collapse-item
             data-te-collapse-show
             aria-labelledby="flush-headingReports" data-te-parent="#accordionFlushExample">
            @include('components.user.report-table', ['reports' => $reports])
        </div>
    </div>
@endif
