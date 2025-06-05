(function startApp() {
    if (window.location.href.includes("sms")) {
        const buttons = document.querySelectorAll("button[id$='button']");
        buttons.forEach((button) => {
            button.addEventListener("click", function (e) {
                let item, backdrop, open, close;
                item = document.querySelector(`[id=${e.target.id}]`);
                backdrop = document.getElementById("backdrop");
                open = document.getElementById("open-button");
                close = document.getElementById("close-button");
                if (item.id === "open-button") {
                    backdrop.classList.remove("slide-in-top");
                    backdrop.classList.add("slide-out-top");
                    open.style.display = "none";
                    close.style.display = "block";
                }
                if (item.id === "close-button") {
                    backdrop.classList.remove("slide-out-top");
                    backdrop.classList.add("slide-in-top");
                    open.style.display = "block";
                    close.style.display = "none";
                }
            });
        });
    }
})();
