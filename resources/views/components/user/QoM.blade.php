@if($questions > 0)
    <div class="fade-in-one flex flex-col sm:flex-col flex-grow fade-in-fwd p-4 md:p-8 m-4 md:m-8 bg-white border-1 shadow-lg rounded-xl @if ( isDarkMode()) bg-[#1F2937] @endif"
         x-cloak>
        {{--rubric--}}
        <div class="mb-5 w-1/2 md:w-1/4">
            <h2
                class="accordion-header rounded-lg px-4 py-2 cursor-pointer hover:bg-gray-100 focus:ring focus:ring-offset-2 focus:ring-blue-500 transition duration-300 @if (isDarkMode()) bg-gray-700 text-gray-200 @endif"
                title="This is the place to view the question of month."
                data-te-collapse-init
                data-bs-toggle="collapse"
                data-te-target="#flush-collapseQuestionOfMonth"
                type="button"
                data-bs-target="#flush-collapseQuestionOfMonth"
                aria-expanded="true" aria-controls="flush-collapseQuestionOfMonth">
                <span class="flex items-center justify-between">
                    <span>Monthly Question</span>
                      <i class="fas fa-question-circle text-gray-400"></i>
                     </span>
            </h2>
            <!-- Background Shapes -->
            <x-user.bg-shapes/>
        </div>
        {{-- main body content--}}
        <div id="flush-collapseQuestionOfMonth"
             class="accordion-collapse border-0 !visible  @if ( isDarkMode())text-gray-300 @endif"
             data-te-collapse-item
             data-te-collapse-show
             aria-labelledby="flush-headingQuestionOfMonth" data-te-parent="#accordionFlushExample">
            @livewire('question-of-month')
        </div>
    </div>
@endif
