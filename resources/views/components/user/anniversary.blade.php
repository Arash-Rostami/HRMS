<div
    dir="rtl"
    x-data="persolAnniversaryCountdown()"
    x-init="init()"
    x-show="visible"
    @keydown.escape.window="visible = false"
    class="fixed bottom-4 right-4 z-50 persol-farsi-font"
    style="display: none;"
    x-cloak
>
    <div
        class="futuristic-card relative flex flex-col w-[360px] mx-auto @if(isDarkMode()) bg-gradient-to-br from-gray-800 via-slate-900 to-blue-900 @else bg-gradient-to-br from-[#1E2630] via-[#2B3340] to-[#79889E] @endif rounded-xl shadow-2xl text-white overflow-hidden">
        <canvas
            x-ref="confettiCanvas"
            class="absolute top-0 left-0 w-full h-full pointer-events-none z-10"
        ></canvas>

        <div class="p-4 relative z-20">
            <button
                @click="dismiss()"
                class="absolute top-2 left-2 text-gray-400 hover:text-white transition-colors duration-300 focus:outline-none z-30"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="text-center">
                <h3 class="text-lg font-bold text-cyan-400 futuristic-text-glow">جشن آغاز سی سالگی پرسال</h3>
                <div class="ticker-wrapper mt-1 h-6 overflow-hidden">
                    <p x-ref="ticker" class="text-sm text-gray-300 ticker-text" x-text="currentMessage"></p>
                </div>
            </div>

            <div
                class="flex justify-around items-center text-center mt-4 p-3 bg-black/30 rounded-lg border border-cyan-500/20"
                dir="ltr">
                <div class="flex flex-col w-16">
                    <span x-text="days.toLocaleString('fa-IR')"
                          class="persol-farsi-font text-3xl font-bold text-slate-100"></span>
                    <span class="text-xs text-slate-400">روز</span>
                </div>
                <div class="h-8 w-px bg-slate-700"></div>
                <div class="flex flex-col w-16">
                    <span x-text="hours.toLocaleString('fa-IR')"
                          class="persol-farsi-font text-3xl font-bold text-slate-100"></span>
                    <span class="text-xs text-slate-400">ساعت</span>
                </div>
                <div class="h-8 w-px bg-slate-700"></div>
                <div class="flex flex-col w-16">
                    <span x-text="minutes.toLocaleString('fa-IR')"
                          class="persol-farsi-font text-3xl font-bold text-slate-100"></span>
                    <span class="text-xs text-slate-400">دقیقه</span>
                </div>
                <div class="h-8 w-px bg-slate-700"></div>
                <div class="flex flex-col w-16">
                    <span x-text="seconds.toLocaleString('fa-IR')"
                          class="persol-farsi-font text-3xl font-bold text-slate-100"></span>
                    <span class="text-xs text-slate-400">ثانیه</span>
                </div>
            </div>
        </div>

        <div class="h-1.5 bg-gradient-to-r from-cyan-500 to-fuchsia-600 animate-gradient-x"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

<style>
    @keyframes scroll-out {
        0% {
            transform: translateX(0%);
            opacity: 1;
        }
        90% {
            opacity: 1;
        }
        100% {
            transform: translateX(-100%);
            opacity: 0;
        }
    }

    @keyframes fade-in {
        0% {
            transform: translateX(100%);
            opacity: 0;
        }
        100% {
            transform: translateX(0%);
            opacity: 1;
        }
    }

    .ticker-text {
        white-space: nowrap;
        display: inline-block;
    }

    .futuristic-text-glow {
        text-shadow: 0 0 10px theme(colors.cyan .500), 0 0 20px theme(colors.cyan .700);
    }

    .futuristic-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 0.75rem;
        padding: 1px;
        background: linear-gradient(135deg, theme(colors.cyan .500 / 0.5), theme(colors.fuchsia .600 / 0.5));
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
    }

    @keyframes gradient-x {
        0%, 100% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
    }

    .animate-gradient-x {
        background-size: 200% 200%;
        animation: gradient-x 5s ease infinite;
    }
</style>

<script>
    function persolAnniversaryCountdown() {
        return {
            visible: false,
            targetDate: new Date('2025-07-10T00:00:00').getTime(),
            days: 0,
            hours: 0,
            minutes: 0,
            seconds: 0,
            hasFired: false,
            tickerState: "idle",
            messages: ["سی سال نوآوری و پیشرفت در کنار شما", "به سوی آینده‌ای درخشان‌تر با هم", "از همراهی شما در این سه دهه سپاسگزاریم", "پرسال، سی سال افتخار و تعالی", "جشنی برای گذشته، حال و آینده روشن", "سی سالگی، فصل تازه‌ای از زندگی و امید", "با شما سه دهه قدرت ساختیم، برای دهه‌های بعدی هم آماده‌ایم", "پرسال، همراهتان در هر گام مسیر موفقیت", "با هم ۳۰ سال بزرگ شدیم؛ چشم به آینده داریم", "قدردان اعتماد شما در این سه دهه ارزشمندیم", "تجربه، تخصص و تعهد؛ پرسال بعد از سی سال همچنان پیشروست", "از دیروزها یاد می‌گیریم و امروز را جشن می‌گیریم", "با تعامل شما، این سه دهه پر از دستاورد شد", "هر قدم ما بنای اعتماد شماست", "سی سال تلاش و خدمت، با عشق و همدلی", "پرسال؛ نماد پایداری و رشد", "سی سالگی؛ فرصتی برای جشن و نوآوری دوباره", "در کنار شما، افقی برای فردای بهتر نقاشی می‌کنیم", "سیسال تجربه، سیسال همراهی، سیسال افتخar", "پرسال؛ سی‌سال تعهد به مشتریان عزیز", "حمایت شما، قوت قلب ماست در هر مرحله", "با هم به اوج رسیدیم – جشن سی‌سالگی پرسال مبارک!", "یک عمر نوآوری و آینده‌ای روشن‌تر در پیش داریم", "به امید روزهایی پرامیدتر؛ سی‌سال دیگر با هم", "پرسال؛ داستان سی‌ساله‌ای از پیشرفت و همراهی", "از شما سپاسگزاریم؛ همراهان همیشگی پرسال", "پرسال؛ سه دهه تلاش، دانش و نوآوری", "سی‌سال گذشت؛ و ما همچنان شوق آغاز داریم", "هر روز در کنار شما، سرمایه‌ای برای آینده‌ست", "مسیر سی ساله ما، مسیر شماست؛ پرسال مال شماست"],
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
                el.style.animation = "scroll-out 3s forwards";
                setTimeout(() => {
                    this.advanceMessage();
                    el.style.animation = "fade-in 1s forwards";
                    setTimeout(() => {
                        el.style.animation = "";
                        this.tickerState = "idle";
                    }, 1000);
                }, 3000);
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
                    particleCount: 150,
                    spread: 90,
                    origin: {y: 0.6},
                    colors: ['#22d3ee', '#a855f7', '#ec4899', '#f8fafc']
                });
            }
        }
    }
</script>
