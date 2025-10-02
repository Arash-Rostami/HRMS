@php
    $dropdownMenus = [
        [
            'id' => 'reservations',
            'icon' => 'fas fa-calendar-check',
            'label' => 'رزرو',
            'position' => 'right-5',
            'items' => [
                ['route' => route('dashboard',['type'=>'parking']), 'icon' => 'fas fa-parking', 'color' => 'text-blue-600', 'label' => 'پارکینگ', 'blank' => true],
                ['route' => route('dashboard',['type'=>'office']), 'icon' => 'fas fa-building', 'color' => 'text-purple-600', 'label' => 'میز سازمانی', 'blank' => true]
            ]
        ],
        [
            'id' => 'view',
            'icon' => 'fas fa-walking',
            'label' => 'روزمرگی',
            'position' => 'left-0',
            'items' => [
                ['scroll' => '#calendar', 'icon' => 'fas fa-calendar-alt', 'color' => 'text-green-600', 'label' => 'تقویم'],
                ['scroll' => '#bulletin', 'icon' => 'fa fa-newspaper-o', 'color' => 'text-orange-600', 'label' => 'اعلانات'],
                ['scroll' => '#personnel', 'icon' => 'fas fa-users', 'color' => 'text-blue-600', 'label' => 'پرسنل'],
                ['scroll' => '#gallery', 'icon' => 'fas fa-images', 'color' => 'text-yellow-600', 'label' => 'گالری'],
                ['scroll' => '#report', 'icon' => 'fas fa-chart-line', 'color' => 'text-indigo-600', 'label' => 'گزارشات'],
                ['scroll' => '#tools', 'icon' => 'fas fa-external-link-alt', 'color' => 'text-teal-600', 'label' => 'ابزار خارجی'],
                ['scroll' => '#links', 'icon' => 'fas fa-link', 'color' => 'text-cyan-600', 'label' => 'لینک های داخلی'],
                ['scroll' => '#faq', 'icon' => 'fas fa-question-circle', 'color' => 'text-pink-600', 'label' => 'سوالات متداول']
            ]
        ],
        [
            'id' => 'tools',
            'icon' => 'fas fa-tools',
            'label' => 'جعبه ابزار',
            'position' => 'left-0',
            'items' => [
                ['route' => route('user.panel.edit'), 'icon' => 'fas fa-portrait', 'color' => 'text-blue-600', 'label' => 'پروفایل', 'blank' => true],
                ['route' => route('user.toggleModule', ['module' => 'onboarding']), 'icon' => 'fa fa-road', 'color' => 'text-orange-600', 'label' => 'آنبوردینگ', 'blank' => true],
                ['route' => route('user.toggleModule', ['module' => 'energy']), 'icon' => 'fas fa-battery-full', 'color' => 'text-green-600', 'label' => 'انرژی فردی', 'blank' => true],
                ['route' => route('user.toggleModule', ['module' => 'analytics']), 'icon' => 'fas fa-chart-bar', 'color' => 'text-indigo-600', 'label' => 'آنالیتیک', 'blank' => true],
                ['divider' => true],
                ['id' => 'radioWidget', 'action' => "window.dispatchEvent(new Event('openJazzRadio'))", 'icon' => 'fas fa-music', 'color' => 'text-indigo-600', 'label' => 'رادیو'],
                ['route' => route('user.toggleModule', ['module' => 'music']), 'icon' => 'fa fa-headphones', 'color' => 'text-purple-600', 'label' => 'موسیقی', 'blank' => true],
                ['id' => 'openCalculator', 'icon' => 'fas fa-calculator', 'color' => 'text-teal-600', 'label' => 'ماشین حساب'],
                ['id' => 'playAudioButton', 'icon' => 'fas fa-clock', 'color' => 'text-cyan-600', 'label' => 'تایمر'],
                ['id' => 'sloganLink', 'icon' => 'fas fa-lightbulb', 'color' => 'text-yellow-600', 'label' => 'اصول سازمانی'],
            ]
        ],
        [
            'id' => 'management',
            'icon' => 'fas fa-briefcase',
            'label' => 'مدیریت',
            'position' => 'left-0',
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
        ]
    ];

    $buttonClasses = isDarkMode() ? 'hover:bg-gray-800 hover:text-gray-300' : 'hover:bg-gray-100 hover:text-gray-700';
    $buttonActiveClasses = isDarkMode() ? 'dark:text-white dark:bg-gray-700' : 'text-gray-900 bg-gray-200';
    $dropdownClasses = isDarkMode()  ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200';
    $itemClasses = isDarkMode()
    ? 'block w-full text-left px-4 py-2 rounded-md text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-150'
    : 'block w-full text-left px-4 py-2 rounded-md text-gray-700 hover:bg-gray-300 hover:text-black transition-colors duration-150';

    $iconClasses = isDarkMode()
    ? 'text-gray-500 group-hover:text-white transition-colors duration-200'
    : 'text-gray-400 group-hover:text-gray-600 transition-colors duration-200';
    $dividerClasses = isDarkMode() ? 'border-gray-700'  : 'border-gray-200';
