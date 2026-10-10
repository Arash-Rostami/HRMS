<div
    dir="rtl"
    x-data="persolAnniversaryCountdown()"
    x-init="init()"
    x-show="visible"
    @keydown.escape.window="visible = false"
    class="fixed top-4 left-4 right-4 sm:right-auto z-50 persol-farsi-font"
    style="display: none;"
    x-cloak
>
    <div @class([
    'futuristic-card relative flex flex-col w-full sm:w-[420px] rounded-2xl shadow-[0_20px_50px_rgba(8,112,184,0.15)] overflow-hidden transition-all duration-300',
    'text-white bg-gradient-to-br from-[#1E2630] via-[#151B23] to-[#0D1117]' => isDarkMode(),
    'text-slate-900 bg-gradient-to-br from-slate-600 via-slate-50 to-slate-200' => ! isDarkMode(),
])>
        <canvas
            x-ref="confettiCanvas"
            class="absolute inset-0 w-full h-full pointer-events-none z-10"
        ></canvas>

        <div class="p-5 sm:p-6 relative z-20">
            <button
                @click="dismiss()"
                class="absolute top-3 left-3 p-1.5 rounded-full text-slate-400 hover:text-white hover:bg-white/10 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-cyan-500/50 z-30"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="text-center mt-2">
                <h3 @class([
                    'text-lg sm:text-2xl font-bold drop-shadow-[0_0_10px_rgba(217,70,239,0.5)] text-transparent bg-clip-text bg-gradient-to-r futuristic-text-glow tracking-wide',
                    'from-cyan-400 to-fuchsia-400' => isDarkMode(),
                    'from-cyan-800 to-fuchsia-600' => !isDarkMode(),
                ])>جشن آغاز سی سالگی پرسال</h3>
                <div class="ticker-wrapper mt-3 h-7 overflow-hidden flex items-center justify-center">
                    <p x-ref="ticker" class="text-xs sm:text-sm font-medium ticker-text" x-text="currentMessage"></p>
                </div>
            </div>

            <div
                class="flex justify-between items-center text-center mt-6 p-4 sm:p-5 bg-[#0B0F15]/80 rounded-xl border border-white/5 shadow-inner"
                dir="ltr">
                <div class="flex flex-col w-14 sm:w-16 items-center justify-center">
                    <span x-text="days.toLocaleString('fa-IR')"
                          class="persol-farsi-font text-3xl sm:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-b from-white to-slate-400 drop-shadow-md"></span>
                    <span class="text-[10px] sm:text-xs font-semibold text-cyan-400/90 uppercase tracking-wider mt-1.5">روز</span>
                </div>
                <div class="h-12 w-px bg-gradient-to-b from-transparent via-slate-600 to-transparent"></div>
                <div class="flex flex-col w-14 sm:w-16 items-center justify-center">
                    <span x-text="hours.toLocaleString('fa-IR')"
                          class="persol-farsi-font text-3xl sm:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-b from-white to-slate-400 drop-shadow-md"></span>
                    <span class="text-[10px] sm:text-xs font-semibold text-cyan-400/90 uppercase tracking-wider mt-1.5">ساعت</span>
                </div>
                <div class="h-12 w-px bg-gradient-to-b from-transparent via-slate-600 to-transparent"></div>
                <div class="flex flex-col w-14 sm:w-16 items-center justify-center">
                    <span x-text="minutes.toLocaleString('fa-IR')"
                          class="persol-farsi-font text-3xl sm:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-b from-white to-slate-400 drop-shadow-md"></span>
                    <span class="text-[10px] sm:text-xs font-semibold text-cyan-400/90 uppercase tracking-wider mt-1.5">دقیقه</span>
                </div>
                <div class="h-12 w-px bg-gradient-to-b from-transparent via-slate-600 to-transparent"></div>
                <div class="flex flex-col w-14 sm:w-16 items-center justify-center">
                    <span x-text="seconds.toLocaleString('fa-IR')"
                          class="persol-farsi-font text-3xl sm:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-b from-white to-slate-400 drop-shadow-md"></span>
                    <span class="text-[10px] sm:text-xs font-semibold text-cyan-400/90 uppercase tracking-wider mt-1.5">ثانیه</span>
                </div>
            </div>
        </div>

        <div class="h-1.5 bg-gradient-to-r from-cyan-500 via-fuchsia-500 to-cyan-500 animate-gradient-x"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

