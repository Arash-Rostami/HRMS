<nav x-data="{
    open: false, play: false, version:false, presence:false,
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
    "
     class="text-gray-900 mb-12 opacity-100 bg-transparent
            @if ( isDarkMode()) text-gray-300 @endif">
    {{--    <x-time-of-day/>--}}
    {{--    <!-- Music -->--}}
    {{--    <div class="hidden md:block">--}}
    {{--        <x-music></x-music>--}}
    {{--    </div>--}}
    <!-- Primary Navigation Menu -->
    <div class="mx-10 md:mx-20 fade-in-fwd" x-cloak>
        <div class="flex justify-between md:justify-content-evenly h-16">
            <!-- Logo -->
            <div class="shrink-0 flex items-center md:relative md:right-5">
                <a href="{{ route('landing.page') }}">
                    <x-application-logo class="block h-10 w-auto fill-current"/>
                </a>
            </div>

            <div class="flex justify-between w-auto">
                <!-- Navigation Links -->
                <div class="mx-auto w-auto flex flex-row content-center">

                    <!--   Display refresh -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex cursor-pointer">
                        <x-nav-link>
                            {{--                            :href="route('user.panel',['type'=>request()->get('type')])"--}}
                            {{--                            :active="request()->routeIs('user.panel')">--}}
                            <span class="text-xl text-main border px-2 border-main"
                                  @click="toggleFullScreen()"
                                  title="Toggle fullscreen mode"> ⤢ </span>
                        </x-nav-link>
                    </div>

                    <!--   Display birthday and working days -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link>
                            <span class="@if ( isDarkMode()) text-gray-300 @endif">
                              <span class="mr-1 @if( isFinalCountDown()) mr-2 @endif cursor-help"
                                    title="the number of days to your B'day">
                                  <i class="fas fa-birthday-cake text-gray-500"></i>
                                 <span class="@if( isFinalCountDown()) text-red-600  @endif">
                                     {{ countNumberOfDaysToBirthday() }}
                                 </span>
                              </span>
                                <span class="ml-1 cursor-help" title="the number of days you've worked in Persol">
                                    <i class="fas fa-calendar-check ml-1 text-gray-500"></i> {{ countNumberOfDaysPassed() }}
                                </span>
                            </span>
                        </x-nav-link>
                    </div>

                    <!--   Display office & park shortcuts -->
                    <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex my-auto">
                        <x-nav-link>
                            <i class="fas fa-desktop mx-2 cursor-pointer"
                               title="Office: {{ showOfficeTitle() }}"
                               @click="event.preventDefault();window.open('{{ route('dashboard',['type'=>'office']) }}','_blank')"
                            ></i>
                            <i class="fas fa-car mx-2 text-lg cursor-pointer"
                               title="Parking: {{ showParkingTitle() }}"
                               @click="event.preventDefault();window.open('{{ route('dashboard',['type'=>'parking']) }}','_blank')"
                            ></i>
                        </x-nav-link>
                    </div>

                    <!--   Display timer -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link>
                            <x-dashboard.timer/>
                        </x-nav-link>
                    </div>

                    <!--   Display weather forecast -->
                    <div
                        class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex cursor-pointer">
                        <x-nav-link>
{{--                            <x-weather/>--}}
                        </x-nav-link>
                    </div>

                    <!--   Display light & dark mode -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex cursor-pointer">
                        <x-nav-link>
                            |
                            @if ( isDarkMode())
                                <i class="fa fa-sun-o text-white" title="change into light mode"
                                   onclick="window.location='{{route('landing-page', 'light-mode')}}'"></i>
                            @else
                                <i class="fa fa-moon-o text-gray-500" title="change into dark mode"
                                   onclick="window.location='{{route('landing-page', 'dark-mode')}}'"></i>
                            @endif
                            |
                        </x-nav-link>
                    </div>

                    <!--   Display change status -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex cursor-pointer">
                        <x-nav-link>
                            |
                            <span class="  @if ( isDarkMode())  text-white @else text-gray-500  @endif"
                                  title="change the status">
                                <i class="fas fa-exchange-alt" @click="$refs.myNav.style.height ='100%';
                                version = false; presence=true; "></i>
                            </span>
                            |
                        </x-nav-link>
                    </div>

                    <!--   Display app versions -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex cursor-pointer">
                        <x-nav-link>
                            |
                            <span class="  @if ( isDarkMode())  text-white @else text-gray-500  @endif"
                                  title="view update versions">
                            <i class="fa fa-arrow-circle-up"
                               @click="$refs.myNav.style.height ='100%'; presence=false; version = true"></i>
                            </span>
                            |
                        </x-nav-link>
                    </div>
                </div>
            </div>

            <!-- Users Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div
                                class="font-medium text-sm text-gray-500 italic main-color">
                                <span class="  @if ( isDarkMode())  text-gray-300 @endif"
                                      title="personnel code:&nbsp; {{ getPersonnelCode($users) ?? '' }}">
                                  {{ showPresence() }}  {{ Auth::user()->fullName}}
                                </span>
                                <x-dashboard.badge/>
                            </div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- LOG OUT -->
            <div class="-mr-2 flex items-center sm:hidden">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button @click="this.closest('form').submit();" title="sign out"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">

                        <i class="fas fa-sign-out-alt fa-circle"></i>
                    </button>
                </form>
            </div>

        </div>
    </div>


    {{--    overlay of presence change--}}
    <div x-ref="myNav" class="overlay container-scrollbar custom-scrollbar @if ( isDarkMode()) bg-[#1F2937] @endif">
        <!-- Button to close the overlay navigation -->
        <div class="close-animatedModal absolute right-8"
             @click="$refs.myNav.style.height ='0%';presence=false; version=false">
            <img class="close-button my-10" src="/img/user/closebt.svg" alt="close-button">
        </div>

        <!-- status shifter -->
        <x-user.presence/>
        <!-- status shifter -->
        <x-user.update/>
    </div>
</nav>

