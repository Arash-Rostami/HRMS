<div class="horizontal-office-right w-auto h-auto md:h-32 flex flex-grow" x-data
     @if(confirmDesk($desk))
         :class="'cursor-not-allowed hover:bg-transparent'"
     @else
         @click="showModal = true; $refs.number.value = {{ $desk['id']}};window.scrollTo({top: 0, behavior: 'smooth'})"
    @endif>
    <span class="horizontal-office-number mx-auto md:text:md">{{$desk['number']}}</span>

    @if(confirmDesk($desk))
        <div class="p-2">
            <x-dashboard.office-signs direction="right" :space="$desk"/>
        </div>
    @else
        <div class="tooltip-main left">

                <span class="tooltip">
                    {!! showMap($desk) !!}
                </span>

            <div class="mx-auto align-middle rotate-90 relative right-0 md:right-11 md:top-2 z-0">
                @include(randomizeDesks())
            </div>
        </div>
    @endif
</div>

