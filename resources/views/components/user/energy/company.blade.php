@php
    $scores = ['physique' => 'بدن', 'emotion' => 'احساس', 'mind' => 'ذهن', 'soul' => 'روح', 'overall' => 'کل'];
    $colors = ['physique' => 'blue', 'emotion' => 'red', 'mind' => 'green', 'soul' => 'yellow', 'overall' => 'purple'];
    $cards = [['scores' => $companyAverages, 'name' => 'میانگین شرکت']];
    if($isManager && !empty($teamMembersData)) $cards = array_merge($cards, $teamMembersData);
@endphp

<div class="w-full md:w-2/3 mx-auto p-4 md:px-16 md:py-8 pt-4">
    <div @class([
                'grid',
                'grid-cols-1',
                'gap-8',
                'md:grid-cols-2 lg:grid-cols-3' => $isManager && ! empty($teamMembersData)])>
        @foreach($cards as $card)
            <div class="p-4 rounded-lg border border-gray-200 shadow-sm">
                <div class="grid grid-cols-5 gap-4 text-center">
                    @foreach($scores as $key => $label)
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-24 bg-{{$colors[$key]}}-500 rounded relative mb-2"
                                 style="height: calc({{$card['scores'][$key] ?? 0}} * 6px + 24px);">
                                <span
                                        class="absolute -top-6 text-xs font-medium">{{round($card['scores'][$key] ?? 0, 1)}}</span>
                            </div>
                            <span class="text-xs">{{$label}}</span>
                        </div>
                    @endforeach
                </div>
                <h4 class="text-base font-semibold mt-4 text-center text-gray-700">{{$card['name']}}</h4>
            </div>
        @endforeach
    </div>
</div>
