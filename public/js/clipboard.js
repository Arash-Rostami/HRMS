class ClipboardCopy {
    constructor(copyButtonClass, postUrlClass) {
        this.copyButtonClass = copyButtonClass;
        this.postUrlClass = postUrlClass;
        this.copyButtons = document.querySelectorAll(`.${copyButtonClass}`);
        this.postUrlInputs = document.querySelectorAll(`.${postUrlClass}`);

        this.setupEventListeners();
    }

    setupEventListeners() {
        this.copyButtons.forEach((button) => {
            button.addEventListener('click', (event) => this.copyPostUrlToClipboard(event));
        });
    }

    copyPostUrlToClipboard(event) {
        const button = event.target;
        const index = Array.from(this.copyButtons).indexOf(button);
        const postUrlInput = this.postUrlInputs[index];

        // Create a new textarea element
        const textarea = document.createElement('textarea');
        textarea.value = postUrlInput.value;
        document.body.appendChild(textarea);

        // Select the text in the textarea
        textarea.select();
        textarea.setSelectionRange(0, 99999); /* For mobile devices */

        // Copy the text to clipboard
        document.execCommand('copy');

        // Remove the textarea element
        document.body.removeChild(textarea);

        // Prompt user to choose an action: share or copy
        const options = ['Share on WhatsApp', 'Share on Telegram', 'Copy Link'];
        const choice = prompt(`Select an action:\n\n1. ${options[0]}\n2. ${options[1]}\n3. ${options[2]}`);

        this.handleActionChoice(choice);
    }

    handleActionChoice(choice) {
        if (choice === '1') {
            // You can access the corresponding postUrlInput for the clicked button using event.currentTarget
            const postUrlInput = event.currentTarget.nextElementSibling;
            window.open(`https://wa.me/?text=${encodeURIComponent(postUrlInput.value)}`);
        } else if (choice === '2') {
            const postUrlInput = event.currentTarget.nextElementSibling;
            window.open(`https://t.me/share/url?url=${encodeURIComponent(postUrlInput.value)}`);
        } else if (choice === '3') {
            const postUrlInput = event.currentTarget.nextElementSibling;
            alert('Link copied to clipboard: ' + postUrlInput.value);
        } else {
            alert('Invalid choice. Please try again.');
        }
    }
}

// Instantiate the class with the class names
const clipboardCopy = new ClipboardCopy('copyButton', 'postUrl');
