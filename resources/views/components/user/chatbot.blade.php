@push('styles')
    <style>
        @keyframes color-spectrum {
            0% { color: #60a5fa; }
            20% { color: #a78bfa; }
            40% { color: #f472b6; }
            60% { color: #fbbf24; }
            80% { color: #34d399; }
            100% { color: #60a5fa; }
        }
        .animate-spectrum { animation: color-spectrum 4s linear infinite; }
        .custom-tooltip { pointer-events: none; }
    </style>
@endpush

<div
    x-data="{
        chatOpen: false,
        maximized: false,
        tooltipVisible: false,
        tooltipText: '',
        tooltipTarget: null,
        maintenance: false
    }"
    class="fixed bottom-6 left-0 md:top-3/4 w-8 h-8 md:w-10 md:h-10 bg-main-mode text-white flex group persol-farsi-font justify-center items-center rounded hover:w-40 cursor-pointer transition-all duration-300 z-[9999]"
>
    <i class="fa fa-robot transition duration-300 ease-in-out text-xl group-hover:hidden" :class="{ 'animate-spectrum': !chatOpen }" x-show="!chatOpen" aria-hidden="true"></i>

    <i
        @mouseenter="tooltipVisible = true; tooltipText = 'باز کردن دستیار هوش مصنوعی'; tooltipTarget = 'open'"
        @mouseleave="tooltipVisible = false"
        @click="chatOpen = true"
        class="fas fa-comments hidden transition duration-300 ease-in-out delay-500 transform text-xl mx-2 group-hover:inline-block"
        x-show="!chatOpen"
        aria-hidden="true"
    ></i>

    <i
        @mouseenter="tooltipVisible = true; tooltipText = 'بستن دستیار هوش مصنوعی'; tooltipTarget = 'close'"
        @mouseleave="tooltipVisible = false"
        @click="chatOpen = false; maximized = false"
        class="fas fa-times transition duration-300 ease-in-out text-xl"
        :class="chatOpen ? 'inline-block' : 'hidden'"
        aria-hidden="true"
    ></i>

    <div
        x-show="tooltipVisible && (tooltipTarget === 'open' || tooltipTarget === 'close')"
        x-text="tooltipText"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 -translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 -translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="custom-tooltip absolute -top-12 left-28 -translate-x-1/2 min-w-max bg-gray-800 text-white text-sm rounded-md px-3 py-1.5 shadow-lg"
        x-cloak
    ></div>

    <div
        x-show="chatOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-5 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-5 scale-95"
        :class="maximized ? 'fixed inset-4 w-auto h-auto' : 'fixed md:absolute bottom-0 md:bottom-12 left-0 right-0 md:right-auto w-full md:w-[420px] h-[85vh] md:h-[640px] max-h-[85vh] md:max-h-[80vh]'"
        class="bg-white rounded-t-2xl md:rounded-2xl shadow-2xl overflow-hidden transition-all duration-300"
        @click.away="!maximized && (chatOpen = false)"
        x-cloak
    >
        <div class="flex items-center justify-between bg-[#2563eb] text-white px-4 py-3 md:py-2">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full transition-colors duration-300" :class="maintenance ? 'bg-red-500' : (maximized ? 'bg-green-400' : 'bg-amber-500')"></div>
                <span class="text-xs" x-text="maintenance ? 'در حال تعمیرات' : (maximized ? 'سایز کامل' : 'سایز عادی')"></span>
            </div>

            <div class="flex items-center gap-2">
                <button
                    @click="maximized = !maximized"
                    @mouseenter="tooltipVisible = true; tooltipText = maximized ? 'بازگشت به اندازه عادی' : 'بزرگنمایی'; tooltipTarget = 'maximize'"
                    @mouseleave="tooltipVisible = false"
                    class="hover:bg-white/10 rounded p-1.5 transition"
                    :aria-label="maximized ? 'بستن بزرگنمایی' : 'بزرگنمایی'"
                    x-show="!maintenance"
                >
                    <i :class="maximized ? 'fas fa-compress' : 'fas fa-expand'" class="text-xs"></i>
                </button>

                <button
                    @mouseenter="tooltipVisible = true; tooltipText = 'بستن دستیار'; tooltipTarget = 'close-header'"
                    @mouseleave="tooltipVisible = false"
                    @click="chatOpen = false; maximized = false"
                    class="hover:bg-white/10 rounded p-1.5 transition"
                    aria-label="بستن"
                >
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
        </div>

        <div
            x-show="tooltipVisible && (tooltipTarget === 'maximize' || tooltipTarget === 'close-header')"
            x-text="tooltipText"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 -translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 -translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="custom-tooltip absolute top-12 left-1/2 -translate-x-1/2 min-w-max bg-gray-800 text-white text-xs rounded-md px-2.5 py-1.5 shadow-lg z-10"
            x-cloak
        ></div>

        <template x-if="chatOpen && !maintenance">
            <iframe
                src="https://arash-ai.cldv.dev?user={{ auth()->id() }}"
                class="w-full h-[calc(100%-52px)] md:h-[calc(100%-44px)] border-0"
                allow="microphone; camera; clipboard-write; clipboard-read; fullscreen"
                loading="lazy"
            ></iframe>
        </template>

        <div x-show="maintenance" class="flex flex-col items-center justify-center h-[calc(100%-52px)] md:h-[calc(100%-44px)] p-6 text-center">
            <i class="fas fa-wrench text-6xl text-amber-500 mb-4 animate-pulse"></i>
            <h3 class="text-2xl font-bold text-gray-800 mb-3">در حال به‌روزرسانی</h3>
            <p class="text-gray-600 text-base mb-2">دستیار هوش مصنوعی به زودی بازمی‌گردد</p>
            <p class="text-gray-500 text-sm">لطفاً دقایقی صبر کنید</p>
        </div>
    </div>
</div>
