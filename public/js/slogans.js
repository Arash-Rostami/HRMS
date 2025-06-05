class SloganModal {
    constructor() {
        this.modal = document.getElementById('sloganModal');
        this.sloganText = this.modal.querySelector('.text-gray-500');
        this.expandButton = this.expandButton.bind(this);
        this.slogans = [
            { iconClass: 'fas fa-cogs', englishText: 'Simplify the job ', farsiText: ' کار را ساده کن' },
            { iconClass: 'fas fa-hourglass-start', englishText: 'Get started on tomorrow\'s task now ', farsiText: ' کار فردا به امروز بینداز' },
            { iconClass: 'fas fa-hands-helping', englishText: 'Good job results from teamwork ', farsiText: ' کار خوب نتیجه همکاری عالیه' },
            { iconClass: 'fas fa-chart-line', englishText: 'More sales means I have performed my job well  ', farsiText: ' فروش بیشتر یعنی من کارم رو خوب انجام دادم' }
        ];
    }

    expandButton(event) {
        event.preventDefault();
        const randomIndex = Math.floor(Math.random() * this.slogans.length);
        this.showModal(this.slogans[randomIndex]);
    }

    showModal(slogan) {
        this.sloganText.innerHTML = `
            <div class="text-center justify-center max-w-screen max-h-screen">
            <i class="${slogan.iconClass} text-main-mode"></i><br>
            <span class="persol-farsi-font">${slogan.farsiText}</span><br>
            ${slogan.englishText}
            </div>
        `;

        // Show modal: remove "hidden" & optionally add "block" or some display class
        this.modal.classList.remove('hidden');

        let countdown = 5;
        this.sloganText.insertAdjacentHTML('beforeend',
            `<h3 class="countdown text-main absolute top-0 right-0 m-2">${countdown}</h3>`
        );

        const countdownInterval = setInterval(() => {
            countdown--;
            const countdownElement = this.sloganText.querySelector('.countdown');
            if (countdownElement) {
                countdownElement.textContent = countdown;
            }
            if (countdown <= 0) {
                // Hide modal: add "hidden" again
                this.modal.classList.add('hidden');
                clearInterval(countdownInterval);
            }
        }, 1000);
    }

    initialize() {
        const sloganButton = document.querySelector('#sloganLink');
        sloganButton.addEventListener('click', this.expandButton);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const sloganModal = new SloganModal();
    sloganModal.initialize();
});