<style>
    @keyframes scroll-out {
        0% { transform: translateY(0%); opacity: 1; }
        100% { transform: translateY(-100%); opacity: 0; }
    }

    @keyframes fade-in {
        0% { transform: translateY(100%); opacity: 0; }
        100% { transform: translateY(0%); opacity: 1; }
    }

    .ticker-text { white-space: nowrap; display: inline-block; }

    .futuristic-text-glow {
        filter: drop-shadow(0 0 8px rgba(34, 211, 238, 0.4));
    }

    .futuristic-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 1rem;
        padding: 1px;
        background: linear-gradient(135deg, rgba(34, 211, 238, 0.4), rgba(192, 38, 211, 0.4));
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
    }

    @keyframes gradient-x {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .animate-gradient-x {
        background-size: 200% 200%;
        animation: gradient-x 4s ease infinite;
    }
</style>

<script>
    function persolAnniversaryCountdown() {
        return {
            visible: false,
            targetDate: new Date('2026-07-10T19:00:00+03:30').getTime(),
            days: 0,
            hours: 0,
            minutes: 0,
            seconds: 0,
            hasFired: false,
            tickerState: "idle",
            messages: ["سی سال نوآوری و پیشرفت در کنار شما", "به سوی آینده‌ای درخشان‌تر با هم", "از همراهی شما در این سه دهه سپاسگزاریم", "پرسال، سی سال افتخار و تعالی", "جشنی برای گذشته، حال و آینده روشن", "سی سالگی، فصل تازه‌ای از زندگی و امید", "با شما سه دهه قدرت ساختیم، برای دهه‌های بعدی هم آماده‌ایم", "پرسال، همراهتان در هر گام مسیر موفقیت", "با هم ۳۰ سال بزرگ شدیم؛ چشم به آینده داریم", "قدردان اعتماد شما در این سه دهه ارزشمندیم", "تجربه، تخصص و تعهد؛ پرسال بعد از سی سال همچنان پیشروست", "از دیروزها یاد می‌گیریم و امروز را جشن می‌گیریم", "با تعامل شما، این سه دهه پر از دستاورد شد", "هر قدم ما بنای اعتماد شماست", "سی سال تلاش و خدمت، با عشق و همدلی", "پرسال؛ نماد پایداری و رشد", "سی سالگی؛ فرصتی برای جشن و نوآوری دوباره", "در کنار شما، افقی برای فردای بهتر نقاشی می‌کنیم", "سیسال تجربه، سیسال همراهی، سیسال افتخار", "پرسال؛ سی‌سال تعهد به مشتریان عزیز", "حمایت شما، قوت قلب ماست در هر مرحله", "با هم به اوج رسیدیم – جشن سی‌سالگی پرسال مبارک!", "یک عمر نوآوری و آینده‌ای روشن‌تر در پیش داریم", "به امید روزهایی پرامیدتر؛ سی‌سال دیگر با هم", "پرسال؛ داستان سی‌ساله‌ای از پیشرفت و همراهی", "از شما سپاسگزاریم؛ همراهان همیشگی پرسال", "پرسال؛ سه دهه تلاش، دانش و نوآوری", "سی‌سال گذشت؛ و ما همچنان شوق آغاز داریم", "هر روز در کنار شما، سرمایه‌ای برای آینده‌ست", "مسیر سی ساله ما، مسیر شماست؛ پرسال مال شماست"],
            currentMessage: "روزشمار جشن بزرگ ما 🎉🎈🎊",
            init() {
                const dismissedTime = localStorage.getItem('persolAnniversaryDismissed');
                if (dismissedTime && (Date.now() - dismissedTime < 24 * 60 * 60 * 1000)) {
                    this.visible = false;
                    return;
                }
                this.visible = true;
                this.$nextTick(() => {
                    setTimeout(() => {
                        this.updateCountdown();
                    }, 1000);
                    this.launchConfetti();
                    setInterval(() => this.updateCountdown(), 1000);
                    setInterval(() => this.cycleMessages(), 6000);
                });
            },
            updateCountdown() {
                const now = Date.now();
                const timeLeft = this.targetDate - now;
                if (timeLeft <= 0) {
                    this.days = this.hours = this.minutes = this.seconds = 0;
                    this.currentMessage = "جشن بزرگ ما آغاز شد!";
                    if (!this.hasFired) {
                        this.launchConfetti();
                        this.hasFired = true;
                    }
                    return;
                }
                this.days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                this.hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                this.minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                this.seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
            },
            cycleMessages() {
                if (this.tickerState !== "idle") return;
                this.tickerState = "scrolling";
                const el = this.$refs.ticker;
                el.style.animation = "scroll-out 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards";
                setTimeout(() => {
                    this.advanceMessage();
                    el.style.animation = "fade-in 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards";
                    setTimeout(() => {
                        el.style.animation = "";
                        this.tickerState = "idle";
                    }, 600);
                }, 600);
            },
            advanceMessage() {
                const idx = this.messages.indexOf(this.currentMessage);
                this.currentMessage = this.messages[(idx + 1) % this.messages.length];
            },
            dismiss() {
                localStorage.setItem('persolAnniversaryDismissed', Date.now());
                this.visible = false;
            },
            launchConfetti() {
                const canvas = this.$refs.confettiCanvas;
                const myConfetti = confetti.create(canvas, {resize: true, useWorker: true});
                myConfetti({
                    particleCount: 180,
                    spread: 100,
                    origin: {y: 0.6},
                    colors: ['#22d3ee', '#a855f7', '#ec4899', '#f8fafc']
                });
            }
        }
    }
</script>
