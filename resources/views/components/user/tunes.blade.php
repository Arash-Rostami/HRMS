@inject('music', 'App\Services\Music')

<div class="mx-auto">
    <div class="my-8 md:ml-4 ">
        <h5 class="text-justify">
            Elevate your workday with concentration, workout, or recreation
            music.
        </h5>
        <div class="flex flex-row-reverse" x>
            <button title="Back to the user panel"
                    @click="window.location.href = '{{ route('user.panel.music') }}'"
                    class="bg-main-mode hover:opacity-50 py-1 px-2 rounded">
                <i class="fas fa-arrow-left normal-color text-white"></i>
            </button>
        </div>
    </div>

    @foreach ($music::sortByTheme() as $theme => $themeSongs)
        <div class="card-job links-thumbnails p-5">
            <div class="main-color mb-6">{!! $theme !!} </div>
            @foreach(array_chunk($themeSongs, 2) as $songChunk)
                <div class="flex md:flex-row gap-4 mb-4">
                    @foreach($songChunk as $song)
                        <div class="w-1/2">
                            <img src="{{ asset($song['image']) }}" alt="{{ $song['alt'] }}" loading="lazy"
                                 class="md:w-2/3 mx-auto h-auto rounded-2xl thumbnail links-thumbnails links-thumbnails-color {{ $song['css'] ?? '' }}">
                            <div id="soundWave{{ $song['id'] }}"
                                 class="boxContainer scale-50 md:scale-100 relative right-1/3 md:right-1/2 bottom-16"
                                 title="playing ...">
                                <div class="box box1"></div>
                                <div class="box box2"></div>
                                <div class="box box3"></div>
                                <div class="box box4"></div>
                                <div class="box box5"></div>
                            </div>
                            <audio id="audio{{ $song['id'] }}" controls class="w-full md:w-1/2 mx-auto hidden">
                                <source src="{{ asset($song['audio']) }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                            <div class="flex items-center justify-center scale-50 md:scale-100">
                                <button id="playButton{{ $song['id'] }}" title="play {{ $song['alt'] }}"
                                        class="bg-green-500 text-white p-2 px-3 rounded-full mr-2">
                                    <i class="fas fa-play"></i>
                                </button>
                                <button id="pauseButton{{ $song['id'] }}" title="pause {{ $song['alt'] }}"
                                        class="bg-red-500 text-white p-2 px-3 rounded-full mr-2 hidden">
                                    <i class="fas fa-pause"></i>
                                </button>
                                <button id="volumeDownButton{{ $song['id'] }}" title="turn down {{ $song['alt'] }}"
                                        class="bg-yellow-500 text-white p-2 px-3 rounded-full mr-2">
                                    <i class="fas fa-volume-down"></i>
                                </button>
                                <button id="volumeUpButton{{ $song['id'] }}" title="turn up {{ $song['alt'] }}"
                                        class="bg-blue-500 text-white p-2 rounded-full mr-2">
                                    <i class="fas fa-volume-up"></i>
                                </button>
                                <button id="muteButton{{ $song['id'] }}" title="mute | unmute {{ $song['alt'] }}"
                                        class="bg-purple-500 text-white p-2 px-4 rounded-full mr-2">
                                    <i class="fas fa-volume-off"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endforeach
</div>



