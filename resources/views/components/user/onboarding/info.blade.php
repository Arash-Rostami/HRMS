<div class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block
p-2 pr-4 persol-farsi-font animate-[fade-in_1s_ease-in-out]" dir="rtl"
     id="pills-info"
     role="tabpanel"
     aria-labelledby="pills-info">
    <div class="info-bg">
        <!-- Benefits Section -->
        <div class="mb-6 md:mb-10">
            <h2 class="text-main font-bold mb-4 md:mb-6">مزایای شغلی در پرسال</h2>
            <p class="text-main mb-6 leading-relaxed">
                 مجموعه‌ای از امکانات رفاهی و توسعه‌ای برای حمایت از رشد و رفاه شخصی شما در طول مسیر شغلی ‌تان طراحی‌شده، که به شرح زیر می باشند:
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <!-- Financial Benefits -->
                <div @class([
                        'benefit-card p-4 md:p-6 rounded-lg border border-gray-100 shadow-sm',
                        'bg-white' => !isDarkMode(),
                        'text-gray-200 bg-gray-700' => isDarkMode(),
                    ])>
                    <div class="flex items-center mb-3 md:mb-4">
                        <div class="benefit-icon w-8 h-8 md:w-10 md:h-10">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="font-bold">مزایای مالی</h3>
                    </div>
                    <ul class="list-disc pr-4 md:pr-5 space-y-1 md:space-y-2 ">
                        <li>وام‌های شرکتی با شرایط ویژه</li>
                        <li>پاداش‌های عملکرد و برنامه‌های تشویقی</li>
                        <li>پاداش برای معرفی نیروی جدید</li>
                        <li>بسته‌های حمایتی و رفاهی</li>
                    </ul>
                </div>
                <!-- Career Development -->
                <div @class([
                        'benefit-card p-4 md:p-6 rounded-lg border border-gray-100 shadow-sm',
                        'bg-white' => !isDarkMode(),
                        'text-gray-200 bg-gray-700' => isDarkMode(),
                    ])>
                    <div class="flex items-center mb-3 md:mb-4">
                        <div class="benefit-icon w-8 h-8 md:w-10 md:h-10">
                            <i class="fas fa-graduation-cap "></i>
                        </div>
                        <h3 class="font-bold text-base md:text-lg">برنامه‌ریزی شغلی</h3>
                    </div>
                    <ul class="list-disc pr-4 md:pr-5 space-y-1 md:space-y-2 ">
                        <li>دوره‌های آموزشی تخصصی و مهارتی</li>
                        <li>برنامه‌ریزی فردی برای مسیر شغلی</li>
                        <li>همایش‌ها و کارگاه‌های توسعه‌ی شغلی</li>
                        <li>برنامه مربی‌گری (Mentoring) حرفه‌ای</li>
                    </ul>
                </div>
                <!-- Health & Wellness -->
                <div @class([
                        'benefit-card  p-4 md:p-6 rounded-lg border border-gray-100 shadow-sm',
                        'bg-white' => !isDarkMode(),
                        'text-gray-200 bg-gray-700' => isDarkMode(),
                    ])>
                    <div class="flex items-center mb-3 md:mb-4">
                        <div class="benefit-icon w-8 h-8 md:w-10 md:h-10">
                            <i class="fas fa-heartbeat "></i>
                        </div>
                        <h3 class="font-bold text-base md:text-lg">سلامت و شادکامی</h3>
                    </div>
                    <ul class="list-disc pr-4 md:pr-5 space-y-1 md:space-y-2 ">
                        <li>بیمه درمانی تکمیلی</li>
                        <li>کلاب‌های پرسالی: کوهنوردی، کافه‌گردی، تئاتر و...</li>
                        <li>برنامه‌های تناسب اندام و سلامتی</li>
                        <li>برنامه‌های مشاوره روان‌شناسی</li>
                    </ul>
                </div>
                <!-- Work Environment -->
                <div @class([
                        'benefit-card p-4 md:p-6 rounded-lg border border-gray-100 shadow-sm',
                        'bg-white' => !isDarkMode(),
                        'text-gray-200 bg-gray-700' => isDarkMode(),
                    ])>
                    <div class="flex items-center mb-3 md:mb-4">
                        <div class="benefit-icon w-8 h-8 md:w-10 md:h-10">
                            <i class="fas fa-users "></i>
                        </div>
                        <h3 class="font-bold text-base md:text-lg">محیط کار و فرهنگ سازمانی</h3>
                    </div>
                    <ul class="list-disc pr-4 md:pr-5 space-y-1 md:space-y-2 ">
                        <li>ساعت کاری منعطف</li>
                        <li>امکان دورکاری برنامه‌ریزی‌شده</li>
                        <li>رویدادهای تیم‌سازی و بازی‌های گروهی</li>
                        <li>مهمانی‌ها و جشن‌های داخلی</li>
                        <li>سیستم قدردانی و تشویق کارکنان</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
