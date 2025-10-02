@php
    $mobileAccordions = [
        [
            'id' => 'reservations',
            'icon' => 'fa fa-calendar-check',
            'label' => 'رزرو',
            'items' => [
                ['route' => route('dashboard',['type'=>'parking']), 'icon' => 'fas fa-parking', 'color' => 'text-blue-500', 'label' => 'پارکینگ'],
                ['route' => route('dashboard',['type'=>'office']), 'icon' => 'fas fa-building', 'color' => 'text-purple-500', 'label' => 'میز سازمانی']
            ]
        ],
        [
            'id' => 'view',
            'icon' => 'fa fa-walking',
            'label' => 'روزمرگی',
            'items' => [
                ['scroll' => '#calendar', 'icon' => 'fas fa-calendar-alt', 'color' => 'text-green-500', 'label' => 'تقویم'],
                ['scroll' => '#bulletin', 'icon' => 'fa fa-newspaper-o', 'color' => 'text-orange-500', 'label' => 'اعلانات'],
                ['scroll' => '#personnel', 'icon' => 'fas fa-users', 'color' => 'text-blue-500', 'label' => 'پرسنل'],
                ['scroll' => '#gallery', 'icon' => 'fas fa-images', 'color' => 'text-yellow-500', 'label' => 'گالری'],
                ['scroll' => '#report', 'icon' => 'fas fa-chart-line', 'color' => 'text-indigo-500', 'label' => 'گزارشات'],
                ['scroll' => '#tools', 'icon' => 'fas fa-external-link-alt', 'color' => 'text-teal-500', 'label' => 'ابزار خارجی'],
                ['scroll' => '#links', 'icon' => 'fas fa-link', 'color' => 'text-cyan-500', 'label' => 'لینک های داخلی'],
                ['scroll' => '#faq', 'icon' => 'fas fa-question-circle', 'color' => 'text-pink-500', 'label' => 'سوالات متداول']
            ]
        ],
        [
            'id' => 'tools',
            'icon' => 'fa fa-tools',
            'label' => 'جعبه ابزار',
            'items' => [
                ['route' => route('user.panel.edit'), 'icon' => 'fas fa-portrait', 'color' => 'text-blue-500', 'label' => 'پروفایل'],
                ['route' => route('user.toggleModule', ['module' => 'onboarding']), 'icon' => 'fa fa-road', 'color' => 'text-orange-500', 'label' => 'آنبوردینگ'],
                ['route' => route('user.toggleModule', ['module' => 'energy']), 'icon' => 'fas fa-battery-full', 'color' => 'text-green-500', 'label' => 'انرژی فردی'],
                ['route' => route('user.toggleModule', ['module' => 'analytics']), 'icon' => 'fas fa-chart-bar', 'color' => 'text-indigo-500', 'label' => 'آنالیتیک'],
                ['id' => 'radioWidget', 'action' => "window.dispatchEvent(new Event('openJazzRadio'))", 'icon' => 'fas fa-music', 'color' => 'text-indigo-600', 'label' => 'رادیو'],
                ['route' => route('user.toggleModule', ['module' => 'music']), 'icon' => 'fa fa-headphones', 'color' => 'text-purple-500', 'label' => 'موسیقی'],
                ['divider' => true],
                ['id' => 'openCalculator', 'icon' => 'fas fa-calculator', 'color' => 'text-teal-500', 'label' => 'ماشین حساب'],
                ['id' => 'playAudioButton', 'icon' => 'fas fa-clock', 'color' => 'text-cyan-500', 'label' => 'تایمر'],
                ['id' => 'sloganLink', 'icon' => 'fas fa-lightbulb', 'color' => 'text-yellow-500', 'label' => 'اصول سازمانی']
            ]
        ],
        [
            'id' => 'management',
            'icon' => 'fa fa-briefcase',
            'label' => 'مدیریت',
            'items' => [
                ['route' => '/main/admin', 'icon' => 'fas fa-cogs', 'color' => 'text-emerald-500', 'label' => 'ادمین', 'blank' => true],
                ['route' => route('user.toggleModule', ['module' => 'feed']), 'icon' => 'fas fa-rss', 'color' => 'text-orange-500', 'label' => 'اخبار', 'blank' => true],
                ['route' => route('user.toggleModule', ['module' => 'suggestion']), 'icon' => 'fa fa-bullhorn', 'color' => 'text-pink-500', 'label' => 'پیشنهادات', 'blank' => true],
                ['route' => route('user.toggleModule', ['module' => 'dms']), 'icon' => 'fa fa-archive', 'color' => 'text-cyan-500', 'label' => 'اسناد', 'blank' => true],
                ['route' => route('user.toggleModule', ['module' => 'ths']), 'icon' => 'fas fa-ticket-alt', 'color' => 'text-amber-500', 'label' => 'تیکت', 'blank' => true],
                ['divider' => true],
                ['route' => route('user.toggleModule', ['module' => 'delegation']), 'icon' => 'fas fa-tasks', 'color' => 'text-lime-500', 'label' => 'اختیارات', 'blank' => true],
                ['route' => route('crm'), 'icon' => 'fas fa-database', 'color' => 'text-red-500', 'label' => 'سی آر ام', 'blank' => true]
            ]
        ],

    ];

    $containerClasses = isDarkMode()
        ? 'bg-gray-800 text-gray-400'
        : 'bg-gray-200/30 text-gray-700';

    $borderClasses = isDarkMode()
        ? 'border-gray-700'
        : 'border-gray-200';

    $sectionBorderClasses = isDarkMode()
        ? 'border-gray-700/50'
        : 'border-gray-200';

    $buttonClasses = isDarkMode()
        ? 'text-main hover:bg-gray-800'
        : 'text-main hover:bg-gray-300';

    $itemClasses = isDarkMode()
    ? 'block w-full text-left px-4 py-2 rounded-md text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-150'
    : 'block w-full text-left px-4 py-2 rounded-md text-gray-700 hover:bg-gray-300 hover:text-black transition-colors duration-150';

    $iconClasses = isDarkMode()
    ? 'text-gray-500 group-hover:text-white transition-colors duration-200'
    : 'text-gray-400 group-hover:text-gray-600 transition-colors duration-200';
