<div class="vertical-office-top h-full w-10 md:w-20 flex flex-grow p-1 mx-auto" x-data
     @if(confirmDesk($desk))
         :class="'cursor-not-allowed hover:bg-transparent'"
     @else
         @click="showModal = true; $refs.number.value = {{ $desk['id']}}"
    @endif>
    <span class="vertical-office-number md:text:md relative">{{$desk["number"]}}</span>

    @if(confirmDesk($desk))
        <x-dashboard.office-signs direction="top" :space="$desk"/>
    @else
        <div class="tooltip-main bottom">
                <span class="tooltip">
                    {!! showMap($desk) !!}
                </span>
            @include(randomizeDesks())
        </div>
    @endif
</div>



