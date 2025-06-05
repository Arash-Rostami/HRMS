class Jobs {
    constructor(flipCardSelector, frontSelector, backSelector) {
        this.flipCards = document.querySelectorAll(flipCardSelector);
        this.frontSelector = frontSelector;
        this.backSelector = backSelector;

        if (!this.flipCards.length) {
            throw new Error('No flip cards found. Please check your HTML structure and CSS classes.');
        }
    }

    changeVisibility(add, remove) {
        add.classList.add('hidden');
        remove.classList.remove('hidden');
    }

    setHeight(element) {
        if (element) {
            const height = element.scrollHeight;
            element.style.height = height + 'px';
        }
    }

    mount() {
        // loop through each flip card
        this.flipCards.forEach(flipCard => {
            // get the front and back elements for this flip card
            const frontEl = flipCard.querySelector(this.frontSelector);
            const backEl = flipCard.querySelector(this.backSelector);

            // set initial heights of each element
            this.setHeight(frontEl);
            this.setHeight(backEl);

            // add a click event listener to the flip card
            flipCard.addEventListener('click', () => {
                let cardBack = flipCard.querySelector(this.backSelector);
                let cardFront = flipCard.querySelector(this.frontSelector);

                (flipCard.classList.contains('is-flipped'))
                    ? this.changeVisibility(cardBack, cardFront)
                    : this.changeVisibility(cardFront, cardBack);

                // toggle the is-flipped class on the flip card
                flipCard.classList.toggle('is-flipped');

                // update the height of each element based on their new state
                this.setHeight(frontEl);
                this.setHeight(backEl);
            });
        });
    }
}

// Instantiate Job class with selectors for flip cards, front elements, and back elements
const jobs = new Jobs('.flip-card', '.flip-card-front', '.flip-card-back');

// Mount the flip card behavior
jobs.mount();
