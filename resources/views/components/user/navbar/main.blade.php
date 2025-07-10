<nav>
    <div
        @class([
           'text-gray-900 mb-12 opacity-100 bg-transparent persol-farsi-font rtl-direction',
           'text-gray-300 ' => isDarkMode(),
         ])
        dir="rtl"
        x-data="{
            open: false,
            play: false,
            version:false,
            presence:false,
            toggleFullScreen() {
             (!document.fullscreenElement)
                 ? document.documentElement.requestFullscreen() : document.exitFullscreen();
              },
             handleNavVisibility() {
                    const navElement = document.getElementById('mainNav');
                    if (this.version || this.presence) {
                        navElement.style.display = 'none';
                    } else {
                        navElement.style.display = 'flex';
                    }
                }
            }"
        x-init="
            $watch('version', () => handleNavVisibility());
            $watch('presence', () => handleNavVisibility());
    ">
        <!-- Primary Navigation Menu -->
        <div class="mx-2 sm:mx-6 md:mx-10 lg:mx-16 xl:mx-20 fade-in-fwd" x-cloak>
            <div class="flex  items-center h-16">
                <!-- Logo -->
                <div class="flex items-center m-auto">
                    <a href="{{ route('landing.page') }}"
                       class="inline-block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-lg transition-all duration-200 hover:scale-105">
                        <x-application-logo class="inline-block h-10 w-auto fill-current right-3"/>
                    </a>
                </div>

                <!-- Center Navigation -->
                <div class="flex w-full items-center justify-evenly">
                    <!-- Fullscreen Toggle -->
                    <div @class([
                                'hidden sm:flex mx-auto rounded-lg min-w-0 bold',
                                'bg-gray-800/50 text-gray-400' => isDarkMode(),
                                'bg-gray-200/30 text-gray-600' => !isDarkMode(),
                            ])>
                            <span
                                class="border-2 border-main rounded-md px-3 py-1.5 cursor-pointer transition-all duration-200 hover:bg-main hover:text-blue-500 hover:shadow-lg transform hover:scale-105 active:scale-95"
                                @click="toggleFullScreen()"
                                title="تغییر حالت نمایش در صفحه">⤢
                            </span>
                    </div>

                    <!-- Stats Section -->
                    <div @class([
                                'hidden lg:flex items-center text-center justify-center mx-auto px-5 py-2.5 rounded-lg min-w-0',
                                'bg-gray-800/50' => isDarkMode(),
                                'bg-gray-200/30' => !isDarkMode(),
                            ])>
                        <!-- Birthday Counter -->
                        <div class="flex items-center justify-center cursor-help group min-w-0 ml-1"
                             title="تعداد روزهای باقی مانده به تولد">
                            <i @class([
                                    'fas fa-birthday-cake text-lg mx-1 transition-colors duration-200 flex-shrink-0',
                                    'text-gray-400 group-hover:text-pink-400' => isDarkMode(),
                                    'text-gray-600 group-hover:text-pink-500' => !isDarkMode(),
                                ])></i>
                            <span @class([
                                    'text-sm font-medium ml-1 whitespace-nowrap',
                                    'text-red-500' => isFinalCountDown(),
                                    'text-gray-300' => (isDarkMode() && !isFinalCountDown()),
                                    'text-gray-700' => (!isDarkMode() && !isFinalCountDown()),
                                ])> {{ countNumberOfDaysToBirthday() }}
                            </span>
                        </div>
                        <!-- Work Days Counter -->
                        <div class="flex items-center justify-center space-x-2 cursor-help group min-w-0 mr-1"
                             title="تعداد روزهای سپری شده از آغاز کار در پرسال">
                            <i @class([
                                'fas fa-calendar-check text-lg mx-1 transition-colors duration-200 flex-shrink-0',
                                'text-gray-400 group-hover:text-green-400' => isDarkMode(),
                                'text-gray-600 group-hover:text-green-500' => !isDarkMode(),
                                        ])></i>
                            <span @class([
                                'text-sm font-medium whitespace-nowrap',
                                'text-gray-300' => isDarkMode(),
                                'text-gray-700' => !isDarkMode(),
                            ])>{{ countNumberOfDaysPassed() }}</span>
                        </div>
                    </div>

                    <!-- Reservation Section -->
                    <div @class([
                                'flex items-center justify-center py-2.5 px-5 rounded-lg mx-auto min-w-0',
                                'bg-gray-800/50' => isDarkMode(),
                                'bg-gray-200/30' => !isDarkMode(),
                            ])>
                        <!-- Office Reservation -->
                        <div class="flex cursor-pointer group min-w-0 ml-2"
                             title="رزرو میز کار: {{ showOfficeTitle() }}"
                             @click="event.preventDefault();window.open('{{ route('dashboard',['type'=>'office']) }}','_blank')">
                            <i @class([
                                'fas fa-desktop text-lg transition-all duration-200 transform group-hover:scale-110 flex-shrink-0',
                                'text-gray-400 group-hover:text-blue-400' => isDarkMode(),
                                'text-gray-600 group-hover:text-blue-500' => !isDarkMode(),
                            ])"></i>
                        </div>
                        <!-- Parking Reservation -->
                        <div class="flex cursor-pointer group min-w-0 mr-2"
                             title="رزرو جای پارک: {{ showParkingTitle() }}"
                             @click="event.preventDefault();window.open('{{ route('dashboard',['type'=>'parking']) }}','_blank')">
                            <i @class([
                                'fas fa-car text-lg transition-all duration-200 transform group-hover:scale-110 flex-shrink-0',
                                'text-gray-400 group-hover:text-blue-400' => isDarkMode(),
                                'text-gray-600 group-hover:text-blue-500' => !isDarkMode(),
                            ])"></i>
                        </div>
                    </div>

                    <!-- Timer Section -->
                    <div @class([
                                'hidden xl:flex items-center mx-auto text-sm font-bold py-3.5 px-5 rounded-lg',
                                'bg-gray-800/50' => isDarkMode(),
                                'bg-gray-200/30' => !isDarkMode(),
                            ])>
                        <x-dashboard.timer/>
                    </div>

                    <!-- Controls Section -->
                    <div @class([
                           'hidden sm:flex items-center justify-center px-5 py-2.5 rounded-lg mx-auto min-w-0',
                           'bg-gray-800/50' => isDarkMode(),
                           'bg-gray-200/30' => !isDarkMode(),
                       ])>
                        <!-- Light/Dark Mode Toggle -->
                        <div class="flex items-center justify-center cursor-pointer group min-w-0 mr-auto">
                            @if (isDarkMode())
                                <i @class([
                                    'fa fa-sun-o text-lg transition-all duration-200 transform group-hover:scale-110 flex-shrink-0',
                                    'text-gray-400 group-hover:text-yellow-400' => isDarkMode(),
                                    'text-gray-600 group-hover:text-yellow-500' => !isDarkMode(),
                                        ])
                                   title="حالت روز"
                                   onclick="window.location='{{route('landing-page', 'light-mode')}}'"></i>
                            @else
                                <i @class([
                                    'fa fa-moon-o text-lg transition-all duration-200 transform group-hover:scale-110 flex-shrink-0',
                                    'text-gray-400 group-hover:text-indigo-400' => isDarkMode(),
                                    'text-gray-600 group-hover:text-indigo-500' => !isDarkMode(),
                                        ])
                                   title="حالت شب"
                                   onclick="window.location='{{route('landing-page', 'dark-mode')}}'"></i>
                            @endif
                        </div>


                        <!-- Presence Toggle -->
                        <div class="flex items-center justify-center cursor-pointer group min-w-0 mx-3">
                            <i @class([
                                    'fas fa-exchange-alt text-lg transition-all duration-200 transform group-hover:scale-110 flex-shrink-0',
                                    'text-gray-400 group-hover:text-purple-400' => isDarkMode(),
                                    'text-gray-600 group-hover:text-purple-500' => !isDarkMode(),
                                ])
                               title="تغییر وضعیت"
                               @click="$refs.myNav.style.height ='100%'; version = false; presence=true;"></i>
                        </div>

                        <!-- Version Toggle -->
                        <div class="flex items-center justify-center cursor-pointer group min-w-0 ml-auto">
                            <i @class([
                                    'fa fa-arrow-circle-up text-lg transition-all duration-200 transform group-hover:scale-110 flex-shrink-0',
                                    'text-gray-400 group-hover:text-emerald-400' => isDarkMode(),
                                    'text-gray-600 group-hover:text-emerald-500' => !isDarkMode(),
                                ])
                               title="نسخه اپلیکیشن"
                               @click="$refs.myNav.style.height ='100%'; presence=false; version = true"></i>
                        </div>
                    </div>


                    <!-- Weather Section -->
                    <div @class([
                               'hidden xl:flex items-center mx-auto text-sm mx-auto min-w-0',
                               'text-gray-400' => isDarkMode(),
                               'text-gray-600' => !isDarkMode(),
                           ])>
                        <x-user.navbar.weather/>
                    </div>
                </div>

                <!-- User Dropdown -->
                <div class="hidden sm:flex items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                @class([
                                    'flex items-center text-sm font-medium px-2 py-2 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200',
                                    'text-gray-400 hover:bg-gray-800' => isDarkMode(),
                                    'text-gray-600 hover:bg-gray-100' => !isDarkMode(),
                                ])
                                type="button"
                            >
                                <div class="flex items-center space-x-4">
                                    <!-- User Info -->
                                    <div @class([
                                                'flex flex-row',
                                                'text-gray-400' => isDarkMode(),
                                                'text-gray-600' => !isDarkMode(),
                                                ])
                                         title="کد پرسنلی: {{ getPersonnelCode() }}"
                                    >
                                        <span class="ml-1 w-full text-left text-sm whitespace-nowrap">
                                            {{ Auth::user()->fullName }}
                                        </span>
                                        {!! showPresence() !!}
                                        <x-dashboard.badge/>
                                    </div>

                                    <!-- Dropdown Arrow Icon -->
                                    <div class="transform transition-transform duration-200 group-hover:rotate-180">
                                        <svg
                                            @class([
                                                'w-4 h-4',
                                                'text-gray-400' => isDarkMode(),
                                                'text-gray-600' => !isDarkMode(),
                                            ])
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            ></path>
                                        </svg>
                                    </div>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content" class="hover:border-none focus:border-none">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link
                                    :href="route('logout')"
                                    onclick="event.preventDefault();this.closest('form').submit();"
                                    class="flex items-center space-x-2 text-gray-500 transition-colors duration-200 focus:border-none"
                                >
                                    <span>خروج</span>
                                    <i class="fas fa-sign-out-alt"></i>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Mobile Logout -->
                <div class="flex items-center sm:hidden">
                    <form method="POST"
                          action="{{ route('logout') }}">
                        @csrf
                        <button
                            @click="this.closest('form').submit();"
                            title="خروج"
                            @class([
                                'p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 transform hover:scale-105',
                                'text-gray-400 hover:text-red-400 hover:bg-gray-800' => isDarkMode(),
                                'text-gray-500 hover:text-red-500 hover:bg-gray-100' => !isDarkMode()
                            ])>
                            <i class="fas fa-sign-out-alt text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div x-ref="myNav"
            @class([
                   'overlay container-scrollbar custom-scrollbar',
                   'bg-[#1F2937]' => isDarkMode(),
               ])>
            <!-- Button to close the overlay navigation -->
            <div class="close-animatedModal absolute right-8"
                 @click="$refs.myNav.style.height ='0%';presence=false; version=false">
                <img class="close-button my-10"
                     src="/img/user/closebt.svg"
                     alt="close-button">
            </div>

            <!-- status shifter -->
            <x-user.navbar.presence/>
            <!-- status shifter -->
            <x-user.navbar.update/>
        </div>
        <!-- BG -->
        {{--        <x-user.time-of-day/>--}}
    </div>
</nav>

