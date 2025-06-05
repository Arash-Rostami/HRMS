<div class="flex flex-col sm:flex-col flex-grow fade-in-fwd p-4 md:p-8 m-4 md:m-8 bg-white border-1 shadow-lg rounded-xl @if ( isDarkMode()) bg-[#1F2937] @endif main-user-accordion-panel"
     x-cloak>
    {{--rubric--}}
    <div class="mb-5 w-1/2 md:w-1/4">
        <h2
            class="accordion-header rounded-lg px-4 py-2 cursor-pointer hover:bg-gray-100 focus:ring focus:ring-offset-2 focus:ring-blue-500 transition duration-300 @if (isDarkMode()) bg-gray-700 text-gray-200 @endif"
            title="This is the place to write/edit your profile information."
            data-te-collapse-init
            data-te-target="#flush-collapseProfile"
            type="button" data-te-toggle="collapse" data-bs-target="#flush-collapseProfile"
            aria-expanded="false" aria-controls="flush-collapseProfile">
             <span class="flex items-center justify-between">
                <span>Profile</span>
                <i class="fa fa-id-card-alt text-gray-400"></i>
              </span>
        </h2>
        <!-- Background Shapes -->
        <x-user.bg-shapes/>
    </div>
    {{-- main body content--}}
    <div id="flush-collapseProfile"
         class="accordion-collapse border-0 !visible @if ( isDarkMode())text-gray-300 @endif"
         data-te-collapse-item
         data-te-collapse-show
         aria-labelledby="flush-headingOne" data-te-parent="#accordionFlushExample">
        <livewire:profile-form/>
    </div>
</div>
