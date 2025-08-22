<div class="mx-auto">
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
                            class="relative px-3 py-1 md:px-4 md:py-2 rounded-md shadow focus:outline-none mx-1">
                        <i class="fa fa-archive"></i> تاریخچه تیکت ها
                    </button>
                </li>
            </ul>
        </div>
        <div class="p-0 md:p-3">
            @if($ticketToRate)
                {{-- Tab for Ticket Rating --}}
                <div class="animate-[fade-in_0.3s_both]"
                     x-show="activeTab === 'rate'">
                    @include('components.user.ths.tab-rating')
                </div>
            @else
                {{-- Tab for Ticket Creation --}}
                <div class="animate-[fade-in_0.3s_both]"
                     x-show="activeTab === 'new'">
                    @include('components.user.ths.tab-creation')
                </div>
            @endif
            {{-- Tab for Ticket History --}}
            <div class="animate-[fade-in_0.3s_both]"
                 x-show="activeTab === 'log'">
                @include('components.user.ths.tab-log')
            </div>
        </div>
    </div>
</div>
