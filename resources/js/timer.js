(function showTime() {
    let url = window.location.href;
    if (url.includes("dashboard") || url.includes("main")) {
        let date = new Date();
        let h = date.getHours(); // 0 - 23
        let m = date.getMinutes(); // 0 - 59
        let s = date.getSeconds(); // 0 - 59
        let session = "AM";

        if (h == 0) {
            h = 12;
        }

        if (h > 12) {
            h = h - 12;
            session = "PM";
        }

        h = (h < 10) ? "0" + h : "" + h;
        m = (m < 10) ? "0" + m : m;
        s = (s < 10) ? "0" + s : s;

        const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat"];
        let dayOfWeek = daysOfWeek[date.getDay()];

        let time = dayOfWeek + " " + h + ":" + m + ":" + s + " " + session + " ";
        let clockDisplay = document.getElementById("MyClockDisplay");

        clockDisplay.innerText = time;
        clockDisplay.textContent = time;

        setTimeout(showTime, 1000);
    }
})();
