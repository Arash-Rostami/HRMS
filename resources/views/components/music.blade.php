<div class="slide-in-right cursor-pointer relative top-2 left-2"
     @click="(play == false) ? (play = ! play, $refs.audio.play()) : (play = ! play, $refs.audio.pause())">
    <i class="fas fa-music w-8 main-color block ml-auto mr-4 mb-2 md:fixed md:right-4 md:top-4"
       :class="play ? 'flip-horizontal-bottom' : ''" title="Enjoy your time while browsing :)"></i>
    <audio class="hidden" src="/audio/{{ collect(['VR', 'PK','SC', 'LG','C','SS'])->random() }}.mp3"
           x-ref="audio"></audio>
</div>
