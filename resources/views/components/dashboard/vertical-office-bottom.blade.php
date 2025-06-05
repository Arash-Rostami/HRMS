<div class="vertical-office-bottom h-full w-10 md:w-20 flex flex-grow p-1" x-data
     @if(confirmDesk($desk))
         :class="'cursor-not-allowed hover:bg-transparent'"
     @else
         @click="showModal = true; $refs.number.value = {{ $desk['id']}}; window.scrollTo({top: 0, behavior: 'smooth'})"
    @endif>
    <span class="vertical-office-number md:text:md">{{$desk["number"]}}</span>

    @if( confirmDesk($desk))
        <x-dashboard.office-signs direction="bottom" :space="$desk"/>
    @else
        <div class="tooltip-main top">
                <span class="tooltip">
                    {!! showMap($desk) !!}
                </span>
            <div class="mx-auto align-middle rotate-180">
                @include(randomizeDesks())
            </div>
        </div>
    @endif
</div>
