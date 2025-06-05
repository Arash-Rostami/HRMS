<div class="horizontal-space-left h-14 md:h-32 flex flex-grow" x-data
     @if(confirmParking($space))
         :class="'cursor-not-allowed hover:bg-transparent'"
     @elseif(!isNotInCenter($space))
         :class="'cursor-not-allowed hover:bg-transparent'"
     @else
         @click="showModal = true; $refs.number.value = {{ $space['id']}};window.scrollTo({top: 0, behavior: 'smooth'})"
    @endif>
    <div class="horizontal-space-left-entry h-2 md:h-3"></div>
    <span class="horizontal-space-number md:text:md p-1 absolute">{{$space['number'] ?? $space}}</span>

    @if( confirmParking($space))
        <x-dashboard.parking-signs direction="right" :space="$space"/>
    @elseif(!isNotInCenter($space))
        <img src="/img/no-park.png" title="belonging to other flats"
             class="h-1/2 relative top-3 left-4 md:left-3 md:top-7" alt="park-sign">
    @else
        <div class="tooltip-main right w-3/4">
            <span class="tooltip">
                    {!! showMap($space) !!}
            </span>
            <img src="/img/free-park.png" class="h-1/2 relative top-3 left-4 md:left-3 md:top-7" alt="park-sign">
        </div>
    @endif
</div>
