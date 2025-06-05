<div class="w-1/2 mx-auto border border-dotted border-b-1 border-t-0 border-l-0 border-r-0  pb-1">
    <ul class="mx-auto flex justify-around">
        <li>
            <button title="Create a new suggestion"
                    @click="activeTab = 'new'"
                    :class="{ 'bg-main-mode text-white': activeTab === 'new', 'bg-gray-200 text-gray-700': activeTab !== 'new' }"
                    class="px-4 py-2 rounded-md shadow focus:outline-none">
                <i class="fa fa-plus-square"></i>
            </button>
        </li>
        <li>
            <button title="View sent suggestions"
                    @click="activeTab = 'sent'"
                    :class="{ 'bg-main-mode': activeTab === 'sent', 'bg-gray-200 text-gray-700': activeTab !== 'sent' }"
                    class="relative px-4 py-2 rounded-md shadow focus:outline-none notification-suggestion">
                @if(showSuggestionBadge())
                    <span
                        class="absolute top-0 right-0 w-6 h-6 bg-red-600 text-white text-xs font-bold text-center rounded-full flex items-center justify-center transition-all hover:bg-transparent hover:text-red-600">
                {{ showSuggestionBadgeNumber() }}
            </span>
                @elseif(showSuggestionCEOBadge())
                    <span
                        class="absolute top-0 right-0 w-6 h-6 bg-orange-500 text-white text-xs font-bold text-center rounded-full flex items-center justify-center transition-all hover:bg-transparent hover:text-orange-500">
                {{ showSuggestionCEOBadgeNumber() }}
            </span>
                @endif
                <i class="fa fa-archive"></i>
            </button>
        </li>

    </ul>
</div>

