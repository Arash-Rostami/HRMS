<div @class([
    'w-full max-w-3xl mx-auto rounded-lg links-thumbnails links-thumbnails-color',
    'animate-[fade-in_1s_ease-in-out]' => $feed->id === $firstFeedId,
    'slide-in-bottom' => $feed->id !== $firstFeedId,
])>
    <div class="flex flex-col rounded-xl pt-2 shadow-lg mb-8 p-4 sm:p-6 transition-colors duration-300 bg-weekend">
        @include('components.user.feed.heading', ['feed' => $feed])

        @if ($feed->media_paths)
            <div class="my-3 rounded-lg overflow-hidden">
                @if (count($feed->media_paths) === 1)
                    <div class="flex justify-center bg-black/50">
                        @include('components.user.feed.media', ['path' => $feed->media_paths[0], 'single' => true])
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-1">
                        @foreach ($feed->media_paths as $path)
                            @include('components.user.feed.media', compact('path') + ['single' => false])
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        @include('components.user.feed.content', compact('feed'))
        @include('components.user.feed.reaction', compact('feed'))
        @include('components.user.feed.comment', compact('feed'))
    </div>
</div>
