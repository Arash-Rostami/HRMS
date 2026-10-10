{{--the main dashboard for users reservation --}}
<x-app-layout>
    <div x-data="{ 'showModal': false, 'showReserve': true, 'showCancel': false, 'showSuspend':false }"
         @keydown.escape="showModal = false"
         x-cloak>
        <div class="p-8 flex flex-col md:flex-row flex-grow slide-in-left"
             x-show="!showModal"
             x-cloak>
            <x-dashboard.sidebar/>
            <x-dashboard.main-section :type="$type"/>
        </div>
        <div x-show="showModal"
             x-cloak>
            <x-dashboard.modal/>
        </div>
    </div>
</x-app-layout>
