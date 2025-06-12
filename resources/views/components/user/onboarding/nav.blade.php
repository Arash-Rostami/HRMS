@php
    $tabs = [
        ['key' => 'stageOne',   'label' => 'i',   'color' => 'border-yellow-500'],
        ['key' => 'stageTwo',   'label' => 'ii',  'color' => 'border-blue-500'],
        ['key' => 'stageFour',  'label' => 'iii', 'color' => 'border-green-500'],
        ['key' => 'stageFive',  'label' => 'iv',  'color' => 'border-purple-500'],
        ['key' => 'stageThree', 'label' => 'v',   'color' => 'border-red-500'],
    ];
    $activeBg = isDarkMode() ? 'bg-gray-700' : 'bg-gray-300';
    $activeClr = isDarkMode() ?  'text-main-theme' : 'text-gray-700';
@endphp
<ul x-data="{ active: '{{ $tabs[0]['key'] }}' }"
    class="nav nav-tabs flex flex-col flex-wrap list-none pt-0 pb-0 mt-0 mb-0 ml-6 bg-weekend rounded"
    id="pills-tabVertical"
    role="tablist"
    data-te-nav-ref>
    @foreach($tabs as $tab)
        <li class="nav-item flex-grow text-center" role="presentation">
            <a @click="active = '{{ $tab['key'] }}'"
               href="#tabs-{{ $tab['key'] }}"
               id="tabs-{{ $tab['key'] }}-tabVertical"
               data-te-toggle="pill"
               data-te-target="#pills-{{ $tab['key'] }}"
               role="tab"
               aria-controls="pills--{{ $tab['key'] }}"
               :aria-selected="active === '{{ $tab['key'] }}'"
               :data-te-nav-active="active"
               @class([
                   'nav-link block font-medium px-6 py-3 my-2',
                   'border-y-2' . $tab['color'] . $activeBg . 'text-main-theme' => $loop->first,
                   $activeBg => $loop->first,
                   'hover:bg-gray-300 hover:text-gray-900' => !isDarkMode(),
                   'hover:bg-gray-700 hover:text-gray-200' => isDarkMode(),
               ])
               :class=" {
               '{{ $tab['color'] }} border-y-2 {{ $activeBg }} {{ $activeClr }}': active === '{{ $tab['key'] }}',
               '{{ $tab['color'] }}': active === '{{ $tab['key'] }}'
           }">
                {{ $tab['label'] }}
            </a>
        </li>
    @endforeach
</ul>
