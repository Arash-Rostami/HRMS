const audioElements = [];

for (let i = 1; i <= 30; i++) {
    const audioElement = {
        id: `audio${i}`,
        playButtonId: `playButton${i}`,
        pauseButtonId: `pauseButton${i}`,
        soundWaveId: `soundWave${i}`,
        muteButtonId: `muteButton${i}`,
        volumeUpButtonId: `volumeUpButton${i}`,
        volumeDownButtonId: `volumeDownButton${i}`,
    };

    audioElements.push(audioElement);
}

document.addEventListener("DOMContentLoaded", function () {
    audioElements.forEach((audioElement) => {
        setupAudioControls(audioElement.id, audioElement.playButtonId, audioElement.pauseButtonId, audioElement.soundWaveId,
            audioElement.muteButtonId, audioElement.volumeUpButtonId, audioElement.volumeDownButtonId);
    });
});

function setupAudioControls(audioId, playButtonId, pauseButtonId, soundWaveId, muteButtonId, volumeUpButtonId, volumeDownButtonId) {
    let soundWave = document.getElementById(soundWaveId);
    let audioElement = document.getElementById(audioId);
    let playButton = document.getElementById(playButtonId);
    let pauseButton = document.getElementById(pauseButtonId);
    let muteButton = document.getElementById(muteButtonId);
    let volumeUpButton = document.getElementById(volumeUpButtonId);
    let volumeDownButton = document.getElementById(volumeDownButtonId);

    playButton.addEventListener("click", function () {
        audioElement.play();
        playButton.style.visibility = "hidden";
        pauseButton.style.display = "block";
        soundWave.style.display = "flex";
    });

    pauseButton.addEventListener("click", function () {
        audioElement.pause();
        playButton.style.visibility = "visible";
        pauseButton.style.display = "none";
        setTimeout(function () {
            soundWave.style.display = "none";
        }, 500)
    });

    audioElement.addEventListener("ended", function () {
        playButton.style.visibility = "visible";
        pauseButton.style.display = "none";
        soundWave.style.display = "none";
    });

    muteButton.addEventListener("click", function () {
        audioElement.muted = !audioElement.muted;
    });

    volumeUpButton.addEventListener("click", function () {
        audioElement.volume += 0.1;
    });

    volumeDownButton.addEventListener("click", function () {
        audioElement.volume -= 0.1;
    });
}
