<div
    id="personnel"
    data-id="3"
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
            title="مشاهده وضعیت و موقعیت همکاران"
            data-te-collapse-init
            data-te-target="#flush-collapseStatus"
            type="button"
            aria-expanded="false"
            aria-controls="flush-collapseStatus">
            <span class="flex items-center justify-between">
                <span>پرسنل</span>
                 <i class="fa fa-users text-gray-400"></i>
              </span>
        </h2>
        <!-- Background Shapes -->
        <x-user.bg-shapes/>
    </div>
    {{-- main body content--}}
    <div id="flush-collapseStatus"
         @class([
              'accordion-collapse collapse show border-0',
              'text-gray-300 ' => isDarkMode(),
            ])
         data-te-collapse-item
         data-te-collapse-show
         data-te-parent="#accordionFlush"
         aria-labelledby="flush-headingOne">
        <x-user.status.avatars :users="$users"/>
    </div>
</div>
