@php
    $emojis = ['👍', '❤️', '😂', '😮', '😢', '💔', '👏'];
    $counts = $feed->reactions->groupBy('emoji')->map->count();
    $userEmoji = $feed->reactions->firstWhere('user_id', auth()->id())?->emoji;
    $dark = isDarkMode();
@endphp

<div @class([
    'flex items-center gap-2 py-2 border-t',
    'border-gray-200' => !$dark,
    'border-gray-700' => $dark,
])>
    <div class="flex items-center flex-wrap gap-2">
        @foreach ($emojis as $emoji)
            @php $active = $userEmoji === $emoji; @endphp
            <button
                wire:key="react-{{ $feed->id }}-{{ md5($emoji) }}"
                wire:click="toggleReaction({{ $feed->id }}, '{{ $emoji }}')"
                title="{{ $emoji }} {{ $counts[$emoji] ?? 0 }}"
                aria-pressed="{{ $active ? 'true' : 'false' }}"
                @class([
                    'inline-flex items-center gap-1 rounded px-2 py-1 text-xs transition select-none',
                    'border' => !$dark,
                    'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' => !$dark && !$active,
                    'bg-blue-500 text-white hover:bg-blue-600' => !$dark && $active,
                    'bg-gray-800 text-gray-200 border-gray-700 hover:bg-gray-700/60' => $dark && !$active,
                    'bg-blue-800 text-white' => $dark && $active,
                ])>
                <span class="text-base leading-none">{{ $emoji }}</span>
                <span class="min-w-[1.5rem] text-center tabular-nums">{{ $counts[$emoji] ?? 0 }}</span>
            </button>
        @endforeach
    </div>
    <div class="ml-auto">
        <span class="text-[10px] uppercase tracking-wide opacity-60">کل: {{ $feed->reactions->count() }}</span>
    </div>
</div>
