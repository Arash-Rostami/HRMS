@if(count($reports) > 0)
    <div
        id="report"
        data-id="6"
        title="move me ↑ ↓"
        dir="rtl"
        @class([
            'flex flex-col sm:flex-col flex-grow fade-in-fwd p-4 md:p-8 m-4 md:m-8
             bg-white border-1 shadow-lg rounded-xl main-user-accordion-panel
             persol-farsi-font',
            'bg-[#1F2937]' => isDarkMode(),
          ])
        x-data
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
                title="فهرست گزارشات مندرجه واحد های مختلف پرسال برای اطلاع رسانی جمعی"
                data-te-collapse-init
                data-bs-toggle="collapse"
                data-te-target="#flush-collapseReports"
                type="button"
                aria-expanded="false"
                aria-controls="flush-collapseReports">
                <span class="flex items-center justify-between">
                     <span>گزارشات </span>
                    <i class="fas fa-chart-line text-gray-400"></i>
                </span>
            </h2>
            <!-- Background Shapes -->
            <x-user.bg-shapes/>
        </div>
        {{-- main body content--}}
        <div id="flush-collapseReports"
             @class([
                 'accordion-collapse collapse show border-0',
                 'text-gray-300 ' => isDarkMode(),
               ])
             data-te-collapse-item
             data-te-collapse-show
             aria-labelledby="flush-headingReports"
             data-te-parent="#report">
            @include('components.user.report.table', ['reports' => $reports])
            <!-- Background Shapes -->
            <x-user.bg-shapes/>
        </div>
    </div>
@endif
