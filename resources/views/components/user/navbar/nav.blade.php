<div
    x-data="{
        showNav: false,
        visible: false,
        menu: false,
        text: '',
        position: {x: 0, y: 0},
        openMenu: null,
        mobileMenuOpen: false,
        baseTitle: '',
        titleInterval: null,
        get hasBadges() {
            return ['feedBadge', 'suggestionBadge', 'dmsBadge', 'thsBadge']
                .some(ref => this.$refs[ref] && parseInt(this.$refs[ref].textContent) > 0);
        },
        flashTitle() {
            let show = true;
            const count = ['feedBadge', 'suggestionBadge', 'dmsBadge', 'thsBadge']
                .reduce((sum, ref) => sum + (parseInt(this.$refs[ref]?.textContent) || 0), 0);
            this.titleInterval = setInterval(() => {
                document.title = show
                    ? `(${count}) اقلام جدید در انتظار بررسی`
                    : this.baseTitle;
                show = !show;
            }, 2000);
        },
        stopTitleAnimation() {
            if (this.titleInterval) {
                clearInterval(this.titleInterval);
                this.titleInterval = null;
                document.title = this.baseTitle;
            }
        },
        updateTitle() {
            this.stopTitleAnimation();
            this.hasBadges
             ? this.flashTitle()
             : (document.title = this.baseTitle);
        },
        showTooltip(message, event, direction=false) {
            if (window.innerWidth >= 1024) return;
            const target = event.currentTarget || event.target;
            const rect = target.getBoundingClientRect();
            const x = (rect.left + rect.width / 2) + (direction ? (-20) : 50);
            const y = rect.top - 8;
            this.text = message;
            this.position = { x, y };
            this.visible = true;
        },
        hideTooltip() {
            this.visible = false;
        },
        toggleMenu(menu) {
            this.openMenu = this.openMenu === menu ? null : menu;
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
            if (!el) return;

            const start = window.scrollY;
            const rect = el.getBoundingClientRect();
            const end = start + rect.top - 80;
            const duration = 800;
            this.animateScroll(start, end, duration);
        }
    }"
    x-init="
        baseTitle = document.title;
        updateTitle();
    ">
    {{--    Dynamic NavBar load Btn--}}
    @unless($hasActiveModule)
        <x-user.navbar.button/>
    @endunless

    {{--   NavBar --}}
    <div x-show="showNav"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0">
        <nav
            dir="rtl"
            x-show="!menu && !presence && !version"
            @click.away="openMenu = null"
            @keydown.escape.window="mobileMenuOpen = false; openMenu = null"
            @class([
               'persol-farsi-font py-3 px-4 lg:px-6 sticky top-0 transition-all duration-300 border-t backdrop-blur-lg z-20',
               'border-gray-700/75' => isDarkMode(),
               'border-gray-100' => !isDarkMode()
               ])>

            <div class="w-full md:container md:mx-auto flex items-center justify-between gap-6">
                {{--  Mobile + --}}
                <div class="flex items-center lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                            @class([
                                'persol-farsi-font py-3 px-4 lg:px-6 sticky top-0 z-50 transition-all duration-300 backdrop-blur-lg',
                                'border-gray-700/75' => isDarkMode(),
                                'border-gray-100' => !isDarkMode(),
                            ])
                            aria-controls="mobile-menu">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas text-main"
                           @mouseenter="showTooltip('سایر', $event, 'rtl')"
                           @mouseleave="hideTooltip()"
                           :class="{'fa-minus': mobileMenuOpen, 'fa-plus': !mobileMenuOpen}" aria-hidden="true"></i>
                        <span class="sr-only" x-text="mobileMenuOpen ? 'Close menu' : 'Open menu'"></span>
                    </button>
                </div>
                {{--  Desktop NavBar --}}
                <x-user.navbar.desktop/>
                <x-user.navbar.badges/>
            </div>
            {{--  Responsive NavBar --}}
            <x-user.navbar.mobile/>
            <x-user.navbar.tooltip/>
        </nav>
        <div id="sloganModal"
             class="fixed inset-0 hidden z-[999] bg-gray-900 bg-opacity-50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-white p-6 rounded-xl shadow-2xl max-w-md w-full relative dark:bg-gray-800">
                <p class="text-gray-500 dark:text-gray-300"></p>
            </div>
        </div>
    </div>
</div>
