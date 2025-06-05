<div class="flex flex-col sm:flex-col flex-grow fade-in-fwd p-4 md:p-8 m-4 md:m-8 bg-white border-1 shadow-lg rounded-xl sortable
    @if ( isDarkMode()) bg-[#1F2937] @endif main-user-accordion-panel">
    {{--rubric--}}
    <div class="mb-5 w-1/2 md:w-1/4">
        <h2 class="accordion button user-panel-badge cursor-pointer scale-[0.8] w-2/3 md:w-1/2 box-shadow-customized @if ( isDarkMode())text-gray-300 @endif"
            title="This is the initial process after your recruitment." type="button"
            onclick="(!this.classList.contains('before:content-[\'+\']')) ?
               this.classList.add('before:content-[\'+\']') : this.classList.remove('before:content-[\'+\']');"
            data-te-collapse-init
            data-bs-toggle="collapse"
            data-te-target="#flush-collapseFour"
            aria-expanded="false"
            aria-controls="flush-collapseOne"> Surveys
            <i class='fa fa-comments'></i>
        </h2>
    </div>
    {{-- main body content--}}
    <div id="flush-collapseFour" class="accordion-collapse border-0 !visible"
         data-te-collapse-item
         data-te-collapse-show
         data-te-collapse-collapsed
         aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
        <div class="my-8 md:ml-4 ">
            <div class="flex flex-row-reverse">
                <button title="Back to the user panel"
                        @click="window.location.href = '{{ route('user.panel.survey') }}'"
                        class="bg-main-mode hover:opacity-50 py-1 px-2 rounded">
                    <i class="fas fa-arrow-left normal-color text-white"></i>
                </button>
            </div>
        </div>
        <div class="flex">
            {{--nav links--}}
            <x-user.survey-nav></x-user.survey-nav>
            <div class="tab-content w-full @if( isDarkMode()) text-gray-300 @endif" id="tabs-tabContentVertical">
                {{--nav section--}}
                <x-user.recruitment-questionaire></x-user.recruitment-questionaire>
                <x-user.onboarding-questionaire></x-user.onboarding-questionaire>
                {{--                            <x-user.suggestion-questionaire></x-user.suggestion-questionaire>--}}
            </div>
        </div>
    </div>
</div>


