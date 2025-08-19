<div x-data="{ play: false }"
     class="slide-in-right cursor-pointer relative top-2 left-2"
     @click="
        if (!play) {
          if (!$refs.audio.src) $refs.audio.src = $refs.audio.dataset.src;
          $refs.audio.play();
        } else {
          $refs.audio.pause();
        }
        play = !play;
     ">
    <i class="fas fa-music w-8 main-color block ml-auto mr-4 mb-2 md:fixed md:right-4 md:top-4"
       :class="play ? 'flip-horizontal-bottom' : ''"
       title="Enjoy your time while browsing :)"></i>

    <audio hidden x-ref="audio"
           data-src="/audio/{{ collect(['VR','PK','SC','LG','C','SS'])->random() }}.mp3">
    </audio>
</div>
