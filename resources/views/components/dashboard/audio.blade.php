<audio hidden id="parking" data-src="/audio/parking.mp3"></audio>
<audio hidden id="office" data-src="/audio/office.mp3"></audio>

<script>
    window.onload = () => {
        if (!Cookie.getCookie('audio')) {
            let id = location.href.includes('office') ? "office" : "parking";
            let el = document.getElementById(id);
            el.src = el.dataset.src;
            el.play().catch(()=>{});
            Cookie.setCookie('audio', 'played', 1);
        }
    }
</script>
