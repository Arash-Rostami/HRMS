class Tooltip {
    constructor(tooltipElement) {
        this.tooltipElement = tooltipElement;
        this.tooltipElement.addEventListener('click', () => {
            this.toggle();
        });
    }

    toggle() {
        this.tooltipElement.classList.toggle('invisible');
        this.tooltipElement.classList.toggle('visible');
        this.tooltipElement.classList.toggle('opacity-0');
        this.tooltipElement.classList.toggle('opacity-100');
    }
}

const tooltips = document.querySelectorAll('.tooltiptext');

for (const tooltip of tooltips) {
    new Tooltip(tooltip);
}

