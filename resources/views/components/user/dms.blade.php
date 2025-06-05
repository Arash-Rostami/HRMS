<div class="flex flex-col sm:flex-col flex-grow fade-in-fwd py-2 px-0 md:p-8 m-4 md:m-8 bg-white border-1 shadow-lg rounded-xl @if ( isDarkMode()) bg-[#1F2937] @endif main-user-accordion-panel" x-cloak>
    {{--rubric--}}
    <div class="mb-5 w-1/2 md:w-1/4">
        <h2
            class="accordion-header rounded-lg px-4 py-2 cursor-pointer hover:bg-gray-100 focus:ring focus:ring-offset-2 focus:ring-blue-500 transition duration-300 @if (isDarkMode()) bg-gray-700 text-gray-200 @endif"
            title="This is the place to view organizational documents."
            data-te-collapse-init
            data-te-target="#flush-collapseDMS"
            type="button"
            data-te-toggle="collapse"
            data-bs-target="#flush-collapseDMS"
            aria-expanded="true" aria-controls="flush-collapseDMS">
            <span class="flex items-center justify-between">
                <span>DMS</span>
                <i class="fa fa-archive text-gray-400"></i>
              </span>
        </h2>
        <!-- Background Shapes -->
        <x-user.bg-shapes/>
    </div>
    {{-- main body content--}}
    <div id="flush-collapseDMS"
         class="accordion-collapse border-0 !visible @if ( isDarkMode())text-gray-300 @endif"
         data-te-collapse-item
         data-te-collapse-show
         aria-labelledby="flush-collapseDMS"
         data-te-parent="#accordionFlushExample">
        <div class="my-8 md:ml-4">
            <div class="p-3 flex flex-row-reverse">
                <button title="Back to the user panel"
                        @click="window.location.href = '{{ route('user.panel.dms') }}'"
                        class="bg-main-mode hover:opacity-50 py-1 px-2 rounded">
                    <i class="fas fa-arrow-left normal-color text-white"></i>
                </button>
            </div>
        </div>
        @livewire('d-m-s')
    </div>
</div>
