setTimeout(function () {
    document.getElementById('loader').style.display = 'none';
}, 100);

function showImage(url) {
    // Create a new <img> tag with the URL of the full-sized image
    var img = document.createElement('img');
    img.src = url;

    var modal = document.createElement('div');
    modal.classList.add('myModal'); // Add the 'modal' class to the div
    modal.title = 'Click to close';
    modal.style.position = 'fixed';
    modal.style.cursor = 'pointer';
    modal.style.top = 0;
    modal.style.left = 0;
    modal.style.width = '100%';
    modal.style.height = '100%';
    modal.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
    modal.style.display = 'flex';
    modal.style.justifyContent = 'center';
    modal.style.alignItems = 'center';
    modal.onclick = function () {
        // Remove the <div> and <img> tags when the user clicks on the modal
        modal.remove();
        img.remove();
    };

    modal.appendChild(img);

    document.body.appendChild(modal);
    setTimeout(function () {
        modal.classList.add('active');
    }, 0);
}


const theme = localStorage.getItem('theme') || 'light';
if (theme === 'light') {
    document.documentElement.classList.add('light-mode');
}

document.addEventListener('dark-mode-toggled', function (event) {
    document.documentElement.classList.toggle('light-mode', event.detail === 'light');
});
