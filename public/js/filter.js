class Filter {
    constructor(filterInputId, filterElementsClass, filterFunction) {
        this.filterInput = document.getElementById(filterInputId);
        this.filterElements = document.getElementsByClassName(filterElementsClass);
        this.filterFunction = filterFunction;
        this.filterInput.addEventListener('input', this.filterElementsList.bind(this));
    }

    filterElementsList() {
        const filterText = this.filterInput.value.toLowerCase();
        for (let i = 0; i < this.filterElements.length; i++) {
            const elementText = this.filterFunction(this.filterElements[i]);
            if (elementText.toLowerCase().indexOf(filterText) > -1) {
                this.filterElements[i].style.display = '';
            } else {
                this.filterElements[i].style.display = 'none';
            }
        }
    }
}

// Example function for filtering FAQ questions
function getQuestionText(element) {
    const faqElements = element.querySelectorAll('.faq-search');
    let combinedText = '';

    for (let i = 0; i < faqElements.length; i++) {
        combinedText += faqElements[i].textContent.trim() + ' ';
    }
    return combinedText; // Return an empty string or any other default value if the button element is not found
}

// filter by tags
function filterContent(category) {
    document.querySelectorAll('.faqs').forEach(div => {
        // If the div matches the category, remove the "fade-me" class.
        (category === 'all' || div.dataset.category === category)
            ? div.classList.remove('fade-me')
            : div.classList.add('fade-me');
    });
}


// Example function for filtering avatar containers
function getAvatarText(element) {
    const spanTag = element.getElementsByTagName('span')[0];
    return spanTag.innerText || spanTag.textContent;
}


window.onload = function () {
    // Create an instance of the Filter class for FAQ questions
    const faqFilter = new Filter('filter-input-faq', 'faq-container', getQuestionText);
    // Create an instance of the Filter class for avatar containers
    const avatarFilter = new Filter('filter-input', 'avatar-container', getAvatarText);
}



