// defining observer
class StatusSubject {
    constructor() {
        this.observers = [];
        this.status = '';
    }

    addObserver(observer) {
        this.observers.push(observer);
    }

    setStatus(status) {
        this.status = status;
        this.notify();
    }

    notify() {
        this.observers.forEach((observer) => {
            observer.update(this.status);
        });
    }
}

//defining logic of what happens when user gets online or offline
class StatusObserver {
    constructor() {
        this.statusDiv = document.createElement('div');
        this.myClass = this.statusDiv.classList;
        this.statusDiv.classList.add('p-2', 'text-center', 'fixed', 'w-full', 'z-50');
        this.statusDiv.style.top = '0';
        this.statusDiv.style.left = '0';
        this.statusDiv.style.height = '0px';
        this.statusDiv.style.transition = 'all 1s ease-in-out';

        document.body.appendChild(this.statusDiv);
    }

    changeClasses(remove, add) {
        this.myClass.remove(`bg-${remove}-500`);
        this.myClass.add(`bg-${add}-500`);
    }

    hideDivStatus(delay) {
        setTimeout(() => {
            this.statusDiv.style.height = '0';
            setTimeout(() => {
                this.statusDiv.style.opacity = 0;
                this.statusDiv.innerHTML = '';
            }, 250);
        }, delay);
    }

    raiseOpacity() {
        for (let opacity = 0; opacity < 1.1; opacity = opacity + 0.1) {
            setTimeout(() => {
                this.statusDiv.style.opacity = opacity;
            }, 100)
        }
    }

    showDivStatus() {
        this.statusDiv.style.height = '50px';
    }

    update(status) {
        let text = {
            'online': ['check-square', 'back online'],
            'offline': ['window-close', 'gone offline'],
        }[status];

        this.statusDiv.innerHTML = `<i class='far fa-${text[0]}'></i> ${text[1]}`;

        (status === 'online') ? this.changeClasses('red', 'green') : this.changeClasses('green', 'red');

        this.showDivStatus();
        this.raiseOpacity();
        if (status === 'online') return this.hideDivStatus(5000);
    }
}

const statusSubject = new StatusSubject();
const statusObserver = new StatusObserver();

statusSubject.addObserver(statusObserver);

window.addEventListener('online', () => {
    statusSubject.setStatus('online');
});

window.addEventListener('offline', () => {
    statusSubject.setStatus('offline');
});
