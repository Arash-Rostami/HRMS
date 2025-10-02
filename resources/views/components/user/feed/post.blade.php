<div
    @class([
    'w-full max-w-3xl mx-auto rounded-lg links-thumbnails links-thumbnails-color',
    'animate-[fade-in_1s_ease-in-out]' => $feed->id === $firstFeedId,
        ])
    style="{{ $feed->id !== $firstFeedId
            ? 'animation: slide-in-bottom 1.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) 1s both;'
            : ''
            }}">
    <div class="flex flex-col rounded-xl pt-2 shadow-lg mb-8 p-4 sm:p-6 transition-colors duration-300 bg-weekend">
        @include('components.user.feed.heading', ['feed' => $feed])

        @if ($feed->media_paths)
            <div class="my-3 rounded-lg overflow-hidden">
                @if (count($feed->media_paths) === 1)
                    <div @class([
                        'flex justify-center rounded-lg overflow-hidden backdrop-blur-sm border transition-all duration-500 hover:shadow-2xl',
                        'bg-gradient-to-br from-slate-100/80 to-gray-200/60 border-gray-300/40' => !isDarkMode(),
                        'bg-gradient-to-br from-gray-800/80 to-gray-900/60 border-gray-600/40' => isDarkMode(),
                    ])>
                        @include('components.user.feed.media', ['path' => $feed->media_paths[0], 'single' => true])
                    </div>
                @else
                    <div @class([
                        'grid grid-cols-2 gap-2 p-2 rounded-lg backdrop-blur-sm border transition-all duration-500 hover:shadow-2xl',
                        'bg-gradient-to-br from-gray-50/60 to-white/40 border-gray-200/30' => !isDarkMode(),
                        'bg-gradient-to-br from-gray-900/60 to-gray-800/40 border-gray-700/30' => isDarkMode(),
                    ])>
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
