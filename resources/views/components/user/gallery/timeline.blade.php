<div class="max-h-[500px] overflow-y-auto custom-scrollbar">
    <div class="relative wrap overflow-hidden h-full">
        <div class="border-2-2 absolute border-opacity-20 border-gray-700 h-full border left-1/2"></div>
        @forelse ($photos as $photo)
            <div @class([
                        'mb-8 flex w-full items-center justify-between',
                        'flex-row-reverse left-timeline' => $loop->odd,
                        'right-timeline' => !$loop->odd,
                    ])>
                <div class="order-1 w-5/12"></div>
                <div class="z-20 flex items-center order-1 bg-main-mode shadow-xl w-8 h-8 rounded cursor-pointer"
                     title="برای نمایش بیشتر به پایین یا بالا اسکرول نمایید">
                    <h1 class="mx-auto font-semibold text-lg text-white">⇅</h1>
                </div>
                <div
                    class='links-thumbnails links-thumbnails-color order-1 w-5/12 rounded-lg bg-weekend px-6 py-4 shadow-xl'>
                    <div class="w-1/3 bg-main-mode text-white text-center px-4 py-1 rounded text-sm font-semibold tracking-wide
                                shadow-lg mr-auto mb-4">
                        {{ jdate($photo->event_date)->format('%d %B %Y') }}
                    </div>
                    <h4 class="mb-3 text-xl">{{ $photo->title }}</h4>
                    @if (is_array($photo->path) && count($photo->path) > 0)
                        @php
                            $transforms = [
                                ['z' => 'z-20', 'rotate' => 'rotate-6', 'hover' => 'group-hover:-translate-x-16 group-hover:-rotate-12'],
                                ['z' => 'z-10', 'rotate' => '-rotate-2', 'hover' => 'group-hover:translate-x-0 group-hover:rotate-3'],
                                ['z' => 'z-0', 'rotate' => 'rotate-3', 'hover' => 'group-hover:translate-x-16 group-hover:rotate-12'],
                            ];
                            $visibleImages = array_slice($photo->path, 0, 3);
                            $hiddenImageCount = count($photo->path) - count($visibleImages);
                        @endphp
                        <div class="group relative my-3 flex min-h-[170px] w-full items-center justify-center p-4">
                            @foreach ($visibleImages as $index => $imagePath)
                                <a href="{{ $imagePath }}"
                                   data-fancybox="gallery-{{ $photo->id }}"
                                   class="absolute h-32 w-32 cursor-pointer overflow-hidden rounded-lg shadow-xl transition-all duration-500 ease-in-out hover:z-30 hover:scale-110
                                          {{ $transforms[$index]['z'] }}  {{ $transforms[$index]['rotate'] }} {{ $transforms[$index]['hover'] }}"
                                >
                                    <img src="{{ asset($imagePath) }}"
                                         alt="{{ $photo->title }}"
                                         loading="lazy"
                                         class="h-full w-full border-2 border-white object-cover dark:border-slate-700">
                                </a>
                            @endforeach
                            @if ($hiddenImageCount > 0)
                                <div
                                    class="relative -right-1 -top-1 z-30 flex h-7 w-7 items-center justify-center rounded-full bg-main-mode text-xs font-bold text-white shadow-md">
                                    +{{ $hiddenImageCount }}
                                </div>
                            @endif
                        </div>
                    @endif

                    <p class="text-sm leading-snug tracking-wide text-opacity-100">
                        {{ strip_tags($photo->description) }}
                    </p>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-10 text-gray-400">
                <i class="fas fa-images fa-3x mb-3"></i>
                <p class="text-lg font-medium">گالری فاقد عکس است</p>
                <span class="mt-1 text-sm text-gray-500">به زودی تصاویر اضافه خواهند شد</span>
            </div>
        @endforelse
        @if ($hasMorePages)
            <div x-data x-intersect.window="$wire.loadMore()">
                <div class="flex items-center justify-center gap-3 p-4">
                    <span>بارگزاری بیشتر ...</span>
                    <div class="h-6 w-6 animate-spin rounded-full border-2 border-main border-t-transparent"></div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        function initFancybox() {
            Fancybox.bind("[data-fancybox]", {
                Toolbar: {
                    display: {
                        left: ["infobar"],
                        middle: [
                            "zoomIn",
                            "zoomOut",
                            "toggle1to1",
                            "rotateCCW",
                            "rotateCW",
                            "flipX",
                            "flipY",
                        ],
                        right: ["slideshow", "fullscreen", "download", "thumbs", "close"],
                    },
                },
                animated: true,
                showClass: "f-fadeIn",
                hideClass: "f-fadeOut",
                Image: {
                    zoom: true,
                },
                backdrop: true,
                keyboard: true,
                dragToClose: true,
                infinite: true,
                Carousel: {
                    transition: "slide",
                },
            });
        }

        initFancybox();
        document.addEventListener('livewire:load', function () {
            Livewire.hook('message.processed', (message, component) => {
                initFancybox();
            });
        });
    </script>
@endpush
