<nav id="mainNav"
     dir="rtl"
     x-data="{
                visible: false,
                version: false,
                text: '',
                position: {x: 0, y: 0},
                showTooltip(message, event) {
                    this.text = message;
                    this.position = {
                        x: event.clientX,
                        y: event.clientY + 35
                    };
                    this.visible = true;
                },
                hideTooltip() {
                    this.visible = false;
                    this.text = '';
                },
                easeInOutCubic(t) {
                    return t < 0.5
                        ? 4 * t * t * t
                        : 1 - Math.pow(-2 * t + 2, 3) / 2;
                },
                animateScroll(start, end, duration, callback) {
                    const startTime = performance.now();
                    const animate = (currentTime) => {
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        const ease = this.easeInOutCubic(progress);
                        const currentPosition = start + (end - start) * ease;
                        window.scrollTo(0, currentPosition);
                        if (progress < 1) {
                            requestAnimationFrame(animate);
                        } else {
                            if (callback) callback();
                        }
                    };
                    requestAnimationFrame(animate);
                },
                scrollToSection(target) {
                    const el = document.querySelector(target);
                    if (!el) {
                        return;
                    }
                    const start = window.pageYOffset;
                    const rect = el.getBoundingClientRect();
                    const end = start + rect.top - 80;
                    const duration = 800;

                    this.animateScroll(start, end, duration);
                }
            }"
     x-show="!version"
     @class([
        'persol-farsi-font bg-gray-200 shadow-md py-2 px-4 sticky top-0 z-50 transition duration-300 scrollbar-hide animate-[fade-in-left_1s_ease-in-out]',
        'text-gray-800' => isDarkMode(),
           ])>
    <div id="navContainer"
         class="w-full md:container md:mx-auto flex items-center justify-start space-x-6 overflow-x-auto overflow-y-hidden scrollbar-hide px-4 relative">
        {{-- Admin Panel Icon --}}
        @if (isAdmin(auth()->user()))
            <div class="flex flex-col items-center text-center ml-4">
                <a href="/main/admin"
                   @mouseenter="window.innerWidth > 768 && showTooltip('ورود به ادمین پنل', $event)"
                   @mouseleave="hideTooltip()"
                   class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                    <i class="fas fa-cogs"></i>
                </a>
                <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>ادمین</span>
            </div>
        @endif
        {{-- Parking Icon --}}
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('dashboard',['type'=>'parking']) }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('ورود به پنل رزرواسیون پارکینگ', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fas fa-parking"></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>رزرو...</span>
        </div>
        {{-- Calendar Icon --}}
        <div class="flex flex-col items-center text-center">
            <a @click.prevent="scrollToSection('#calendar')"
               @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده تقویم سازمانی برای تولد، سالگرد و رویداد های مهم', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110 cursor-pointer">
                <i class="fas fa-calendar-alt"></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>تقویم</span>
        </div>
        {{-- Bulletin Icon --}}
        <div class="flex flex-col items-center text-center">
            <a @click.prevent="scrollToSection('#bulletin')"
               @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده اعلانات واحد منابع/سرمایه انسانی', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110 cursor-pointer">
                <i class="fa fa-newspaper-o"></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>اعلانات</span>
        </div>
        {{-- Personnel Icon --}}
        <div class="flex flex-col items-center text-center">
            <a @click="scrollToSection('#personnel')"
               @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده وضعیت حضور پرسنل', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110 cursor-pointer">
                <i class="fas fa-users"></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>پرسنل</span>
        </div>
        {{-- Report Icon --}}
        <div class="flex flex-col items-center text-center">
            <a @click="scrollToSection('#report')"
               @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده گزارشات سازمانی', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110 cursor-pointer">
                <i class="fas fa-chart-line"></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>گزارشات </span>
        </div>
        {{-- Tools Icon --}}
        <div class="flex flex-col items-center text-center">
            <a @click="scrollToSection('#tools')"
               @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده ابزار سازمانی/لینک های خارچی', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110 cursor-pointer">
                <i class="fas fa-external-link-alt"></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>ابزار </span>
        </div>
        {{-- Links Icon --}}
        <div class="flex flex-col items-center text-center">
            <a @click="scrollToSection('#links')"
               @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده لینک های داخلی', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110 cursor-pointer">
                <i class="fas fa-link"></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>لینک </span>
        </div>
        {{-- FAQ Icon --}}
        <div class="flex flex-col items-center text-center">
            <a @click="scrollToSection('#faq')"
               @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده پرسش و پاسخ های متداول', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110 cursor-pointer">
                <i class="fas fa-question-circle"></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>سوالات...</span>
        </div>
        {{-- Suggestion Icon --}}
        <div class="flex flex-col items-center text-center relative">
            <a href="{{ route('user.panel.suggestion') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('ورود/مشاهده پنل پیشنهادات', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fa fa-bullhorn"></i>
            </a>
            @if(showSuggestionBadge())
                <span
                    @mouseenter="window.innerWidth > 768 && showTooltip('پیشنهادات در جریان', $event)"
                    @mouseleave="hideTooltip()"
                    class="absolute top-0 right-0 w-6 h-6 bg-red-600 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                    {{ showSuggestionBadgeNumber() }}
                </span>
            @elseif(showSuggestionCEOBadge())
                <span
                    @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده تمامی پیشنهادات', $event)"
                    @mouseleave="hideTooltip()"
                    class="absolute top-0 right-0 w-6 h-6 bg-orange-500 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                    {{ showSuggestionCEOBadgeNumber() }}
                </span>
            @endif
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>پیشنهادات</span>
        </div>
        {{-- DMS Icon --}}
        <div class="flex flex-col items-center text-center relative">
            <a href="{{ route('user.panel.dms') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('ورود به پنل مدیریت اسناد سازمانی', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fa fa-archive"></i>
            </a>
            @if(getUnsignedDocCount() > 0)
                <span
                    @mouseenter="window.innerWidth > 768 && showTooltip('تایید اسناد سازمانی', $event)"
                    @mouseleave="hideTooltip()"
                    class="absolute top-0 right-0 w-6 h-6 bg-red-600 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                    {{ getUnsignedDocCount() }}
                </span>
            @elseif(getUnreadDocCount() > 0)
                <span
                    @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده اسناد سازمانی', $event)"
                    @mouseleave="hideTooltip()"
                    class="absolute top-0 right-0 w-6 h-6 bg-orange-500 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                    {{ getUnreadDocCount() }}
                </span>
            @endif
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>اسناد</span>
        </div>
        {{-- THS Icon --}}
        <div class="flex flex-col items-center text-center relative">
            <a href="{{ route('user.panel.ths') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('ورود به پنل ارسال تیکت', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fas fa-ticket-alt"></i>
            </a>
            @if(getOpenTicketCount() > 0)
                <span
                    @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده تیکت های بررسی نشده', $event)"
                    @mouseleave="hideTooltip()"
                    class="absolute top-0 right-0 w-6 h-6 bg-red-600 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                    {{ getOpenTicketCount() }}
                </span>
            @elseif(getInProgressTicketCount() > 0)
                <span
                    @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده تیکت های در جریان', $event)"
                    @mouseleave="hideTooltip()"
                    class="absolute top-0 right-0 w-6 h-6 bg-orange-500 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                    {{ getInProgressTicketCount() }}
                </span>
            @endif
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>تیکت</span>
        </div>
        {{-- Profile Edit Icon --}}
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('user.panel.edit') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده/ویرایش پروفایل', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fas fa-portrait"></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>پروفایل</span>
        </div>
        {{-- Delegation Panel Icon --}}
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('user.panel.delegation') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده اختیارات', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class='fas fa-tasks'></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>اختیارات</span>
        </div>
        {{-- Onboarding Icon --}}
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('user.panel.onboarding') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده نکات مهم در مرحله آنبوردینگ', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fa fa-road"></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>آنبوردینگ</span>
        </div>
        {{-- Analytics Icon --}}
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('user.panel.analytics') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده آنالیتیک اعضای سازمان', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fas fa-chart-bar"></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>آنالیتیک</span>
        </div>
        {{-- Music Icon --}}
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('user.panel.music') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('ورود به پنل پخش موسیقی', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fa fa-headphones"></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>موسیقی</span>
        </div>
        {{-- CRM Icon --}}
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('crm') }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('ورود به خروجی سی آر ام سرو', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fas fa-database"></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>سی آر ام</span>
        </div>
        {{-- Office Icon --}}
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('dashboard',['type'=>'office']) }}"
               @mouseenter="window.innerWidth > 768 && showTooltip('ورود به پنل رزرواسیون میز سازمانی', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fas fa-building"></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>رزرو...</span>
        </div>
        {{-- Calculator Icon --}}
        <div class="flex flex-col items-center text-center cursor-pointer">
            <a id="openCalculator"
               @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده ماشین حساب', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fas fa-calculator"></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>ماشین...</span>
        </div>
        {{-- Audio Timer Icon --}}
        <div class="flex flex-col items-center text-center cursor-pointer">
            <a id="playAudioButton"
               @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده و تنظیم تایمر', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i id="clockIcon" class="fas fa-clock"></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>تایمر</span>
        </div>
        {{-- Slogan Icon --}}
        <div class="flex flex-col items-center text-center cursor-pointer">
            <a id="sloganLink"
               @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده اصول سازمانی', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-5 py-2 bg-main-mode text-xl text-white rounded shadow-lg"
            >
                <i class="fas fa-lightbulb"></i>
            </a>
            <span @class([
                   'mt-1 text-sm text-gray-700',
                   'text-gray-300 ' => isDarkMode(),
                 ])>اصول...</span>
        </div>
    </div>
    <x-user.navbar.tooltip/>
</nav>
<div id="sloganModal"
     class="fixed inset-0 hidden z-50 bg-gray-500 bg-opacity-75 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
        <p class="text-gray-500"></p>
    </div>
</div>
<x-user.navbar.calculator/>
