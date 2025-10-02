@props(['song'])

<div class="w-full sm:w-1/2 flex flex-col items-center px-2"
     x-data="{ playing: false, muted: false }"
     x-init="$watch('playing', value => {
         const img = $el.querySelector('img');
         img.classList.toggle('ring-4', value);
         img.classList.toggle('ring-green-400', value);
         img.classList.toggle('scale-105', value);
         img.classList.toggle('transition-transform', value);
     })">
    {{-- Thumbnail --}}
    <div class="relative w-full max-w-xs flex justify-center mb-3">
        <img src="{{ asset($song['image']) }}"
             alt="{{ $song['alt'] }}"
             loading="lazy"
             class="w-full aspect-square object-cover rounded-2xl transition-transform duration-300 shadow-lg {{ $song['css'] ?? '' }}">
        {{-- Sound Wave Overlay --}}
        <div id="soundWave{{ $song['id'] }}"
             x-show="playing"
             x-transition
             class="absolute inset-0 flex items-center justify-center pointer-events-none"
             title="در حال پخش">
            <div class="boxContainer flex flex-row scale-75 sm:scale-100">
                <div class="box box1"></div>
                <div class="box box2"></div>
                <div class="box box3"></div>
                <div class="box box4"></div>
                <div class="box box5"></div>
            </div>
        </div>
    </div>

    {{-- Audio --}}
    <audio preload="none"
           id="audio{{ $song['id'] }}"
           class="hidden"
           data-src="{{ asset($song['audio']) }}">
        <source type="audio/mpeg">
    </audio>

    {{-- Controls --}}
    <div class="flex items-center justify-center gap-1 sm:gap-3 flex-wrap">
        <button @click="playSong({{ $song['id'] }}, $data)"
                x-show="!playing"
                class="bg-green-500 hover:bg-green-600 text-white p-1 sm:p-3 rounded-full w-7 h-7 sm:w-12 sm:h-12 flex items-center justify-center transition-colors duration-200 shadow-md">
            <i class="fas fa-play text-xs sm:text-sm"></i>
        </button>
        <button @click="pauseSong({{ $song['id'] }}, $data)"
                x-show="playing"
                class="bg-red-500 hover:bg-red-600 text-white p-1 sm:p-3 rounded-full w-7 h-7 sm:w-12 sm:h-12 flex items-center justify-center transition-colors duration-200 shadow-md">
            <i class="fas fa-pause text-xs sm:text-sm"></i>
        </button>
        <button @click="volumeDown({{ $song['id'] }})"
                class="bg-yellow-500 hover:bg-yellow-600 text-white p-1 sm:p-3 rounded-full w-7 h-7 sm:w-12 sm:h-12 flex items-center justify-center transition-colors duration-200 shadow-md">
            <i class="fas fa-volume-down text-xs sm:text-sm"></i>
        </button>
        <button @click="volumeUp({{ $song['id'] }})"
                class="bg-blue-500 hover:bg-blue-600 text-white p-1 sm:p-3 rounded-full w-7 h-7 sm:w-12 sm:h-12 flex items-center justify-center transition-colors duration-200 shadow-md">
            <i class="fas fa-volume-up text-xs sm:text-sm"></i>
        </button>
        <button @click="toggleMute({{ $song['id'] }}, $data)"
                class="bg-purple-500 hover:bg-purple-600 text-white p-1 sm:p-3 rounded-full w-7 h-7 sm:w-12 sm:h-12 flex items-center justify-center transition-colors duration-200 shadow-md">
            <i x-show="!muted" class="fas fa-volume-off text-xs sm:text-sm"></i>
            <i x-show="muted" class="fas fa-volume-mute text-xs sm:text-sm"></i>
        </button>
    </div>
</div>
