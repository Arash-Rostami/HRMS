@php
    $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $isVideo = in_array($extension, ['mp4', 'webm', 'ogg']);
@endphp

@if ($isVideo)
    <video
        class="w-full h-full max-h-96 object-cover rounded-lg"
        controls
        preload="metadata"
        playsinline
    >
        <source src="{{ asset($path) }}" type="video/{{ $extension }}">
        مرورگر شما از ویدیو پشتیبانی نمی‌کند.
    </video>
@else
    <img
        src="{{ asset($path) }}"
        alt="Feed media"
        loading="lazy"
        data-fancybox="feed-{{ $path }}"
        decoding="async"
        class="w-full h-auto max-h-96 object-contain cursor-pointer transition-transform hover:scale-105"
    >
@endif
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

        document.addEventListener('livewire:load', function () {
            Livewire.hook('message.processed', (message, component) => {
                initFancybox();
            });
        });
    </script>
@endpush
