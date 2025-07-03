@php
    $tabs = [
        ['key' => 'welcome',   'color' => 'border-yellow-500', 'title' => 'خوش آمدگویی'],
        ['key' => 'schedule',   'color' => 'border-blue-500', 'title' => 'برنامه آنبوردینگ'],
        ['key' => 'info',  'color' => 'border-red-500', 'title' => 'مزایا پرسال'],
        ['key' => 'files',  'color' => 'border-green-500', 'title' => 'کتابچه های راهنما'],
        ['key' => 'accounts',   'color' => 'border-purple-500', 'title' => 'سامانه های  سازمانی'],
        ['key' => 'documents', 'color' => 'border-pink-500', 'title' => 'مدارک پرسنلی'],
        ['key' => 'office', 'color' => 'border-amber-500', 'title' => 'فضای کار شما'],
        ['key' => 'guide', 'color' => 'border-teal-500', 'title' => 'راهنمای اپ'],
    ];
    $activeBg = isDarkMode() ? 'bg-gray-600' : 'bg-gray-300';
    $activeClr = isDarkMode() ?  'text-main-theme' : 'text-gray-700';
@endphp
<ul x-data="{ active: '{{ $tabs[0]['key'] }}' }"
    class="nav nav-tabs flex flex-row md:flex-col flex-wrap list-none pt-0 pb-0 mt-5 md:mt-0 mb-5 md:mb-0 ml-6 bg-weekend rounded"
    id="pills-tabVertical"
    role="tablist"
    data-te-nav-ref>
    @foreach($tabs as $tab)
        <li class="nav-item flex-grow text-center" role="presentation">
            <a
                    href="#tabs-{{ $tab['key'] }}"
                    id="tabs-{{ $tab['key'] }}-tabVertical"
                    title="{{ $tab['title'] }}"
                    data-te-toggle="pill"
                    data-te-target="#pills-{{ $tab['key'] }}"
                    role="tab"
                    aria-controls="pills--{{ $tab['key'] }}"
                    @class([
                       'nav-link block font-medium px-6 py-3 my-2',
                       'border-y-2' . $tab['color'] . $activeBg . 'text-main-theme' => $loop->first,
                       $activeBg => $loop->first,
                       'hover:bg-gray-300 hover:text-gray-900' => !isDarkMode(),
                       'hover:bg-gray-700 hover:text-gray-200' => isDarkMode(),
                   ])
                    @click="active = '{{ $tab['key'] }}'; $dispatch('tab-changed', { tab: active })"
                    :aria-selected="active === '{{ $tab['key'] }}'"
                    :data-te-nav-active="active === '{{ $tab['key'] }}'"
                    :class=" {
               '{{ $tab['color'] }} border-y-2 {{ $activeBg }} {{ $activeClr }}': active === '{{ $tab['key'] }}',
               '{{ $tab['color'] }}': active === '{{ $tab['key'] }}'
           }">
                {{ $tab['title'] }}
            </a>
        </li>
    @endforeach
</ul>
