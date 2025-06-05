export default class Table {

    constructor() {
        this.index = 0;
        this.divs = document.getElementsByClassName("date");
        this.links = document.getElementsByClassName("days");
    }

    addOneday(date) {
        return date.setDate(date.getDate() + this.index);
    }

    convertPersianToLatin(n) {
        return n.replace(/[٠-٩]/g, d => "٠١٢٣٤٥٦٧٨٩".indexOf(d)).replace(/[۰-۹]/g, d => "۰۱۲۳۴۵۶۷۸۹".indexOf(d));
    }

    getPersianDay(date) {
        return this.convertPersianToLatin(date.toLocaleDateString("fa-IR", {day: "numeric"}));
    }

    getPersianMonth(date) {
        return this.convertPersianToLatin(date.toLocaleDateString("fa-IR", {month: "numeric"}));
    }

    listDays() {
        while (this.index < this.divs.length) {
            let date = new Date();
            // adding one day to current days til the end of week
            this.addOneday(date);
            //for users' view
            this.divs[this.index].innerHTML = this.showDayAndMonth(date);
            //for sending to backend by dataset-date
            this.links[this.index].dataset.date = this.showDayOnly(date);
            this.index++;
        }
    }

    showDayOnly(date) {
        return parseInt(this.getPersianDay(date));
    }

    showDayAndMonth(date) {
        return parseInt(this.getPersianDay(date)) + " | " + this.getPersianMonth(date);
    }
}