@endphp

<div class="hidden lg:flex items-center gap-3 cursor-pointer">
    @foreach($dropdownMenus as $menu)
        <div class="relative">
            <button @click="toggleMenu('{{ $menu['id'] }}')"
                    aria-haspopup="true"
                    :aria-expanded="openMenu === '{{ $menu['id'] }}'"
                    aria-controls="dropdown-{{ $menu['id'] }}"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-lg transition-colors duration-200 font-medium text-main {{ $buttonClasses }}"
                    :class="{ '{{ $buttonActiveClasses }}': openMenu === '{{ $menu['id'] }}' }">
                <i class="{{ $menu['icon'] }}"></i>
                <span class="hidden md:inline">{{ $menu['label'] }}</span>
                <i class="fas fa-chevron-down text-xs transition-transform duration-200"
                   :class="{'rotate-180': openMenu === '{{ $menu['id'] }}'}"></i>
            </button>

            <div x-show="openMenu === '{{ $menu['id'] }}'"
                 x-transition
                 x-cloak
                 id="dropdown-{{ $menu['id'] }}"
                 class="absolute {{ $menu['position'] }} mt-2 w-56 rounded-xl shadow-2xl py-2 {{ $dropdownClasses }}">

                @foreach($menu['items'] as $item)
                    @if(isset($item['divider']))
                        <div class="border-t my-2 {{ $dividerClasses }}"></div>
                    @elseif(isset($item['scroll']))
                        <a @click.prevent="scrollToSection('{{ $item['scroll'] }}')"
                           class="flex items-center gap-3 px-4 py-3 transition-colors duration-150 cursor-pointer {{ $itemClasses }}">
                            <i class="{{ $item['icon'] }} w-5 text-center {{ $item['color'] }}"></i>
                            <span class="font-medium">{{ $item['label'] }}</span>
                        </a>
                    @elseif(isset($item['action']))
                        <button type="button" @click="{{ $item['action'] }}"
                                class="w-full text-left flex items-center gap-3 px-4 py-3 transition-colors duration-150 {{ $itemClasses }}">
                            <i class="{{ $item['icon'] }} w-5 text-center {{ $item['color'] }}"></i>
                            <span class="font-medium">{{ $item['label'] }}</span>
                        </button>
                    @elseif(isset($item['id']))
                        <a id="{{ $item['id'] }}"
                           class="flex items-center gap-3 px-4 py-3 transition-colors duration-150 cursor-pointer {{ $itemClasses }}">
                            <i class="{{ $item['icon'] }} w-5 text-center {{ $item['color'] }}"></i>
                            <span class="font-medium">{{ $item['label'] }}</span>
                        </a>
                    @else
                        <a @click.prevent="window.open('{{ $item['route'] }}', '_blank')"
                           @if(isset($item['blank']) && $item['blank']) target="_blank" rel="noopener noreferrer" @endif
                           class="flex items-center gap-3 px-4 py-3 transition-colors duration-150 {{ $itemClasses }}">
                            <i class="{{ $item['icon'] }} w-5 text-center {{ $item['color'] }}"></i>
                            <span class="font-medium">{{ $item['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    @endforeach
</div>
