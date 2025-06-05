// class EventCalendar {
//     constructor() {
//         this.initProperties();
//         this.initialize();
//     }
//
//     initProperties() {
//         this.currentYear = '';
//         this.currentMonth = '';
//         this.persianMonthIcons = ["🌼", "🦋", "🌿", "🌞", "🏝️", "🍂", "🍁", "🌦️", "🌧️", "❄", "⛄", "🏔️"];
//         this.persianWeekdayNames = ["SAT", "SUN", "MON", "TUE", "WED", "THU", "FRI"];
//         this.getElements();
//     }
//
//     getElements() {
//         this.prevMonthButton = document.getElementById("prevMonthButton");
//         this.nextMonthButton = document.getElementById("nextMonthButton");
//         this.calendarContainer = document.getElementById("calendar");
//         this.currentMonthDiv = document.getElementById("currentMonth");
//     }
//
//     changeToPersianDate(date) {
//         return moment(date).format("jYYYY-jMM-jDD").split("-").map(Number);
//     }
//
//     createCalendar(year, month) {
//         this.calendarContainer.innerHTML = "";
//         const persianDate = moment(`${year}-${month + 1}-1`, "jYYYY-jM-jD");
//         this.currentMonthDiv.textContent = `${this.persianMonthIcons[persianDate.jMonth()]} ${persianDate.format('jMM-jYYYY')}`;
//
//         this.calendarContainer.append(...this.createWeekdayElements(), ...this.createEmptyDayElements(persianDate), ...this.createDayElements(persianDate, year, month));
//     }
//
//     createWeekdayElements() {
//         return this.persianWeekdayNames.map(weekday => this.createElement("div", ["day", "bg-main-mode", "rounded-sm"], weekday));
//     }
//
//     createEmptyDayElements(persianDate) {
//         return new Array((persianDate.weekday() % 7) + 1).fill(null).map(() => this.createElement("div", ["day", "empty"]));
//     }
//
//     createDayElements(persianDate, year, month) {
//         return new Array(persianDate.daysInMonth()).fill(null).map((_, i) => {
//             const dayElement = this.createElement("div", ["day"], i + 1);
//             if (moment(`${year}-${month + 1}-${i + 1}`, "jYYYY-jM-jD").isSame(moment(), "day")) dayElement.classList.add("bg-main-mode");
//             return dayElement;
//         });
//     }
//
//     createElement(tag, classes = [], textContent = "") {
//         const element = document.createElement(tag);
//         element.classList.add(...classes);
//         element.textContent = textContent;
//         return element;
//     }
//
//     initialize() {
//         [this.currentYear, this.currentMonth] = this.changeToPersianDate(new Date());
//         this.currentMonth -= 1;
//         this.createCalendar(this.currentYear, this.currentMonth);
//         this.bindEventListeners();
//     }
//
//     bindEventListeners() {
//         this.prevMonthButton.addEventListener("click", this.navigateToPreviousMonth.bind(this));
//         this.nextMonthButton.addEventListener("click", this.navigateToNextMonth.bind(this));
//     }
//
//     navigateToPreviousMonth() {
//         this.currentMonth = (this.currentMonth - 1 + 12) % 12;
//         if (this.currentMonth === 11) this.currentYear -= 1;
//         this.createCalendar(this.currentYear, this.currentMonth);
//     }
//
//     navigateToNextMonth() {
//         this.currentMonth = (this.currentMonth + 1) % 12;
//         if (this.currentMonth === 0) this.currentYear += 1;
//         this.createCalendar(this.currentYear, this.currentMonth);
//     }
// }
//
// const calendar = new EventCalendar();
