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
                swipeLeft() {
                    const container = document.getElementById('navContainer');
                    if (container) {
                        container.scrollBy({ left: -200, behavior: 'smooth' });
                    }
                },
                swipeRight() {
                    const container = document.getElementById('navContainer');
                    if (container) {
                        container.scrollBy({ left: 200, behavior: 'smooth' });
                    }
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
       'text-gray-800 bg-gray-400' => isDarkMode(),
          ])>
    <!-- Left Arrow -->
    <div x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="absolute left-0 top-0 h-full flex items-center z-10 bg-gradient-to-r from-gray-200/90 to-transparent pl-1 pr-2 md:pl-2 md:pr-3"
         :class="{ 'from-gray-400/90': {{isDarkMode()}} }">
        <button @click="swipeLeft()"
                @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده آیتم های قبلی', $event)"
                @mouseleave="hideTooltip()"
                class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-main-mode/80 text-white shadow-xl transition-all duration-200 flex items-center justify-center backdrop-blur-sm hover:bg-gray-500">
            <i class="fas fa-chevron-left text-xs md:text-sm"></i>
        </button>
    </div>
    <!-- Right Arrow -->
    <div x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="absolute right-0 top-0 h-full flex items-center z-10 bg-gradient-to-l from-gray-200/90 to-transparent pr-1 pl-2 md:pr-2 md:pl-3"
         :class="{ 'from-gray-400/90': {{isDarkMode()}} }">
        <button @click="swipeRight()"
                @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده آیتم های بعدی', $event)"
                @mouseleave="hideTooltip()"
                class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-main-mode/80 text-white shadow-xl transition-all duration-200 flex items-center justify-center backdrop-blur-sm hover:bg-gray-500">
            <i class="fas fa-chevron-right text-xs md:text-sm"></i>
        </button>
    </div>

    <div id="navContainer"
         class="w-full md:container md:mx-auto flex items-center justify-start space-x-6 overflow-x-auto overflow-y-hidden scrollbar-hide px-4 relative">
        {{-- Admin Panel Icon --}}
        @if (isAdmin(auth()->user()))
            <x-user.navbar.icon href="/main/admin"
                                icon="fas fa-cogs"
                                label="ادمین"
                                tooltip="ورود به ادمین پنل"/>
        @endif
        {{-- Parking Icon --}}
        <x-user.navbar.icon href="{{ route('dashboard',['type'=>'parking']) }}"
                            icon="fas fa-parking"
                            label="رزرو..."
                            tooltip="ورود به پنل رزرواسیون پارکینگ"/>
        {{-- Calendar Icon --}}
        <x-user.navbar.icon
            href=""
            @click.prevent="scrollToSection('#calendar')"
            icon="fas fa-calendar-alt"
            label="تقویم"
            tooltip="مشاهده تقویم سازمانی برای تولد، سالگرد و رویداد های مهم"/>
        {{-- Bulletin Icon --}}
        <x-user.navbar.icon
            href=""
            @click.prevent="scrollToSection('#bulletin')"
            icon="fa fa-newspaper-o"
            label="اعلانات"
            tooltip="مشاهده اعلانات واحد منابع/سرمایه انسانی"/>
        {{-- Personnel Icon --}}
        <x-user.navbar.icon href=""
                            @click.prevent="scrollToSection('#personnel')"
                            icon="fas fa-users"
                            label="پرسنل"
                            tooltip="مشاهده وضعیت حضور پرسنل"/>
        {{-- Report Icon --}}
        <x-user.navbar.icon href=""
                            @click.prevent="scrollToSection('#report')"
                            icon="fas fa-chart-line"
                            label="گزارشات"
                            tooltip="مشاهده گزارشات سازمانی"/>
        {{-- Tools Icon --}}
        <x-user.navbar.icon href="" @click.prevent="scrollToSection('#tools')"
                            icon="fas fa-external-link-alt"
                            label="ابزار"
                            tooltip="مشاهده ابزار سازمانی/لینک های خارچی"/>
        {{-- Links Icon --}}
        <x-user.navbar.icon href=""
                            @click.prevent="scrollToSection('#links')"
                            icon="fas fa-link" label="لینک"
                            tooltip="مشاهده لینک های داخلی"/>
        {{-- FAQ Icon --}}
        <x-user.navbar.icon href=""
                            @click.prevent="scrollToSection('#faq')"
                            icon="fas fa-question-circle"
                            label="سوالات..."
                            tooltip="مشاهده پرسش و پاسخ های متداول"/>
        {{-- Suggestion Icon (with custom badge) --}}
        <x-user.navbar.icon href="{{ route('user.toggleModule', ['module' => 'suggestion']) }}"
                            icon="fa fa-bullhorn"
                            label="پیشنهادات"
                            tooltip="ورود/مشاهده پنل پیشنهادات">
            @if(showSuggestionBadge())
                <span @mouseenter="window.innerWidth > 768 && showTooltip('پیشنهادات در جریان', $event)"
                      @mouseleave="hideTooltip()"
                      class="absolute top-0 right-0 w-6 h-6 bg-red-600 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                {{ showSuggestionBadgeNumber() }}
            </span>
            @elseif(showSuggestionCEOBadge())
                <span @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده تمامی پیشنهادات', $event)"
                      @mouseleave="hideTooltip()"
                      class="absolute top-0 right-0 w-6 h-6 bg-orange-500 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                {{ showSuggestionCEOBadgeNumber() }}
            </span>
            @endif
        </x-user.navbar.icon>
        {{-- DMS Icon (with custom badge) --}}
        <x-user.navbar.icon href="{{ route('user.toggleModule', ['module' => 'dms']) }}"
                            icon="fa fa-archive"
                            label="اسناد"
                            tooltip="ورود به پنل مدیریت اسناد سازمانی">
            @if(getUnsignedDocCount() > 0)
                <span @mouseenter="window.innerWidth > 768 && showTooltip('تایید اسناد سازمانی', $event)"
                      @mouseleave="hideTooltip()"
                      class="absolute top-0 right-0 w-6 h-6 bg-red-600 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                {{ getUnsignedDocCount() }}
            </span>
            @elseif(getUnreadDocCount() > 0)
                <span @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده اسناد سازمانی', $event)"
                      @mouseleave="hideTooltip()"
                      class="absolute top-0 right-0 w-6 h-6 bg-orange-500 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                {{ getUnreadDocCount() }}
            </span>
            @endif
        </x-user.navbar.icon>
        {{-- THS Icon (with custom badge) --}}
        <x-user.navbar.icon href="{{ route('user.toggleModule', ['module' => 'ths']) }}"
                            icon="fas fa-ticket-alt"
                            label="تیکت"
                            tooltip="ورود به پنل ارسال تیکت">
            @if(getOpenTicketCount() > 0)
                <span @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده تیکت های بررسی نشده', $event)"
                      @mouseleave="hideTooltip()"
                      class="absolute top-0 right-0 w-6 h-6 bg-red-600 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                {{ getOpenTicketCount() }}
            </span>
            @elseif(getInProgressTicketCount() > 0)
                <span @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده تیکت های در جریان', $event)"
                      @mouseleave="hideTooltip()"
                      class="absolute top-0 right-0 w-6 h-6 bg-orange-500 text-white text-xs font-bold text-center rounded-full flex items-center justify-center cursor-help">
                {{ getInProgressTicketCount() }}
            </span>
            @endif
        </x-user.navbar.icon>
        {{-- Profile Edit Icon --}}
        <x-user.navbar.icon href="{{ route('user.panel.edit') }}"
                            icon="fas fa-portrait"
                            label="پروفایل"
                            tooltip="مشاهده/ویرایش پروفایل"/>
        {{-- Energy Panel Icon --}}
        <x-user.navbar.icon href="{{ route('user.toggleModule', ['module' => 'energy']) }}"
                            icon="fas fa-battery-full"
                            label="انرژی"
                            tooltip="پرسشنامه(آمار) انرژی فردی/سازمانی">
            <span
                class="absolute top-0 -left-4 -rotate-12 bg-green-500 text-white text-xs px-1 py-1 rounded-full animate-pulse">جدید</span>
        </x-user.navbar.icon>
        {{-- Delegation Panel Icon --}}
        <x-user.navbar.icon href="{{ route('user.toggleModule', ['module' => 'delegation']) }}"
                            icon="fas fa-tasks"
                            label="اختیارات"
                            tooltip="مشاهده اختیارات"/>
        {{-- Onboarding Icon --}}
        <x-user.navbar.icon href="{{ route('user.toggleModule', ['module' => 'onboarding']) }}"
                            icon="fa fa-road"
                            label="آنبوردینگ"
                            tooltip="مشاهده نکات مهم در مرحله آنبوردینگ"/>
        {{-- Analytics Icon --}}
        <x-user.navbar.icon href="{{ route('user.toggleModule', ['module' => 'analytics']) }}"
                            icon="fas fa-chart-bar"
                            label="آنالیتیک"
                            tooltip="مشاهده آنالیتیک اعضای سازمان"/>
        {{-- Music Icon --}}
        <x-user.navbar.icon href="{{ route('user.toggleModule', ['module' => 'music']) }}"
                            icon="fa fa-headphones"
                            label="موسیقی"
                            tooltip="ورود به پنل پخش موسیقی"/>
        {{-- CRM Icon --}}
        <x-user.navbar.icon href="{{ route('crm') }}"
                            icon="fas fa-database"
                            label="سی آر ام"
                            tooltip="ورود به خروجی سی آر ام سرو"/>
        {{-- Office Icon --}}
        <x-user.navbar.icon href="{{ route('dashboard',['type'=>'office']) }}"
                            icon="fas fa-building"
                            label="رزرو..."
                            tooltip="ورود به پنل رزرواسیون میز سازمانی"/>
        {{-- Calculator Icon --}}
        <div class="flex flex-col items-center text-center cursor-pointer">
            <a id="openCalculator"
               @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده ماشین حساب', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i class="fas fa-calculator"></i>
            </a>
            <span @class(['mt-1 text-sm text-gray-700', 'text-gray-300 ' => isDarkMode()])>ماشین...</span>
        </div>
        {{-- Audio Timer Icon --}}
        <div class="flex flex-col items-center text-center cursor-pointer">
            <a id="playAudioButton"
               @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده و تنظیم تایمر', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-4 py-2 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
                <i id="clockIcon" class="fas fa-clock"></i>
            </a>
            <span @class(['mt-1 text-sm text-gray-700', 'text-gray-300 ' => isDarkMode()])>تایمر</span>
        </div>
        {{-- Slogan Icon --}}
        <div class="flex flex-col items-center text-center cursor-pointer">
            <a id="sloganLink"
               @mouseenter="window.innerWidth > 768 && showTooltip('مشاهده اصول سازمانی', $event)"
               @mouseleave="hideTooltip()"
               class="text-center px-5 py-2 bg-main-mode text-xl text-white rounded shadow-lg">
                <i class="fas fa-lightbulb"></i>
            </a>
            <span @class(['mt-1 text-sm text-gray-700', 'text-gray-300 ' => isDarkMode()])>اصول...</span>
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
