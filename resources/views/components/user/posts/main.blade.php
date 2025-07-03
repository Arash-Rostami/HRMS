<div
    id="bulletin"
    data-id="2"
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
            title="اعلان‌های مربوط به منابع انسانی و اخبار شرکت پرسال"
            type="button"
            data-te-collapse-init
            data-te-target="#flush-collapseZero"
            aria-expanded="true"
            data-te-toggle="collapse"
            data-bs-target="#flush-collapseZero"
            aria-controls="flush-collapseZero">
        <span class="flex items-center justify-between">
        <span>اعلانات</span>
            <i class="fa fa-newspaper-o text-gray-400"></i>
        </span>
        </h2>
        <!-- Background Shapes -->
        <x-user.bg-shapes/>
    </div>
    {{-- main body content--}}
    <div id="flush-collapseZero"
         @class([
                  'accordion-collapse collapse show border-0',
                  'text-gray-300 ' => isDarkMode(),
                ])
         data-te-collapse-item
         data-te-collapse-show
         data-te-parent="#accordionFlush">
        <x-user.posts.list :posts="$posts" :pins="$pins"/>
    </div>
</div>
