{{--this is the dashboard for users reservation --}}
<x-app-layout>
    <div class="p-8 flex flex-col md:flex-row flex-grow slide-in-left" @keydown.escape="showModal = false" x-cloak
         x-data="{ 'showModal': false, 'showReserve': true, 'showCancel': false, 'showSuspend':false }">
        <x-dashboard.sidebar/>
        <x-dashboard.main-section :type="$type"/>
        <x-dashboard.modal/>
    </div>
</x-app-layout>
