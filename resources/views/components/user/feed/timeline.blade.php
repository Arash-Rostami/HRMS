@php
    $groupedFeeds = $feeds->groupBy(fn($feed) => $feed->created_at->format('F j, Y'));
    $firstFeedId = $feeds->isNotEmpty() ? $feeds->first()->id : null;
@endphp

<div class="max-h-[800px] overflow-y-auto custom-scrollbar">
    <div class="relative wrap overflow-hidden h-full">
        @forelse ($groupedFeeds as $date => $feedsOnDate)
            <div class="sticky top-0 z-10 text-center py-2 w-1/2 shadow-2xl mx-auto">
                <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">{{ $date }}</span>
            </div>
            @foreach ($feedsOnDate as $feed)
                @include('components.user.feed.post', compact('feed', 'loop', 'firstFeedId'))
            @endforeach
        @empty
            <div class="flex flex-col items-center justify-center py-10 text-gray-400">
                <i class="fas fa-newspaper fa-3x mb-3"></i>
                <p class="text-lg font-medium">هیچ پستی وجود ندارد.</p>
                <span class="mt-1 text-sm text-gray-500">به زودی موارد جدید اینجا نمایش داده می‌شوند.</span>
            </div>
        @endforelse

        @if ($hasMorePages)
            <button x-on:click="$wire.loadMore()"
                    class="flex items-center justify-center gap-2 w-full p-4 bg-transparent text-main-mode hover:text-opacity-80 transition-colors duration-200">
                <span> بیشتر</span>
            </button>
        @endif
    </div>
</div>
