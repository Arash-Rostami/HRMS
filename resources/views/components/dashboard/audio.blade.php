<audio class="hidden" id="parking" src="/audio/parking.mp3"></audio>
<audio class="hidden" id="office" src="/audio/office.mp3"></audio>


<script>
    window.onload = function () {
        let audio = Cookie.getCookie('audio');
        if (audio == null) {
            (window.location.href.includes('office'))
                ? document.getElementById("office").play()
                : document.getElementById("parking").play();
            return Cookie.setCookie('audio', 'played', 1);
        }
    }
</script>
