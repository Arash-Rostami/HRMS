@if (hasUserReserved())
    @if(isMultipleDays())
        <div title="CANCEL MY RESERVATION"  @click="showModal = true; showSuspend=true; showCancel = false; showReserve = false;"
    @elseif(isOneDay())
        <div @click="showModal = true; showCancel = true; showReserve = false; showSuspend=false;"
             @endif
             class="flex mb-4 flex-col border-l-2 md:border-l-0 md:border-t-2 border-t-gray-500 border-l-gray-500 py-2
                 reservation-calender cursor-pointer rounded alert-box" title="CANCEL MY RESERVATION 2">
            <div class="flex self-center mx-2">
                {{showReservationNumber()}}
            </div>
            <div class="flex self-center mx-2">
                <i class="fas fa-calendar-minus text-xl md:text-xl"></i>&nbspcancel
            </div>
        </div>
    @endif
