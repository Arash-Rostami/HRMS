<div class="flex flex-col md:flex-row justify-center items-center space-y-2 md:space-y-0 md:space-x-4 p-4 bg-main-mode relative rounded mb-1 @if(isDarkMode()) bg-main @endif">
    <!-- Step 1: ارسال پیشنهاد به واحدهای ذی نفع -->
    <div
        class="flex items-center justify-center bg-neutral-300 border-2 border-neutral-500 rounded-lg p-4 md:w-1/6 w-full">
        <i class="fas fa-paper-plane text-neutral-900 ml-2"></i>
        <span class="text-sm text-neutral-900">ارسال پیشنهاد ارسال شده به واحدهای ذی نفع</span>
    </div>

    <!-- Arrow between step 1 and step 2 -->
    <div class="flex justify-center items-center md:w-12 w-full">
        <!-- Arrow down for mobile -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-neutral-600 md:hidden" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
        <!-- Arrow left for desktop -->
        <svg xmlns="http://www.w3.org/2000/svg" class="hidden md:block h-6 w-6 text-neutral-600" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </div>

    <!-- Step 2: ثبت بازخورد توسط مدیر/سرپرست واحد -->
    <div
        class="flex items-center justify-center bg-neutral-300 border-2 border-neutral-500 rounded-lg p-4 md:w-1/6 w-full">
        <i class="fas fa-clipboard-check text-neutral-900 ml-2"></i>
        <span class="text-sm text-neutral-900">ثبت بازخورد توسط مدیر یا سرپرست واحد (های) ذی نفع</span>
    </div>

    <!-- Arrow between step 2 and step 3 -->
    <div class="flex justify-center items-center md:w-auto w-full">
        <!-- Arrow down for mobile -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-neutral-600 md:hidden" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
        <!-- Arrow left for desktop -->
        <svg xmlns="http://www.w3.org/2000/svg" class="hidden md:block h-6 w-6 text-neutral-600" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </div>

    <!-- Step 3: جمع آوری بازخوردها از همه واحدها -->
    <div
        class="flex items-center justify-center bg-neutral-300 border-2 border-neutral-500 rounded-lg p-4 md:w-1/6 w-full">
        <i class="fas fa-comments text-neutral-900 ml-2"></i>
        <span class="text-sm text-neutral-900">جمع آوری بازخوردها از همه واحدهای ذی نفع</span>
    </div>

    <!-- Arrow between step 3 and step 4 -->
    <div class="flex justify-center items-center md:w-auto w-full">
        <!-- Arrow down for mobile -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-neutral-600 md:hidden" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
        <!-- Arrow left for desktop -->
        <svg xmlns="http://www.w3.org/2000/svg" class="hidden md:block h-6 w-6 text-neutral-600" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </div>

    <!-- Step 4: ارسال پیشنهاد توسط بازخوردها به مدیریت -->
    <div
        class="flex items-center justify-center bg-neutral-300 border-2 border-neutral-500 rounded-lg p-4 md:w-1/6 w-full">
        <i class="fas fa-share-alt text-neutral-900 ml-2"></i>
        <span class="text-sm text-neutral-900">ارسال پیشنهاد همراه با بازخوردها به مدیریت</span>
    </div>

    <!-- Arrow between step 4 and step 5 -->
    <div class="flex justify-center items-center md:w-auto w-full">
        <!-- Arrow down for mobile -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-neutral-600 md:hidden" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
        <!-- Arrow left for desktop -->
        <svg xmlns="http://www.w3.org/2000/svg" class="hidden md:block h-6 w-6 text-neutral-600" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </div>

    <!-- Step 5: بررسی پیشنهاد توسط مدیریت و ارایه نظر -->
    <div
        class="flex items-center justify-center bg-neutral-300 border-2 border-neutral-500 rounded-lg p-4 md:w-1/6 w-full">
        <i class="fas fa-eye text-neutral-900 ml-2"></i>
        <span class="text-sm text-neutral-900">بررسی پیشنهاد توسط مدیریت و تصمیم گیری نهایی</span>
    </div>
</div>
<div
    class="flex flex-col md:flex-row justify-center items-center space-y-4 md:space-y-0 md:space-x-4 p-4 bg-main-mode relative mb-2 text-justify text-sm  text-neutral-900 rounded @if(isDarkMode()) bg-main text-main @endif">
    <ul class="list-disc pr-5">
        <li>
            برای حصول اطمینان از دریافت نظرات و متعاقباً رسیدن پیشنهاد به مدیریت، لطفاً از طریق مدیر یا سرپرست واحد
            ذی نفع پیگیری کنید تا تأیید کنند که بازخورد خود را ارائه داده‌اند.
        </li>
        <li>
            بازخوردهای دریافتی را میتوانید به راحتی در جدول پیشنهادات در تب مجاور مشاهده کنید. کافی است روی نام واحد
            کلیک کرده تا بازخوردهای مربوطه در پایین جدول ظاهر شده و نمایش داده شوند.
        </li>
        <li>
            در صورت اطلاع از بازخورد مدیران یا سرپرستان واحدهای ذی نفع و در راستای تسریع فرایند حاضر، می‌توانید با
            فعال‌سازی بخش انتهایی قرار داده شده در این فرم، نظرات آن‌ها را نیز ثبت کنید.
        </li>
    </ul>
</div>
