<div x-data="{
    close: localStorage.getItem('modalClosed') === new Date().toDateString(),
    total: 400,
    progress: 0,
    percentage: 0,
    targetProgress: 54,
    increment() {
        if (this.progress < this.targetProgress) {
            this.progress++;
            this.percentage = (this.progress / this.total) * 100;
        }
    },
    animateProgressBar() {
        const interval = setInterval(() => {
            this.increment();
            if (this.progress >= this.targetProgress) clearInterval(interval);
        }, 10 );
    },
    closeModal() {
        this.close = true;
        localStorage.setItem('modalClosed', new Date().toDateString());
    }
}"
     x-init="animateProgressBar()"
     x-show="!close"
     x-transition
     x-transition:leave.duration.400ms
     class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-4/5 md:w-1/2 h-auto
     px-5 py-2 shadow-lg rounded-md bg-gray-300 @if ( isDarkMode()) bg-main @endif overflow-y-auto z-[1000]"
     title="Winter Sales Goal">
    <div class="mt-3 text-center">
        <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full">
            <img src="/img/user/progressBar.png" alt="progress-bar">
        </div>
        <div>
            <h2 class="text-6xl text-main pt-4 animate-bounce font-extrabold" x-text="progress"></h2>
            <h1 class="text-lg text-center text-gray-500 persol-farsi-font">
                قدم نزدیک‌تر به یک شاهکارِ تیمی
            </h1>
            <div class="flex flex-row items-center">
                <span class="text-right text-gray-500 animate-pulse">0</span>
                <div class="mt-2 px-7 py-3 w-full">
                    <div class="w-full bg-gray-500 rounded-full">
                        <div class="w-full bg-gray-500 rounded-full">
                            <div x-ref="bar"
                                 :style=" 'width:' + percentage + '%'"
                                 class="bg-main-mode h-6 rounded-full"
                                 x-text="progress + ' B'">
                            </div>
                        </div>
                    </div>
                </div>
                <span class="text-left text-gray-500 animate-pulse" x-text="total"></span>
            </div>

            <div class="items-center px-4 py-3 w-auto text-right" title="close me for 24 hrs">
                <button type="button"
                        class="text-white bg-main-mode font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        @click="closeModal()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18" stroke="darkgray" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                        <path d="M6 6L18 18" stroke="darkgray" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>

        </div>

    </div>
</div>