@endphp

<div x-show="mobileMenuOpen"
     x-cloak
     x-transition
     class="lg:hidden absolute top-full left-0 w-full shadow-lg z-[50] bg-main rounded-lg"
     id="mobile-menu">

    <div x-show="mobileMenuOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileMenuOpen = false"
         class="fixed inset-0">
    </div>

    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         x-data="{ openAccordion: null }"
         class="relative w-full bg-main shadow-xl flex flex-col rounded-lg overflow-hidden cursor-pointer {{ $containerClasses }}">

        <div class="flex items-center justify-between p-4 w-full border-b {{ $borderClasses }}">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 persol-farsi-font"></h2>
            <button @click="mobileMenuOpen = false"
                    class="w-full flex items-center justify-between text-base font-medium p-2 rounded-lg transition-colors {{ $buttonClasses }}">
                <i class="fas fa-times text-main"></i>
                <span class="sr-only">Close menu</span>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-4">
            <div class="space-y-2">
                @foreach($mobileAccordions as $index => $accordion)
                    <div class="{{ $index < count($mobileAccordions) - 1 ? 'border-b pb-2 ' . $sectionBorderClasses : 'pb-2' }}">
                        <button @click="openAccordion = openAccordion === '{{ $accordion['id'] }}' ? null : '{{ $accordion['id'] }}'"
                                class="w-full flex items-center justify-between text-base font-medium p-2 rounded-lg transition-colors {{ $buttonClasses }}">
                            <span>
                                <i class="{{ $accordion['icon'] }} w-6 text-center {{ $iconClasses }} mr-3"></i>
                                {{ $accordion['label'] }}
                            </span>
                            <i class="fas fa-chevron-down text-xs transition-transform"
                               :class="{ 'rotate-180': openAccordion === '{{ $accordion['id'] }}' }"></i>
                        </button>

                        <div x-show="openAccordion === '{{ $accordion['id'] }}'" x-collapse class="pt-2 pr-4 space-y-1">
                            @foreach($accordion['items'] as $item)
                                @if(isset($item['divider']))
                                    <div class="border-t my-2 {{ $sectionBorderClasses }}"></div>
                                @elseif(isset($item['scroll']))
                                    <a @click.prevent="scrollToSection('{{ $item['scroll'] }}')"
                                       class="flex items-center gap-3 px-3 py-2.5 rounded-md transition-colors {{ $itemClasses }}">
                                        <i class="{{ $item['icon'] }} w-5 text-center {{ $item['color'] }}"></i>
                                        <span>{{ $item['label'] }}</span>
                                    </a>
                                @elseif(isset($item['action']))
                                    <a @click.prevent="{{ $item['action'] }}"
                                       class="flex items-center gap-3 px-3 py-2.5 rounded-md transition-colors  {{ $itemClasses }}">
                                        <i class="{{ $item['icon'] }} w-5 text-center {{ $item['color'] }}"></i>
                                        <span class="font-medium">{{ $item['label'] }}</span>
                                    </a>
                                @elseif(isset($item['id']))
                                    <a id="{{ $item['id'] }}"
                                       class="flex items-center gap-3 px-3 py-2.5 rounded-md transition-colors {{ $itemClasses }}">
                                        <i class="{{ $item['icon'] }} w-5 text-center {{ $item['color'] }}"></i>
                                        <span>{{ $item['label'] }}</span>
                                    </a>
                                @else
                                    <a href="{{ $item['route'] }}"
                                       class="flex items-center gap-3 px-3 py-2.5 rounded-md transition-colors {{ $itemClasses }}">
                                        <i class="{{ $item['icon'] }} w-5 text-center {{ $item['color'] }}"></i>
                                        <span>{{ $item['label'] }}</span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
