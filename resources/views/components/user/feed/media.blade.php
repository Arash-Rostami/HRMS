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
        decoding="async"
        class="w-full h-full max-h-96 object-cover rounded-lg @if(!$single) aspect-square @endif"
    >
@endif
