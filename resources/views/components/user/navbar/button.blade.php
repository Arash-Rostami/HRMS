<div x-data="{ tooltipVisible: false }">
    <button
        @mouseenter="tooltipVisible = true"
        @mouseleave="tooltipVisible = false"
        @click.prevent="(!showNav) ? scrollToSection('#header') : null; showNav = !showNav;"
        :class="{'text-green-300': showNav}"
        @class([
            'fixed top-[20%] right-0 w-12 h-12 bg-main-mode text-white flex group justify-center items-center rounded-l hover:w-32 cursor-pointer transition-all duration-300 z-50 shadow-lg',
            'hover:bg-blue-700' => !isDarkMode(),
            'hover:bg-blue-600' => isDarkMode(),
        ])>
        <i x-show="!showNav" class="fas fa-bars transition duration-300 ease-in-out transform text-xl ml-1"></i>
        <i x-show="showNav"
           class="fa fa-spinner fa-spin transition duration-300 ease-in-out transform text-xl ml-1"></i>
        <span
            class="hidden transition duration-300 ease-in-out mr-2 delay-500 transform font-medium uppercase tracking-wider group-hover:inline-block"
            x-text="showNav ? 'باز شده' : 'بسته'">
                </span>
        <span x-show="hasBadges && !showNav"
              title="اقلام جدید در انتظار بررسی"
              class="absolute -top-1 -left-1 flex items-center justify-center cursor-help"
              role="status"
              aria-label="اقلام جدید در انتظار بررسی">
                <span class="relative flex h-3 w-3">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                </span>
            </span>
        <div
            x-show="tooltipVisible"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 -translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 -translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="absolute -top-12 right-1/2 translate-x-1/2 min-w-max bg-gray-800 text-white text-sm rounded-md px-3 py-1.5 shadow-lg"
            x-cloak> باز و بستن منو
        </div>
    </button>
</div>
