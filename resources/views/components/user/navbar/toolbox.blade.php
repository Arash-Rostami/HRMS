<div class="fixed top-3/4 left-0 w-8 h-8 md:w-10 md:h-10 bg-main-mode text-white flex group
         justify-center items-center rounded hover:w-32 cursor-pointer transition-all duration-300 z-9">
    <i class="fa fa-briefcase transition duration-300 ease-in-out transform text-xl group-hover:hidden"></i>

    <!-- Hidden icon that opens the '/daily-report-office' link in a new tab when clicked -->
    <i class="fas fa-desktop hidden transition duration-300 ease-in-out delay-500 transform mx-2 group-hover:inline-block"
       @click="window.open('/daily-report-office', '_blank')" title="quick peek into daily office reservation">
    </i>

    <!-- Hidden icon that opens the '/daily-report-parking' link in a new tab when clicked -->
    <i class="fas fa-car hidden transition duration-300 ease-in-out delay-500 transform text-xl mx-2 group-hover:inline-block"
       @click="window.open('/daily-report-parking', '_blank')" title="quick peek into daily parking reservation">
    </i>
</div>
