@if(count($faqs) > 0)
    <div
        id="faq"
        data-id="8"
        title="move me ↑ ↓"
        dir="rtl"
        @class([
          'flex flex-col sm:flex-col flex-grow fade-in-fwd p-4 md:p-8 m-4 md:m-8
           bg-white border-1 shadow-lg rounded-xl main-user-accordion-panel
           persol-farsi-font',
          'bg-[#1F2937]' => isDarkMode(),
        ])
        x-data x-cloak>
        {{--rubric--}}
        <div class="mb-5 w-1/2 md:w-1/4">
            <h2
                @class([
                     'accordion-header rounded-lg px-4 py-2 cursor-pointer
                      hover:bg-gray-100 focus:ring focus:ring-offset-2
                      focus:ring-blue-500 transition duration-300',
                     'bg-gray-700 text-gray-200 hover:bg-gray-900' => isDarkMode(),
                   ])
                title=" فهرست سوالات و پاسخهای پرتکرار"
                data-te-collapse-init
                data-te-target="#flush-collapseFAQ"
                type="button"
                data-te-toggle="collapse"
                data-bs-target="#flush-collapseTwo"
                aria-expanded="false"
                aria-controls="flush-collapseTwo">
              <span class="flex items-center justify-between">
                <span>سوالات پر تکرار</span>
                <i class="fas fa-question-circle text-gray-400"></i>
              </span>
            </h2>
            <!-- Background Shapes -->
            <x-user.bg-shapes/>
        </div>
        {{-- main body content--}}
        <div id="flush-collapseFAQ"
             @class([
                   'accordion-collapse collapse show border-0',
                   'text-gray-300 ' => isDarkMode(),
                 ])
             data-te-collapse-item
             data-te-collapse-show
             aria-labelledby="flush-headingOne"
             data-te-parent="#accordionFlushExample">
            <x-user.faq.table :faqs="$faqs"/>
        </div>
    </div>
@endif
