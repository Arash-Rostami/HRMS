@props(['song'])


<div class="w-1/2 flex flex-col items-center"
     x-data="{ playing: false, muted: false }"
     x-init="$watch('playing', value => {
         const img = $el.querySelector('img');
         img.classList.toggle('ring-4', value);
         img.classList.toggle('ring-green-400', value);
         img.classList.toggle('scale-105', value);
         img.classList.toggle('transition-transform', value);
     })">

    {{-- Thumbnail --}}
    <div class="relative w-full flex justify-center">
        <img src="{{ asset($song['image']) }}"
             alt="{{ $song['alt'] }}"
             loading="lazy"
             class="w-2/3 h-auto rounded-2xl transition-transform  thumbnail links-thumbnails  duration-300 {{ $song['css'] ?? '' }}">

        {{-- Sound Wave Overlay --}}
        <div id="soundWave{{ $song['id'] }}"
             x-show="playing"
             x-transition
             class="boxContainer flex flex-row scale-50 md:scale-100 absolute inset-0 right-1/2 top-1/2"
             title="در حال پخش">
            <div class="box box1"></div>
            <div class="box box2"></div>
            <div class="box box3"></div>
            <div class="box box4"></div>
            <div class="box box5"></div>
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
    <div class="flex items-center justify-center gap-2 mt-4 scale-75 md:scale-100">
        <button @click="playSong({{ $song['id'] }}, $data)"
                x-show="!playing"
                class="bg-green-500 text-white p-2 rounded-full w-10 h-10 flex items-center justify-center">
            <i class="fas fa-play text-sm"></i>
        </button>

        <button @click="pauseSong({{ $song['id'] }}, $data)"
                x-show="playing"
                class="bg-red-500 text-white p-2 rounded-full w-10 h-10 flex items-center justify-center">
            <i class="fas fa-pause text-sm"></i>
        </button>

        <button @click="volumeDown({{ $song['id'] }})"
                class="bg-yellow-500 text-white p-2 rounded-full w-10 h-10 flex items-center justify-center">
            <i class="fas fa-volume-down text-sm"></i>
        </button>

        <button @click="volumeUp({{ $song['id'] }})"
                class="bg-blue-500 text-white p-2 rounded-full w-10 h-10 flex items-center justify-center">
            <i class="fas fa-volume-up text-sm"></i>
        </button>

        <button @click="toggleMute({{ $song['id'] }}, $data)"
                class="bg-purple-500 text-white p-2 rounded-full w-10 h-10 flex items-center justify-center">
            <i x-show="!muted" class="fas fa-volume-off text-sm"></i>
            <i x-show="muted" class="fas fa-volume-mute text-sm"></i>
        </button>
    </div>
</div>
