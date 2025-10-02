@php
    $badgeLinks = [
        [
            'route' => route('user.toggleModule', ['module' => 'feed']),
            'icon' => 'fas fa-rss',
            'label' => 'اخبار',
            'tooltip' => 'اخبار ',
            'gradient' => 'from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800',
            'badges' => [
                ['condition' => getTodayFeedCount() > 0, 'count' => getTodayFeedCount(), 'color' => 'bg-green-500', 'animate' => false, 'ref' => 'feedBadge']
            ]
        ],
        [
            'route' => route('user.toggleModule', ['module' => 'suggestion']),
            'icon' => 'fa fa-bullhorn',
            'label' => 'پیشنهادات',
            'tooltip' => 'پیشنهادات',
            'gradient' => 'from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800',
            'badges' => [
                ['condition' => showSuggestionBadge(), 'count' => showSuggestionBadgeNumber(), 'color' => 'bg-red-500', 'animate' => true, 'ref' => 'suggestionBadge'],
                ['condition' => showSuggestionCEOBadge(), 'count' => showSuggestionCEOBadgeNumber(), 'color' => 'bg-orange-500', 'animate' => false, 'ref' => 'suggestionBadge']
            ]
        ],
        [
            'route' => route('user.toggleModule', ['module' => 'dms']),
            'icon' => 'fa fa-archive',
            'label' => 'اسناد',
            'tooltip' => 'اسناد',
            'gradient' => 'from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800',
            'badges' => [
                ['condition' => getUnsignedDocCount() > 0, 'count' => getUnsignedDocCount(), 'color' => 'bg-red-500', 'animate' => true, 'ref' => 'dmsBadge'],
                ['condition' => getUnreadDocCount() > 0, 'count' => getUnreadDocCount(), 'color' => 'bg-orange-500', 'animate' => false, 'ref' => 'dmsBadge']
            ]
        ],
        [
            'route' => route('user.toggleModule', ['module' => 'ths']),
            'icon' => 'fas fa-ticket-alt',
            'label' => 'تیکت',
            'tooltip' => 'تیکت',
            'gradient' => 'from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800',
            'badges' => [
                ['condition' => getOpenTicketCount() > 0, 'count' => getOpenTicketCount(), 'color' => 'bg-red-500', 'animate' => true, 'ref' => 'thsBadge'],
                ['condition' => getInProgressTicketCount() > 0, 'count' => getInProgressTicketCount(), 'color' => 'bg-orange-500', 'animate' => false, 'ref' => 'thsBadge']
            ]
        ]
    ];
@endphp

<div class="flex items-center gap-4">
    @foreach($badgeLinks as $link)
        <a @click.prevent="window.open('{{ $link['route'] }}', '_blank')"
           @mouseenter="showTooltip('{{ $link['tooltip'] }}', $event)"
           @mouseleave="hideTooltip()"
           class="relative flex cursor-pointer items-center gap-2 px-4 py-2.5 lg:px-2 lg:py-1.5 bg-gradient-to-r bg-main-mode text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg font-medium">

            <i class="{{ $link['icon'] }}"></i>
            <span class="hidden lg:inline">{{ $link['label'] }}</span>

            @foreach($link['badges'] as $badge)
                @if($badge['condition'])
                    <span x-ref="{{ $badge['ref'] }}"
                          class="absolute -top-2 -right-2 min-w-[24px] h-6 px-1.5 {{ $badge['color'] }} text-white text-xs font-bold rounded-full flex items-center justify-center shadow-lg {{ $badge['animate'] ? 'animate-pulse' : '' }}">
                        {{ $badge['count'] }}
                    </span>
                    @break
                @endif
            @endforeach
        </a>
    @endforeach
</div>
