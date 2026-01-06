<div
    x-data="{ tooltipVisible: false, tooltipText: '' }"
    class="fixed top-1/4 left-0 w-8 h-8 md:w-10 md:h-10 bg-main-mode text-white flex group persol-farsi-font
           justify-center items-center rounded hover:w-40 cursor-pointer transition-all duration-300 z-10"
>
    <i class="fa fa-briefcase transition duration-300 ease-in-out transform text-xl group-hover:hidden"></i>

    <!-- Hidden icon that reset the sorting order of modules-->
    <i
        @mouseenter="tooltipVisible = true; tooltipText = 'بازنشانی چیدمان و حافظه پنهان'"
        @mouseleave="tooltipVisible = false"
        @click="clearAppCacheAndReload()"
        class="fas fa-redo hidden transition duration-300 ease-in-out delay-500 transform text-xl mx-2 group-hover:inline-block"
    ></i>

    <!-- Hidden icon that opens the '/daily-report-office' link in a new tab when clicked -->
    <i
        @mouseenter="tooltipVisible = true; tooltipText = 'مشاهده سریع رزروهای میز کار'"
        @mouseleave="tooltipVisible = false"
        @click="window.open('/daily-report-office', '_blank')"
        class="fas fa-desktop hidden transition duration-300 ease-in-out delay-500 transform mx-2 group-hover:inline-block"
    ></i>

    <!-- Hidden icon that opens the '/daily-report-parking' link in a new tab when clicked -->
    <i
        @mouseenter="tooltipVisible = true; tooltipText = 'مشاهده سریع رزروهای پارکینگ'"
        @mouseleave="tooltipVisible = false"
        @click="window.open('/daily-report-parking', '_blank')"
        class="fas fa-car hidden transition duration-300 ease-in-out delay-500 transform text-xl mx-2 group-hover:inline-block"
    ></i>

    <div
        x-show="tooltipVisible"
        x-text="tooltipText"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 -translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 -translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="custom-tooltip absolute -top-12 left-28 -translate-x-1/2 min-w-max bg-gray-800 text-white text-sm rounded-md px-3 py-1.5 shadow-lg"
        x-cloak
    ></div>
</div>
