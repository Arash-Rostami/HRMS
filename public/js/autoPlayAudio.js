class AudioPlayer {
    constructor(audioPath, playAudioButtonId, clockIconId) {
        this.audio = new Audio(audioPath);
        this.playAudioButton = document.getElementById(playAudioButtonId);
        this.clockIcon = document.getElementById(clockIconId);
        this.isPlaying = false;
        this.audioTimer = null;

        this.restoreTimerState();

        this.handleToggleClick();
    }

    restoreTimerState() {
        const storedTime = localStorage.getItem('targetTime');
        if (storedTime) {
            const targetTime = new Date(storedTime);
            const timeDiff = this.calculateTimeDifference(targetTime);

            if (timeDiff > 0) {
                // Timer is still valid; update UI and start timer
                this.isPlaying = true;
                this.updateUI(true);
                this.startAudioTimer(targetTime);
            } else if (timeDiff <= 0 && timeDiff > -900000) {
                // Timer has passed but is within the playback window
                console.log('Playing audio after page refresh...');
                this.audio.play();
                this.updateUI(false); // Reset UI after playing
                localStorage.removeItem('targetTime'); // Clear storage
            } else {
                // Timer is expired; clear storage and reset UI
                localStorage.removeItem('targetTime');
                this.updateUI(false);
            }
        }
    }

    getUserInputTime() {
        const userHour = parseInt(prompt('Enter target hour (0-23):', new Date().getHours()), 10);
        const userMinute = parseInt(prompt('Enter target minute (0-59):', new Date().getMinutes()), 10);

        if (
            isNaN(userHour) || userHour < 0 || userHour > 23 ||
            isNaN(userMinute) || userMinute < 0 || userMinute > 59
        ) {
            const shouldRetry = confirm('Invalid time entered. Do you want to retry?');
            if (shouldRetry) {
                return this.getUserInputTime();
            } else {
                return null; // User cancelled entering time
            }
        }

        return { hour: userHour, minute: userMinute };
    }

    calculateTimeDifference(targetTime) {
        const now = new Date();
        return targetTime - now;
    }

    playAudioAtTargetTime(targetTime) {
        const timeDiff = this.calculateTimeDifference(targetTime);

        if (timeDiff <= 0 && timeDiff > -900000) {
            console.log('Audio is being played at the target time...');
            this.audio.play();
            this.stopAudioTimer();
            this.updateUI(false); // Reset UI after playing
            localStorage.removeItem('targetTime'); // Clear storage
        } else if (timeDiff <= -900000) {
            // If time is fully expired, reset
            console.log('Timer expired. Clearing localStorage...');
            this.stopAudioTimer();
            this.updateUI(false);
            localStorage.removeItem('targetTime');
        }
    }

    startAudioTimer(targetTime) {
        this.audioTimer = setInterval(() => this.playAudioAtTargetTime(targetTime), 1000);
    }

    stopAudioTimer() {
        clearInterval(this.audioTimer);
    }

    updateUI(isActive) {
        if (isActive) {
            this.playAudioButton.classList.remove('bg-main-mode');
            this.playAudioButton.classList.add('bg-success');
            this.clockIcon.classList.add('rotate');
        } else {
            this.playAudioButton.classList.remove('bg-success');
            this.playAudioButton.classList.add('bg-main-mode');
            this.clockIcon.classList.remove('rotate');
        }
    }

    toggleAudio() {
        if (this.isPlaying) {
            console.log('Timer stopped.');
            this.audio.pause();
            this.audio.currentTime = 0;
            this.stopAudioTimer();
            this.updateUI(false);
            localStorage.removeItem('targetTime'); // Clear localStorage
        } else {
            console.log('Timer started.');

            // Get user input and create a target time
            const { hour, minute } = this.getUserInputTime();
            const targetTime = new Date();
            targetTime.setHours(hour, minute, 0, 0);

            // Store the target time in localStorage
            localStorage.setItem('targetTime', targetTime);

            // Start the timer
            this.startAudioTimer(targetTime);

            // Update UI
            this.updateUI(true);
        }
        this.isPlaying = !this.isPlaying;
    }

    handleToggleClick() {
        this.playAudioButton.addEventListener('click', () => this.toggleAudio());
    }
}

// Initialize AudioPlayer
const audioPlayer = new AudioPlayer('/audio/rema.mp3', 'playAudioButton', 'clockIcon');
