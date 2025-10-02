@props(['id' => 'jazz-radio'])
@section('css')
    <style>
        @keyframes eq {
            0%, 100% {
                transform: scaleY(.3)
            }
            50% {
                transform: scaleY(1)
            }
        }
    </style>
@endsection
<div x-data="jazzRadio('{{ $id }}')" x-init="init()" class="persol-farsi-font" dir="rtl">
    <!-- Nudge Modal -->
    <div x-show="uiState === 'nudge'" x-transition
         class="fixed bottom-4 right-4 {{ isDarkMode() ? 'bg-gray-900 border border-gray-700' : 'bg-gradient-to-br from-[whitesmoke] via-[ghostwhite] to-[#bdc3c7] border border-gray-200' }} backdrop-blur-xl rounded-2xl shadow-2xl p-4 sm:p-6 w-[90%] max-w-sm sm:w-96 z-[999]">
    <span
        class="absolute top-0 -left-4 -rotate-12 bg-green-500 text-white text-xs px-1 py-1 rounded-full animate-pulse">
        جدید
    </span>
        <div class="flex items-start gap-3 sm:gap-4">
            <div
                class="flex-shrink-0 p-2 sm:p-3 ml-2 {{ isDarkMode() ? 'bg-indigo-600/20' : 'bg-indigo-50' }} rounded-xl">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 {{ isDarkMode() ? 'text-indigo-400' : 'text-indigo-600' }}"
                     fill="none"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z"/>
                </svg>
            </div>
            <div class="flex-1 mr-2 sm:mr-4">
                <h3 class="text-base sm:text-lg font-semibold {{ isDarkMode() ? 'text-white' : 'text-gray-900' }} mb-2">
                    رادیو محیط کار</h3>
                <p class="text-xs sm:text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-600' }} mb-3 sm:mb-4 leading-relaxed">
                    دوست دارید هنگام انجام کار خود به رادیو هم گوش دهید؟</p>
                <div class="flex gap-2 sm:gap-3">
                    <button @click="acceptNudge"
                            class="flex-1 px-3 sm:px-4 py-2 sm:py-2.5 bg-indigo-500 text-white text-xs sm:text-sm font-medium rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105">
                        بله، حتماً
                    </button>
                    <button @click="showDeclineOptions = true"
                            class="flex-1 px-3 sm:px-4 py-2 sm:py-2.5 {{ isDarkMode() ? 'bg-gray-700 text-gray-200 hover:bg-gray-600' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} text-xs sm:text-sm font-medium rounded-lg transition-all duration-200">
                        نه، ممنون
                    </button>
                </div>
                <div x-show="showDeclineOptions" x-transition
                     class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t {{ isDarkMode() ? 'border-gray-700' : 'border-gray-200' }}">
                    <p class="text-xs {{ isDarkMode() ? 'text-gray-400' : 'text-gray-500' }} mb-2 sm:mb-3">این پیام دیگر
                        نمایش داده نشود برای:</p>
                    <div class="flex justify-between">
                        <button @click="dismissFor('day')"
                                class="text-xs {{ isDarkMode() ? 'text-indigo-400 hover:text-indigo-300' : 'text-indigo-600 hover:text-indigo-700' }} hover:underline transition-colors">
                            یک روز
                        </button>
                        <button @click="dismissFor('week')"
                                class="text-xs {{ isDarkMode() ? 'text-indigo-400 hover:text-indigo-300' : 'text-indigo-600 hover:text-indigo-700' }} hover:underline transition-colors">
                            یک هفته
                        </button>
                        <button @click="dismissFor('forever')"
                                class="text-xs {{ isDarkMode() ? 'text-indigo-400 hover:text-indigo-300' : 'text-indigo-600 hover:text-indigo-700' }} hover:underline transition-colors">
                            همیشه
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-show="uiState === 'minimized'" x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-x-full"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-x-0"
         x-transition:leave-end="opacity-0 transform translate-x-full">
        <div x-data="{ tooltipVisible: false }"
             @click="restore"
             @mouseenter="tooltipVisible = true"
             @mouseleave="tooltipVisible = false"
             class="fixed top-3/4 right-0 w-8 h-8 md:w-10 md:h-10 bg-main-mode text-white flex group
                    justify-center items-center rounded-l hover:w-40 cursor-pointer transition-all duration-300 z-[999]">
            <div x-show="playing" class="inline-flex items-end h-4 gap-0.5">
                <template x-for="d in [0,120,240,360,480]" :key="d">
                        <span :style="`animation-delay:${d}ms`"
                              class="w-0.5 h-3 bg-current rounded origin-bottom animate-[eq_1s_ease-in-out_infinite]"></span>
                </template>
            </div>
            <i x-show="!playing" class="fa fa-music transition duration-300 ease-in-out transform text-xl"></i>
            <span
                class="hidden transition duration-300 ease-in-out mr-2 delay-500 transform font-medium uppercase tracking-wider group-hover:inline-block"
                x-text="status"></span>
            <div
                x-show="tooltipVisible"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 -translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 -translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="absolute -top-12 right-1/2 translate-x-1/2 min-w-max bg-gray-800 text-white text-sm rounded-md px-3 py-1.5 shadow-lg"
                x-cloak> بازگشت به کنترلر رادیو
            </div>
        </div>
    </div>

    <!-- Main Player -->
    <div x-show="uiState === 'player'" x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 transform translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 transform translate-y-4 sm:translate-y-0 sm:scale-95"
         class="fixed bottom-6 right-6 {{ isDarkMode() ? 'bg-gray-700 border border-gray-500' : 'bg-white/95 border border-gray-200' }} backdrop-blur-xl rounded-3xl shadow-2xl w-96 md:w-[26rem] z-50 overflow-hidden"
         @click.outside="minimize">

        <!-- Header -->
        <div class="p-6 pb-4 border-b {{ isDarkMode() ? 'border-gray-600' : 'border-gray-200' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-2 bg-main-mode rounded-xl ml-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/>
                        </svg>
                    </div>

                    <!-- title + status + EQ grouped -->
                    <div class="flex items-center gap-3">
                        <div>
                            <h3 class="font-bold text-lg {{ isDarkMode() ? 'text-white' : 'text-gray-900' }}"
                                x-text="`رادیو ${currentGenreLabel}`"></h3>

                            <div class="flex items-center gap-2 mt-1">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold"
                  :class="statusClass" x-text="status"></span>

                                <!-- EQ: inherits color from text-main-mode/text-white -->
                                <div x-show="playing"
                                     role="status"
                                     aria-label="در حال پخش"
                                     class="{{ isDarkMode() ? 'text-white/90' : 'text-main-mode' }} inline-flex items-end gap-1 p-0.5">
                                    <template x-for="(d,i) in [0,90,180,270,360]" :key="i">
                <span
                    :style="`animation:eq ${800 + i*80}ms cubic-bezier(.2,.9,.2,.9) infinite; animation-delay:${d}ms`"
                    class="w-1.5 md:w-2 rounded-full origin-bottom bg-current h-3 md:h-4"></span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- action buttons -->
                <div class="flex items-center space-x-2">
                    <button @click="minimize"
                            class="p-2 {{ isDarkMode() ? 'text-gray-400 hover:text-white hover:bg-gray-800' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }} rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </button>

                    <button @click="dismissFor('day')"
                            class="p-2 {{ isDarkMode() ? 'text-gray-400 hover:text-white hover:bg-gray-800' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }} rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Loading State -->
            <div x-show="isLoading" class="flex flex-col items-center justify-center py-12">
                <div class="relative">
                    <div
                        class="w-16 h-16 border-4 {{ isDarkMode() ? 'border-gray-700' : 'border-gray-200' }} border-t-indigo-600 rounded-full animate-spin"></div>
                </div>
                <p class="mt-4 text-sm {{ isDarkMode() ? 'text-gray-300' : 'text-gray-600' }}">در حال یافتن
                    ایستگاه‌ها...</p>
            </div>

            <!-- Main Content -->
            <div x-show="!isLoading && stations.length" class="space-y-6">
                <!-- Controls -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label
                            class="flex items-center space-x-2 text-sm font-medium {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700' }}">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/>
                            </svg>
                            <span>ژانر</span>
                        </label>
                        <select dir="rtl" x-model="currentGenre"
                                class="w-full pl-10 pr-3 py-2.5
               {{ isDarkMode() ? 'bg-gray-800 border-gray-600 text-white' : 'bg-gray-50 border-gray-300 text-gray-900' }}
               border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
               transition-all duration-200 appearance-none bg-no-repeat  bg-[position:left_0.75rem_center]
               bg-[url('data:image/svg+xml,%3csvg%20xmlns%3d%22http%3a//www.w3.org/2000/svg%22%20viewBox%3d%220%200%2020%2020%22%20fill%3d%22%236b7280%22%3e%3cpath%20fill-rule%3d%22evenodd%22%20d%3d%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3d%22evenodd%22%20/%3e%3c/svg%3e')] ">
                            <template x-for="genre in genres" :key="genre.value">
                                <option :value="genre.value" x-text="genre.label"
                                        class="{{ isDarkMode() ? 'bg-gray-800 text-white' : 'bg-gradient-to-br from-[whitesmoke] via-[ghostwhite] to-[#bdc3c7] text-gray-900' }}"></option>
                            </template>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label
                            class="flex items-center space-x-2 text-sm font-medium {{ isDarkMode() ? 'text-gray-300' : 'text-gray-700' }}">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z"/>
                            </svg>
                            <span>ایستگاه</span>
                        </label>
                        <select x-model="currentStationUrl"
                                class="w-full px-3 py-2.5 {{ isDarkMode() ? 'bg-gray-800 border-gray-600 text-white' : 'bg-gray-50 border-gray-300 text-gray-900' }} border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                dir="ltr">
                            <template x-for="station in stations" :key="station.stationuuid">
                                <option :value="station.url_resolved" x-text="station.name"
                                        class="{{ isDarkMode() ? 'bg-gray-800 text-white' : 'bg-gradient-to-br from-[whitesmoke] via-[ghostwhite] to-[#bdc3c7] text-gray-900' }}"></option>
                            </template>
                        </select>
                    </div>
                </div>

                <!-- Player Controls -->
                <div class="flex flex-col items-center space-y-4 text-center">
                    <div class="w-full p-4 {{ isDarkMode() ? 'bg-gray-800/50' : 'bg-gray-50' }} rounded-2xl">
                        <p class="text-sm font-medium {{ isDarkMode() ? 'text-white' : 'text-gray-900' }} truncate"
                           x-text="currentStationName"></p>
                    </div>

                    <button @click="togglePlay"
                            class="group relative w-20 h-20 flex items-center justify-center bg-main-mode text-white rounded-full hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/30 transition-all duration-300 transform hover:scale-110 active:scale-95 shadow-2xl">
                        <div class="absolute inset-0 bg-main-mode to-transparent rounded-full"></div>
                        <svg x-show="!playing"
                             class="w-10 h-10 relative z-10 transform group-hover:scale-110 transition-transform duration-200"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        <svg x-show="playing"
                             class="w-10 h-10 relative z-10 transform group-hover:scale-110 transition-transform duration-200"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Error State -->
            <div x-show="!isLoading && !stations.length" class="text-center py-12">
                <div
                    class="w-16 h-16 mx-auto mb-4 p-3 {{ isDarkMode() ? 'bg-red-900/20 text-red-400' : 'bg-red-50 text-red-500' }} rounded-full">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold {{ isDarkMode() ? 'text-white' : 'text-gray-900' }} mb-2">ایستگاه‌ها
                    یافت نشد</h3>
                <p class="text-sm {{ isDarkMode() ? 'text-gray-400' : 'text-gray-500' }} mb-6">لطفا بعدا دوباره تلاش
                    کنید.</p>
                <button @click="fetchStations(true)"
                        class="px-6 py-3 bg-main-mode text-white text-sm font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105">
                    تلاش مجدد
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function jazzRadio(id) {
            const DURATIONS = {day: 86400000, week: 604800000};
            const API_SERVERS = [
                'https://de2.api.radio-browser.info/json',
                'https://de1.api.radio-browser.info/json',
                'https://nl1.api.radio-browser.info/json',
                'https://fr1.api.radio-browser.info/json'
            ];
            const FALLBACK_STATIONS = {
                jazz: [{ name: 'Jazz24', url_resolved: 'https://jazz24.org/streams/high.mp3', stationuuid: 'fallback-jazz-1' }],
                classical: [{ name: 'WCRB Classical', url_resolved: 'https://streams.wgbh.org/wcrb.mp3', stationuuid: 'fallback-classical-1' }],
                pop: [{ name: 'Capital UK', url_resolved: 'https://media-ssl.musicradio.com/CapitalUK', stationuuid: 'fallback-pop-1' }],
                electronic: [{ name: 'DI.FM - House', url_resolved: 'https://listen.di.fm/public/3/house.mp3', stationuuid: 'fallback-electronic-1' }],
                lofi: [{ name: 'Lofi Girl', url_resolved: 'https://stream.lofi.co/lofi', stationuuid: 'fallback-lofi-1' }]
            };
            const STATUS_CLASSES = {
                'در حال پخش': 'bg-green-100 text-green-800 {{ isDarkMode() ? "!bg-green-900/30 !text-green-400" : "" }}',
                'در حال بافر...': 'bg-yellow-100 text-yellow-800 {{ isDarkMode() ? "!bg-yellow-900/30 !text-yellow-400" : "" }}',
                'در حال تنظیم...': 'bg-blue-100 text-blue-800 {{ isDarkMode() ? "!bg-blue-900/30 !text-blue-400" : "" }}',
                'متوقف': 'bg-gray-100 text-gray-800 {{ isDarkMode() ? "!bg-gray-700 !text-gray-300" : "" }}',
                'آماده': 'bg-gray-100 text-gray-800 {{ isDarkMode() ? "!bg-gray-700 !text-gray-300" : "" }}',
                'خطا': 'bg-red-100 text-red-800 {{ isDarkMode() ? "!bg-red-900/30 !text-red-400" : "" }}',
                'آفلاین': 'bg-red-100 text-red-800 {{ isDarkMode() ? "!bg-red-900/30 !text-red-400" : "" }}'
            };

            return {
                uiState: 'booting',
                showDeclineOptions: false,
                playing: false,
                isLoading: false,
                status: 'در حال آماده‌سازی',
                audio: null,
                stations: [],
                currentStationUrl: '',
                currentGenre: 'jazz',
                genres: [
                    {value: 'jazz', label: 'جاز'},
                    {value: 'classical', label: 'کلاسیک'},
                    {value: 'pop', label: 'پاپ'},
                    {value: 'electronic', label: 'الکترونیک'},
                    {value: 'lofi', label: 'لو-فای'}
                ],
                currentServerIndex: 0,

                _getStorage: (key, defaultValue = {}) => JSON.parse(localStorage.getItem(`${id}_${key}`) || JSON.stringify(defaultValue)),
                _setStorage: (key, value) => localStorage.setItem(`${id}_${key}`, JSON.stringify(value)),

                get statusClass() {
                    return STATUS_CLASSES[this.status] || STATUS_CLASSES['آماده'];
                },
                get currentStationName() {
                    if (!this.currentStationUrl) return 'یک ایستگاه انتخاب کنید';
                    const station = this.stations.find(s => s.url_resolved === this.currentStationUrl);
                    return station?.name || 'ایستگاه ناشناس';
                },
                get currentGenreLabel() {
                    return this.genres.find(g => g.value === this.currentGenre)?.label || 'جاز';
                },
                async init() {
                    const openHandler = () => {
                        const pref = this._getStorage('preference');
                        if (!pref.accepted) {
                            this.acceptNudge();
                            return;
                        }
                        this.uiState = 'player';
                        this.saveState();
                        this.fetchStations().catch(()=>{});
                    };
                    window.addEventListener('openJazzRadio', openHandler);

                    const pref = this._getStorage('preference');
                    if (pref.dismiss === 'forever' || (pref.dismissUntil && Date.now() < pref.dismissUntil)) {
                        this.uiState = 'hidden';
                        return;
                    }
                    if (pref.accepted) {
                        const state = this._getStorage('state', {minimized: true});
                        this.uiState = state.minimized ? 'minimized' : 'player';
                        this.currentGenre = state.genre || 'jazz';
                        await this.fetchStations();
                        if (state.stationUrl) this.currentStationUrl = state.stationUrl;
                    } else {
                        setTimeout(() => this.uiState = 'nudge', 1500);
                    }

                    this.$watch('currentStationUrl', newUrl => this.handleStationChange(newUrl));
                    this.$watch('currentGenre', (newGenre, oldGenre) => newGenre !== oldGenre && this.fetchStations(true));

                    const unloadHandler = () => {
                        this.saveState();
                        window.removeEventListener('openJazzRadio', openHandler);
                        window.removeEventListener('beforeunload', unloadHandler);
                    };
                    window.addEventListener('beforeunload', unloadHandler);
                },

                handleStationChange(newUrl) {
                    if (!this.audio || !newUrl || this.audio.src === newUrl) return;
                    const wasPlaying = this.playing;
                    this.status = 'در حال تنظیم...';
                    if (wasPlaying) this.audio.pause();
                    this.audio.src = newUrl;
                    this.audio.load();
                    if (wasPlaying) this.audio.play().catch(console.error);
                    this.saveState();
                },

                acceptNudge() {
                    this.uiState = 'player';
                    this._setStorage('preference', {accepted: true});
                    this.fetchStations();
                },

                dismissFor(period) {
                    if (this.playing) this.audio.pause();
                    this.uiState = 'hidden';
                    const pref = period === 'forever' ? {dismiss: 'forever'} : {dismissUntil: Date.now() + DURATIONS[period]};
                    this._setStorage('preference', pref);
                    localStorage.removeItem(`${id}_state`);
                },

                async fetchStations(forceRefetch = false) {
                    if (this.stations.length > 0 && !forceRefetch) return;
                    if (forceRefetch) {
                        this.stations = [];
                        this.currentStationUrl = '';
                        if (this.playing) this.audio.pause();
                    }
                    this.isLoading = true;
                    this.status = 'در حال تنظیم...';

                    let fetchedStations = [];
                    for (let i = 0; i < API_SERVERS.length; i++) {
                        const server = API_SERVERS[this.currentServerIndex];
                        try {
                            const endpoints = [`/stations/bytag/${this.currentGenre}`, `/stations/search?name=${this.currentGenre}&limit=100`];
                            for (const endpoint of endpoints) {
                                const res = await fetch(server + endpoint, { signal: AbortSignal.timeout(5000) });
                                if (!res.ok) continue;
                                const data = await res.json();
                                const filtered = data.filter(s => s.url_resolved && s.codec.toLowerCase() === 'mp3' && s.lastcheckok === 1 && s.bitrate > 64);
                                if (filtered.length > 0) {
                                    fetchedStations = filtered;
                                    break;
                                }
                            }
                            if (fetchedStations.length > 0) break;
                        } catch (e) {
                            console.error(`Failed to fetch from ${server}:`, e);
                            this.currentServerIndex = (this.currentServerIndex + 1) % API_SERVERS.length;
                        }
                    }

                    if (fetchedStations.length > 0) {
                        const uniqueStations = Array.from(new Map(fetchedStations.map(s => [s.name.trim().toLowerCase(), s])).values());
                        this.stations = uniqueStations.map(s => ({
                            ...s,
                            name: s.name.length > 40 ? s.name.substring(0, 40) + '...' : s.name
                        }));
                    } else {
                        console.warn("All API servers failed, loading fallback stations.");
                        this.stations = FALLBACK_STATIONS[this.currentGenre] || [];
                    }

                    if (this.stations.length) {
                        if (!this.currentStationUrl || forceRefetch) {
                            this.$nextTick(() => this.currentStationUrl = this.stations[0].url_resolved);
                        }
                        this.setupAudio();
                        this.status = 'آماده';
                    } else {
                        this.status = 'آفلاین';
                    }
                    this.isLoading = false;
                },

                setupAudio() {
                    if (this.audio) return;
                    this.audio = new Audio(this.currentStationUrl);
                    this.audio.preload = 'none';
                    Object.entries({
                        playing: () => this._updatePlayState(true, 'در حال پخش'),
                        pause: () => this._updatePlayState(false, 'متوقف'),
                        ended: () => this._updatePlayState(false, 'متوقف'),
                        waiting: () => this.status = 'در حال بافر...',
                        error: () => this._updatePlayState(false, 'خطا')
                    }).forEach(([event, handler]) => this.audio.addEventListener(event, handler));
                },

                _updatePlayState(isPlaying, status) {
                    this.playing = isPlaying;
                    this.status = status;
                    this.saveState();
                },

                togglePlay() {
                    if (!this.audio || !this.currentStationUrl) return;
                    if (this.playing) {
                        this.audio.pause();
                    } else {
                        if (this.audio.src !== this.currentStationUrl) this.audio.src = this.currentStationUrl;
                        this.audio.play().catch(e => {
                            this.status = 'خطا';
                            console.error('Playback failed:', e);
                        });
                    }
                },

                minimize() {
                    this.uiState = 'minimized';
                    this.saveState();
                },

                restore() {
                    this.uiState = 'player';
                    this.saveState();
                },

                saveState() {
                    if (!this._getStorage('preference').accepted) return;
                    this._setStorage('state', {
                        stationUrl: this.currentStationUrl,
                        genre: this.currentGenre,
                        minimized: this.uiState === 'minimized',
                    });
                }
            }
        }
    </script>
@endpush
