<nav x-data="{ open: false, play: false }" class="bg-white border-b border-gray-100">
    <!-- Music -->
    <div class="hidden md:block">
        <x-music></x-music>
    </div>
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 slide-in-right">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center md:relative md:right-5">
                    <a href="{{ route('landing.page') }}">
                        <x-application-logo class="block h-10 w-auto fill-current"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard',['type'=> showOtherDashboard() ])"
                                :active="request()->routeIs('dashboard')">
                        | <span class="rotate-45"
                                title="Switch to {{  ucfirst(showOtherDashboard())  }} ">
                            &#8634;
                        </span>
                        |
                    </x-nav-link>

                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex cursor-pointer">
                    <x-nav-link @click="Search.openNav()">
                        | SEARCH <i class="fas fa-search ml-2"></i> |
                    </x-nav-link>

                </div>


                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link>
                        | RESERVATIONS
                        <span
                            class="main-background shadow main-color text-sm font-medium px-2.5 py-0.5 rounded cursor-help">
                            @if(session()->has('total'))
                                {{session('total')}} / {{showTotalAvailableReservations()}}
                            @else
                                <span title="choose specific date to see stats"> click on date</span>
                            @endif
                        </span> |
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link>
                        | AVAILABLE
                        <span
                            class="bg-gray-300 shadow text-green-800 text-sm font-medium px-2.5 py-0.5 rounded cursor-help"
                            title="untaken">
                            @if(session()->has('remain'))
                                {{session('remain')}}
                            @else
                                <span title="choose specific date to see stats">N/A</span>
                            @endif
                        </span>
                        <span
                            class="bg-gray-200 shadow text-red-800 text-sm font-medium px-2.5 py-0.5 rounded cursor-help"
                            title="taken">
                            @if(session()->has('total'))
                                {{session('total')}}
                            @else
                                <span title="choose specific date to see stats">N/A</span>
                            @endif
                        </span> |
                    </x-nav-link>

                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link>
                        <x-dashboard.timer/>
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex cursor-pointer">
                    <x-nav-link>
                        |
                        @if ( isDarkMode())
                            <i class="fa fa-sun-o" title="change into light mode"
                               onclick="window.location='{{route('landing-page', 'light-mode')}}'"></i>
                        @else
                            <i class="fa fa-moon-o" title="change into dark mode"
                               onclick="window.location='{{route('landing-page', 'dark-mode')}}'"></i>
                        @endif|
                    </x-nav-link>
                </div>

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div
                                class="font-medium text-sm text-gray-500 italic main-color">
                                {{ Auth::user()->forename}} {{Auth::user()->surname }}
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

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard', ['type'=> showOtherDashboard() ])"
                                   :active="request()->routeIs('dashboard')">
                <div class="dashboard-link-responsive p-4 text-right">
                    <span class="rotate-45">&#8634; </span>
                    SWITCH TO {{strtoupper(showOtherDashboard())}}
                </div>
            </x-responsive-nav-link>
            <x-responsive-nav-link>
                <div class="dashboard-link-responsive" @click="open = ! open; Search.openNav()">
                    SEARCH <i class="fas fa-search"></i>
                </div>
            </x-responsive-nav-link>
            <x-responsive-nav-link>
                <div class="dashboard-link-responsive cursor-help">
                    RESERVATIONS
                    <span
                        class="main-background shadow main-color text-sm font-medium px-2.5 py-0.5 rounded cursor-help">
                        @if(session()->has('total'))
                            {{session('total')}} / {{showTotalAvailableReservations()}}
                        @else
                            <span title="choose specific date to see stats"> click on date</span>
                        @endif
                        </span>
                </div>
            </x-responsive-nav-link>
            <x-responsive-nav-link>
                <div class="dashboard-link-responsive cursor-help">
                    AVAILABLE
                    <span
                        class="bg-gray-300 shadow text-green-800 text-sm font-medium px-2.5 py-0.5 rounded cursor-help">
                        @if(session()->has('remain'))
                            {{session('remain')}}
                        @else
                            <span title="choose specific date to see stats">N/A</span>
                        @endif
                        </span>
                    <span
                        class="bg-gray-200 shadow text-red-800 text-sm font-medium px-2.5 py-0.5 rounded cursor-help">
                        @if(session()->has('total'))
                            {{session('total')}}
                        @else
                            <span title="choose specific date to see stats">N/A</span>
                        @endif
                        </span>
                </div>
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <!-- Music -->
            <x-music></x-music>

            <div class="mr-4">
                <div class="font-medium text-sm text-gray-500 italic main-color text-right">
                    {{ Auth::user()->forename}} {{Auth::user()->surname }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <div class="dashboard-link-responsive"> Log out</div>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
