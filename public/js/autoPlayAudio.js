class AudioPlayer {
    constructor(audioPath, playAudioButtonId, clockIconId) {
        this.audioPath = audioPath;
        this.audio = null;
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
                // Timer is still valid; update UI only
                this.isPlaying = true;
                this.updateUI(true);
                this.startAudioTimer(targetTime);
            } else if (timeDiff <= 0 && timeDiff > -900000) {
                // Timer passed but within window — do not auto play, only prepare
                console.log('Audio is ready but will not autoplay after refresh.');
                this.updateUI(false);
                localStorage.removeItem('targetTime');
            } else {
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
            return shouldRetry ? this.getUserInputTime() : null;
        }

        return {hour: userHour, minute: userMinute};
    }

    calculateTimeDifference(targetTime) {
        const now = new Date();
        return targetTime - now;
    }

    playAudioAtTargetTime(targetTime) {
        const timeDiff = this.calculateTimeDifference(targetTime);

        if (timeDiff <= 0 && timeDiff > -900000) {
            console.log('Playing audio at target time...');
            if (!this.audio) {
                this.audio = new Audio(this.audioPath);
            }
            this.audio.loop = true;
            this.audio.play();
            this.showStopModal();

            this.stopTimeout = setTimeout(() => {
                if (this.audio) {
                    this.audio.pause();
                    this.audio.currentTime = 0;
                    this.audio.loop = false;
                }
            }, 60000);

            this.stopAudioTimer();
            this.updateUI(false);
            localStorage.removeItem('targetTime');
        } else if (timeDiff <= -900000) {
            console.log('Timer expired. Clearing localStorage...');
            this.stopAudioTimer();
            this.updateUI(false);
            localStorage.removeItem('targetTime');
        }
    }

    showStopModal() {
        const modal = document.createElement('div');
        modal.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);display:flex;align-items:center;justify-content:center;z-index:9999;opacity:0;transition:opacity 0.3s ease-in-out';
        const content = document.createElement('div');
        content.style.cssText = 'padding:2.5rem;border-radius:16px;text-align:center;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1),0 10px 10px -5px rgba(0,0,0,0.04);transform:scale(0.9);transition:transform 0.3s ease-in-out';
        content.innerHTML = '<h2 style="color:#fff;margin:0 0 1.5rem;font-family:persol-farsi-font,sans-serif;font-size:1.8rem;font-weight:600">تایمر</h2><button id="stopAlarmBtn" style="border:none;border-radius:10px;padding:0.75rem 2.5rem;cursor:pointer;font-family:persol-farsi-font,sans-serif;font-size:1rem;font-weight:500;color:#fff;box-shadow:0 4px 15px #717171;transition:transform 0.2s ease,box-shadow 0.2s ease">توقف</button>';
        modal.appendChild(content);
        document.body.appendChild(modal);
        setTimeout(() => {
            modal.style.opacity = '1';
            content.style.transform = 'scale(1)';
        }, 10);
        document.getElementById('stopAlarmBtn').addEventListener('click', (e) => {
            e.target.style.transform = 'scale(0.95)';
            setTimeout(() => {
                if (this.audio) {
                    this.audio.pause();
                    this.audio.currentTime = 0;
                    this.audio.loop = false;
                }
                if (this.stopTimeout) clearTimeout(this.stopTimeout);
                modal.style.opacity = '0';
                setTimeout(() => document.body.removeChild(modal), 300);
            }, 150);
        });
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
            if (this.audio) {
                this.audio.pause();
                this.audio.currentTime = 0;
            }
            this.stopAudioTimer();
            this.updateUI(false);
            localStorage.removeItem('targetTime');
        } else {
            console.log('Timer started.');

            const input = this.getUserInputTime();
            if (!input) return;

            const {hour, minute} = input;
            const targetTime = new Date();
            targetTime.setHours(hour, minute, 0, 0);

            localStorage.setItem('targetTime', targetTime);

            this.startAudioTimer(targetTime);
            this.updateUI(true);

            if (!this.audio) this.audio = new Audio(this.audioPath);

        }
        this.isPlaying = !this.isPlaying;
    }

    handleToggleClick() {
        this.playAudioButton.addEventListener('click', () => this.toggleAudio());
    }
}

const audioPlayer = new AudioPlayer('/audio/alarm.mp3', 'playAudioButton', 'clockIcon');
