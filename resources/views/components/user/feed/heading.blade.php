@php
    $category = $feed->category;
    $emoji = '💬';

    switch ($category) {
        case 'General':
            $emoji = '📢';
            break;
        case 'Event':
            $emoji = '📅';
            break;
        case 'Birthday':
            $emoji = '🎂';
            break;
        case 'Work Anniversary':
            $emoji = '🏆';
            break;
        case 'Poll':
            $emoji = '📊';
            break;
    }
@endphp

<div class="flex flex-row-reverse items-center justify-between mb-4">
    <div class="flex items-center space-x-3" dir="ltr">
        <img class="h-10 w-10 rounded-full object-cover"
             src="{{ $feed->user->profile?->image }}"
             alt="{{ $feed->user->full_name }}">
        <div>
            <h4 @class([
                    'text-lg mr-2',
                    'text-gray-900' => !isDarkMode(),
                    'text-gray-100' => isDarkMode(),
                ])>{{ $feed->user->full_name }}</h4>
            <p dir="rtl"
                @class([
                    'text-xs mr-2',
                    'text-gray-500' => !isDarkMode(),
                    'text-gray-400' => isDarkMode(),
                ])> {{ jdate($feed->created_at)->ago() }}</p>
        </div>
    </div>

    <span
        class="inline-flex items-center space-x-2 px-3 py-1 text-sm font-semibold text-white rounded direction-rtl bg-main-mode"
    ><span>{{ $emoji }}</span>
    </span>
</div>
