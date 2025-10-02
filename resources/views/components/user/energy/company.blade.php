@php
    $scoreConfig = [
        'physique' => ['label' => 'جسم',   'style' => 'background: #3e2f24;'],
        'emotion'  => ['label' => 'احساس', 'style' => 'background: #52585b;'],
        'mind'     => ['label' => 'ذهن',    'style' => 'background: #1f2933;'],
        'soul'     => ['label' => 'روح',    'style' => 'background: #7a5a48;'],
        'overall'  => ['label' => 'کل',     'style' => 'background: #000000;'],
    ];

    $cards = [['scores' => $companyAverages, 'name' => 'میانگین شرکت']];
    if($isManager && !empty($teamMembersData)) {
        $cards = array_merge($cards, $teamMembersData);
    }
@endphp

<div class="w-full md:w-2/3 m-auto p-4 md:px-16 md:py-8 pt-4">
    <div @class([
            'grid',
            'grid-cols-1',
            'gap-6',
            'md:grid-cols-2 lg:grid-cols-3' => $isManager && !empty($teamMembersData)
        ])>
        @foreach($cards as $card)
            <div class="p-4 rounded-lg links-thumbnails-color h-auto bg-weekend">
                <h4 class="text-base font-semibold mb-4 text-center text-gray-700">{{ $card['name'] }}</h4>
                <div class="grid grid-cols-5 gap-4 text-center">
                    @foreach(array_reverse($scoreConfig, true) as $key => $config)
                        <div class="flex flex-col items-center">
                            <div
                                class="w-8 rounded relative mb-2 overflow-hidden shadow-lg transform transition-all duration-300"
                                style="height: calc({{ $card['scores'][$key] ?? 0 }} * 6px + 24px); {{ $config['style'] }}">
                                <span class="text-xs font-bold text-white absolute left-1/2 -translate-x-1/2 bottom-1">
                                    {{ round($card['scores'][$key] ?? 0, 1) }}
                                </span>
                            </div>
                            <span class="text-xs">{{ $config['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
