document.addEventListener("DOMContentLoaded", () => {
    window.playSong = (id, state) => {
        const audio = document.getElementById(`audio${id}`);

        if (!audio.src) {
            audio.src = audio.dataset.src;
        }

        document.querySelectorAll("audio").forEach(el => {
            if (el !== audio) {
                el.pause();
                el.currentTime = 0;
                let otherState = el.closest("[x-data]")?.__x?.$data;
                if (otherState) otherState.playing = false;

                const otherWave = document.getElementById(`soundWave${el.id.replace("audio","")}`);
                if (otherWave) otherWave.style.display = "none";
            }
        });

        // play current
        audio.play();
        state.playing = true;

        // 🎶 show wave
        const wave = document.getElementById(`soundWave${id}`);
        if (wave) wave.style.display = "block";

        // when ended, reset
        audio.onended = () => {
            state.playing = false;

            if (wave) wave.style.display = "none";
        };
    };

    window.pauseSong = (id, state) => {
        const audio = document.getElementById(`audio${id}`);
        audio.pause();
        state.playing = false;

        // 🎶 hide wave
        const wave = document.getElementById(`soundWave${id}`);
        if (wave) wave.style.display = "none";
    };

    window.toggleMute = (id, state) => {
        const audio = document.getElementById(`audio${id}`);
        audio.muted = !audio.muted;
        state.muted = audio.muted;
    };

    window.volumeUp = (id) => {
        const audio = document.getElementById(`audio${id}`);
        if (audio.volume < 1) audio.volume = Math.min(1, audio.volume + 0.1);
    };

    window.volumeDown = (id) => {
        const audio = document.getElementById(`audio${id}`);
        if (audio.volume > 0) audio.volume = Math.max(0, audio.volume - 0.1);
    };
});
