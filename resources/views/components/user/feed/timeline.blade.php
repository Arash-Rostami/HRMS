@php
    $groupedFeeds = $feeds->groupBy(fn($feed) => $feed->created_at->format('F j, Y'));
    $firstFeedId = $feeds->isNotEmpty() ? $feeds->first()->id : null;
@endphp

<section id="feed-list" aria-labelledby="feeds-heading" class="overflow-y-auto custom-scrollbar" x-data>
    <header id="feeds-heading" class="sr-only">Feeds</header>

    <div class="relative wrap overflow-hidden h-full">
        @forelse ($groupedFeeds as $date => $feedsOnDate)
            <div class="sticky top-0 z-10 text-center py-2 w-1/2 shadow-2xl mx-auto">
                <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">{{ $date }}</span>
            </div>

            {{-- Responsive grid--}}
            <div @class([
                    'grid grid-cols-1 gap-6 px-4',
                    'lg:grid-cols-2' => $feedsOnDate->count() > 1
                ])>
                @foreach ($feedsOnDate as $feed)
                    <article role="article" aria-labelledby="feed-{{ $feed->id }}-title"
                             wire:key="feed-{{ $feed->id }}">
                        @include('components.user.feed.post', compact('feed', 'loop', 'firstFeedId'))
                    </article>
                @endforeach
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-10 text-gray-400" role="status" aria-live="polite">
                <i class="fas fa-newspaper fa-3x mb-3" aria-hidden="true"></i>
                <p class="text-lg font-medium">هیچ پستی وجود ندارد.</p>
                <span class="mt-1 text-sm text-gray-500">به زودی موارد جدید اینجا نمایش داده می‌شوند.</span>
            </div>
        @endforelse

        {{-- Load more --}}
        @if ($hasMorePages)
            <div class="px-4 py-6">
                <button
                        id="load-more-feeds"
                        type="button"
                        x-on:click="$wire.loadMore().then(() => {
                        setTimeout(() => {
                            if (typeof smoothScroll === 'function') {
                                const con = document.getElementById('feed-list');
                                smoothScroll(con, con.scrollTop + 600);
                            }
                        }, 100);
                    })"
                        wire:loading.attr="disabled"
                        wire:target="loadMore"
                        aria-controls="feed-list"
                        class="flex items-center justify-center gap-2 w-full p-4 bg-transparent text-main-mode hover:text-opacity-80 transition-colors duration-200"
                >
                    <span> بیشتر</span>
                    <svg wire:loading wire:target="loadMore" class="animate-spin h-5 w-5"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                </button>
            </div>
        @endif
    </div>
</section>
