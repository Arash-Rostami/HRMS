{{-- Icon trigger section --}}
<div
    class="icon-scroll-wrapper mx-auto top-[120px] scale-75 md:scale-100 md:top-[100px] transform -translate-y-1/2 z-9 max-w-full md:max-w-none md:flex md:justify-end md:space-x-4 md:flex-row md:mr-8 md:ml-auto">
    {{-- Make icons scrollable horizontally in mobile view --}}
    <div class="icon-scroll-container flex gap-4 w-full md:w-auto md:flex-nowrap justify-center">

        {{-- Admin Panel Icon --}}
        @if (isAdmin(auth()->user()))
            <div class="rounded slogan-icon relative admin" title="Go to Admin panel">
                <a href="/main/admin" class="block cursor-pointer text-center px-4 py-2 transition-all duration-300 text-white text-xl hover:scale-150
         bg-main-mode hover:bg-transparent shadow-lg rounded">
                    <i class="fas fa-cogs"></i>
                </a>
            </div>
        @endif

        {{-- Delegation Panel Icon --}}
        <div class="rounded slogan-icon relative" title="Go to authorities panel">
            <a href="{{ route('user.panel.delegation') }}" class="block cursor-pointer text-center px-4 py-2 transition-all duration-300 text-white text-xl hover:scale-150
         bg-main-mode hover:bg-transparent shadow-lg rounded">
                <i class='fas fa-tasks'></i>
            </a>
        </div>

        {{-- Audio Timer Icon --}}
        <div class="rounded slogan-icon autoplayer" title="Set daily workout timer on">
            <a class="block cursor-pointer text-center px-4 py-2 transition-all duration-300 text-white text-xl hover:scale-150
         bg-main-mode hover:bg-transparent shadow-lg rounded" id="playAudioButton">
                <i class="fas fa-clock" id="clockIcon"></i>
            </a>
        </div>

        {{-- DMS Icon --}}
        <div x-data="{ showBadgeDMS: true }" class="rounded slogan-icon relative"
             title=" @if(getUnsignedDocCount() > 0) Sign issued document(s) @elseif(getUnreadDocCount() > 0) Read issued document(s) @else View issued documents @endif"
             @mouseover="showBadgeDMS = false" @mouseleave="showBadgeDMS = true">
            <a href="{{ route('user.panel.dms') }}"
               class="block cursor-pointer text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded hover:scale-110">
                <i class="fa fa-archive"></i>
                <span
                    class="slogan absolute top-0 left-0 w-full h-full flex justify-center items-center text-lg font-bold"></span>
                @if(getUnsignedDocCount() > 0)
                    <span
                        x-show="showBadgeDMS"
                        class="absolute top-0 right-0 w-7 h-7 bg-red-600 text-white text-sm font-bold text-center rounded-full flex
                                        items-center justify-center transition-all">
                                        {{ getUnsignedDocCount() }}
                                    </span>
                @elseif(getUnreadDocCount() > 0)
                    <span
                        x-show="showBadgeDMS"
                        class="absolute top-0 right-0 w-7 h-7 bg-orange-500 text-white text-sm font-bold text-center rounded-full flex
                                         items-center justify-center transition-all">
                                        {{ getUnreadDocCount()  }}
                                    </span>
                @endif
            </a>
        </div>

        {{-- THS  Icon --}}
        <div x-data="{ showBadgeTHS: true }" class="rounded slogan-icon relative"
             title=" @if(getOpenTicketCount() > 0) You have open tickets @elseif(getInProgressTicketCount() > 0) You have in-progress tickets @else Access THS @endif"
             @mouseover="showBadgeTHS = false" @mouseleave="showBadgeTHS = true">
            <a href="{{ route('user.panel.ths') }}"
               class="block cursor-pointer text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded hover:scale-110">
                <i class="fas fa-ticket-alt"></i>
                <span
                    class="slogan absolute top-0 left-0 w-full h-full flex justify-center items-center text-lg font-bold"></span>

                @if(getOpenTicketCount() > 0)
                    <span x-show="showBadgeTHS"
                          class="absolute top-0 right-0 w-7 h-7 bg-red-600 text-white text-sm font-bold text-center rounded-full flex items-center justify-center transition-all">
                       {{ getOpenTicketCount() }}
                     </span>
                @elseif(getInProgressTicketCount() > 0)
                    <span x-show="showBadgeTHS"
                          class="absolute top-0 right-0 w-7 h-7 bg-orange-500 text-white text-sm font-bold text-center rounded-full flex items-center justify-center transition-all">
                        {{ getInProgressTicketCount() }}
                    </span>
                @endif
            </a>
        </div>

        {{-- Profile Edit Icon --}}
        <div class="rounded slogan-icon profile" title="Edit your profile info">
            <a href="{{ route('user.panel.edit') }}" class="block cursor-pointer text-center px-5 py-2 transition-all duration-300 text-white text-xl hover:scale-150
         bg-main-mode hover:bg-transparent shadow-lg rounded">
                <i class="fas fa-portrait"></i>
            </a>
        </div>

        {{-- Onboarding Icon --}}
        <div class="rounded slogan-icon onboarding" title="Load onboarding process">
            <a href="{{ route('user.panel.onboarding') }}" class="block cursor-pointer text text-center px-4 py-2 transition-all duration-300 text-white text-xl hover:scale-150
        bg-main-mode hover:bg-transparent shadow-lg rounded">
                <i class="fa fa-road"></i>
            </a>
        </div>

        {{-- Survey Icon --}}
        {{--    <div class="rounded slogan-icon music" title="Load survey questionnaires">--}}
        {{--        <a href="{{ route('user.panel.survey') }}" class="block cursor-pointer text text-center px-3 py-2 transition-all duration-300 text-white text-xl hover:scale-150--}}
        {{--        bg-main-mode hover:bg-transparent shadow-lg rounded">--}}
        {{--            <i class='fa fa-comments'></i>--}}
        {{--            <span--}}
        {{--                class="slogan hidden absolute top-0 left-0 w-full h-full flex justify-center items-center text-lg font-bold"></span>--}}
        {{--        </a>--}}
        {{--    </div>--}}

        {{-- Suggestion Icon --}}
        <div x-data="{ showBadgeSuggestion: true }" class="rounded slogan-icon suggestion relative"
             title="Load suggestion form"
             @mouseover="showBadgeSuggestion = false" @mouseleave="showBadgeSuggestion = true">
            <a href="{{ route('user.panel.suggestion') }}"
               class="block cursor-pointer text-center px-4 py-2 transition-all duration-300 text-white text-xl hover:scale-110 bg-main-mode hover:bg-transparent shadow-lg rounded">
                <i class="fa fa-bullhorn"></i>
                <span
                    class="slogan absolute top-0 left-0 w-full h-full flex justify-center items-center text-lg font-bold"></span>
                @if(showSuggestionBadge())
                    <span
                        x-show="showBadgeSuggestion"
                        class="absolute top-0 right-0 w-7 h-7 bg-red-600 text-white text-sm font-bold text-center rounded-full flex items-center justify-center transition-all hover:bg-transparent hover:text-red-600">{{ showSuggestionBadgeNumber() }}</span>
                @elseif(showSuggestionCEOBadge())
                    <span
                        x-show="showBadgeSuggestion"
                        class="absolute top-0 right-0 w-7 h-7 bg-orange-500 text-white text-sm font-bold text-center rounded-full flex items-center justify-center transition-all hover:bg-transparent hover:text-orange-500">{{ showSuggestionCEOBadgeNumber() }}</span>
                @endif
            </a>
        </div>


        {{-- Music Icon --}}
        <div class="rounded slogan-icon music" title="Load a playlist">
            <a href="{{ route('user.panel.music') }}" class="block cursor-pointer text text-center px-4 py-2 transition-all duration-300 text-white text-xl hover:scale-150
        bg-main-mode hover:bg-transparent shadow-lg rounded">
                <i class="fa fa-headphones"></i>
            </a>
        </div>

        {{-- Analytics Icon --}}
        <div class="rounded slogan-icon analytics" title="View PERSOL's statistics">
            <a href="{{ route('user.panel.analytics') }}" class="block cursor-pointer text text-center px-4 py-2 transition-all duration-300 text-white text-xl hover:scale-150
        bg-main-mode hover:bg-transparent shadow-lg rounded">
                <i class="fas fa-chart-bar"></i>
            </a>
        </div>


        {{-- CRM Icon --}}
        <div class="rounded slogan-icon analytics" title="View PERSOL's CRM API">
            <a href="{{ route('crm') }}" class="block cursor-pointer text text-center px-4 py-2 transition-all duration-300 text-white text-xl hover:scale-150
        bg-main-mode hover:bg-transparent shadow-lg rounded">
                <i class="fas fa-database"></i>
            </a>
        </div>

        {{-- Slogan Icon --}}
        <div class="rounded slogan-icon slogan" title="View PERSOL's slogan">
            <a class="block cursor-pointer text text-center px-5 py-2 transition-all duration-300 text-white text-xl hover:scale-150
        bg-main-mode hover:bg-transparent shadow-lg rounded">
                <i class="fas fa-lightbulb"></i>
            </a>
        </div>
    </div>


    {{--Modal--}}
    <div class="fixed z-10 inset-0 invisible overflow-hidden bg-main" aria-labelledby="modal-title" role="dialog"
         aria-modal="true" id="sloganModal">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <div class="flex items-center justify-center h-screen">
                <div
                    class="bg-main rounded-lg text-center overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <div class="bg-main pt-5 pb-4 px-4 flex items-center justify-center h-full">
                        <div class="text-center text-sm text-gray-500"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--left and right indicators for scroll--}}
<div
    class="scroll-indicator left-indicator sm:block md:hidden absolute left-8 top-[110px] transform -translate-y-1/2 z-10">
    <i class="fas fa-chevron-left text-xs text-gray-500"></i>
</div>
<div
    class="scroll-indicator right-indicator sm:block md:hidden absolute right-8 top-[110px] transform -translate-y-1/2 z-10">
    <i class="fas fa-chevron-right text-xs text-gray-500"></i>
</div>







