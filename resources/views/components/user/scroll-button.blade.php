<div x-data="{
        showScrollToTop: false,
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
        scrollToTop() {
            const start = window.pageYOffset;
            const end = 0;
            const duration = 800;
            this.animateScroll(start, end, duration, () => {
                console.log('Scrolled to top');
            });
        }
    }"
     x-init="window.addEventListener('scroll', () => { showScrollToTop = window.pageYOffset > 600; })"
     class="fixed bottom-4 right-4 z-50">
    <button x-show="showScrollToTop"
            @click="scrollToTop()"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            type="button" title="Scroll to top"
            class="text-center px-2 py-1 transition-all duration-300 text-white text-xl bg-main-mode shadow-lg rounded-lg group-hover:scale-110">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>
</div>
