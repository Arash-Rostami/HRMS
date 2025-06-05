<div class="horizontal-office-left w-auto h-auto md:h-32 flex flex-grow" x-data
     @if(confirmDesk($desk))
     :class="'cursor-not-allowed hover:bg-transparent'"
     @else
     @click="showModal = true;$refs.number.value = {{ $desk['id']}};window.scrollTo({top: 0, behavior: 'smooth'})"
    @endif>
    <span class="horizontal-office-number mx-auto md:text:md p-1">{{$desk["number"]}}</span>

    @if(confirmDesk($desk))
        <x-dashboard.office-signs direction="left" :space="$desk"/>
    @else
        <div class="tooltip-main right">
                <span class="tooltip">
                    {!! showMap($desk) !!}
                </span>
            <div class="rotate-180 mx-auto my-auto align-middle relative right-2 md:left-2">
                <div class="mx-auto align-middle rotate-90">
                    @include(randomizeDesks())
                </div>
            </div>
        </div>
    @endif
</div>

