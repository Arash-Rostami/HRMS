<div class="mx-auto persol-farsi-font rtl-direction text-sm md:text-base">
    <div
        x-data="{
            activeTab: '{{ $ticketToRate ? 'rate' : 'new' }}',
            openToast: false,
            toastMessage:'تیکت شما با موفقیت ارسال شد.'
        }"
    >
        {{-- Tab Selector --}}
        <div class="w-1/2 mx-auto border-b-2 pb-1 mb-4">
            <ul class="flex justify-around">
                @if($ticketToRate)
                    <li>
                        <button @click="activeTab = 'rate'"
                                :class="{ 'bg-main-mode': activeTab === 'rate', 'bg-gray-400 text-gray-700 font-bold': activeTab !== 'rate' }"
                                class="px-3 py-1 md:px-4 md:py-2 rounded-md shadow focus:outline-none mx-1">
                            <i class="fa fa-star"></i> ارزیابی
                        </button>
                    </li>
                @else
                    <li>
                        <button @click="activeTab = 'new'"
                                :class="{ 'bg-main-mode': activeTab === 'new', 'bg-gray-400 text-gray-700 font-bold': activeTab !== 'new' }"
                                class="px-3 py-1 md:px-4 md:py-2 rounded-md shadow focus:outline-none mx-1">
                            <i class="fa fa-plus-square"></i> تیکت جدید
                        </button>
                    </li>
                @endif
                <li>
                    <button @click="activeTab = 'log'"
                            :class="{ 'bg-main-mode': activeTab === 'log', 'bg-gray-400 text-gray-700 font-bold': activeTab !== 'log' }"
                            class="relative px-3 py-1  md:px-4 md:py-2 rounded-md shadow focus:outline-none mx-1">
                        <i class="fa fa-archive"></i> تاریخچه تیکت ها
                    </button>
                </li>
            </ul>
        </div>
        <div class="p-0 md:p-3">
            @if($ticketToRate)
                {{-- Tab for Ticket Rating --}}
                <div x-show="activeTab === 'rate'">
                    @include('livewire.ticket.tab-rating')
                </div>
            @else
                {{-- Tab for Ticket Creation --}}
                <div x-show="activeTab === 'new'">
                    @include('livewire.ticket.tab-creation')
                </div>
            @endif
            {{-- Tab for Ticket History --}}
            <div x-show="activeTab === 'log'">
                @include('livewire.ticket.tab-log')
            </div>
        </div>
    </div>
</div>
