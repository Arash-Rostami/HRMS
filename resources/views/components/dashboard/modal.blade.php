<div class="overflow-auto" x-show="showModal"
     :class="{ 'fixed main-background right-1 w-full h-full z-10 justify-center mx-auto': showModal }">

    <div :class="{ 'fixed mx-auto w-full md:right-0 md:left-0 md:w-1/2 z-20 flex-grow justify-center': showModal }">
        <!--Dialog-->
        <div class="main-background  @if(isDarkMode()) bg-[#1B232E] @else bg-[#F1F1F1] @endif
        border-modal modal w-11/12 mx-auto rounded shadow-lg py-4 text-left px-6"
             x-show="showModal" x-transition:enter="ease-out duration-1000"
             x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
            <!--Title-->
            <div class="flex justify-between items-center pb-3">
                <p class="text-2xl font-bold"><i class="fas fa-calendar-alt text-gray-600"></i></p>
                <div class="cursor-pointer z-50" @click="showModal = false">
                    <i class="fas fa-window-close text-gray-600" title="Close"></i>
                </div>
            </div>
            <!-- Reservation modal content -->
            <div x-show="showReserve">
                <form name="reserve-form" id="reserve-formw" method="post"
                      action="{{ route('reservations.store') }}"
                      autocomplete="false">
                    @csrf
                    <div class="mb-6 md:mb-12">
                        <x-label for="from-time" class="text-gray-600">From:</x-label>
                        <x-input id="from-time" class="input-from block mt-1 w-full from-time border-2"
                                 type="datetime" title="Click on start date" name="from-time" required>
                        </x-input>
                        <input type="hidden" name="from" id="from">
                    </div>
                    <div class="mb-6 md:mb-12">
                        <x-label for="to-time" class="text-gray-600">To:</x-label>
                        <x-input id="to-time" class="input-to block mt-1 w-full to-time border-2" autocomplete="false"
                                 type="datetime" title="Click on end date" name="to-time"
                                 autocomplete="chrome-off"
                                 required>
                        </x-input>
                        <input type="hidden" name="to" id="to">
                    </div>
                    <div class="mb-6 md:mb-12">
                        <x-label for="number" class="text-gray-600">Number:</x-label>
                        <select name="number" id="number" class="input-number block mt-1 w-full number-time border-2"
                                x-ref="number"
                                autocomplete="false" required>
                            <option class="hover:bg-gray-500" value="">Choose ...</option>
                            @foreach(listUntakenNumbers(url()->full()) as $each)
                                <option class="hover:bg-gray-500"
                                        value="{{$each->id}}">{{$each->number}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input class="time-duration hidden">
                    <!--Footer-->
                    <div class="flex justify-end pt-2">
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3" title="Reserve" type="submit">
                                <i class='far fa-calendar-check text-larger text-gray-300'></i>
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Suspension modal content -->
            @if( hasUserReserved() && isMultipleDays() )
                <div x-show="showSuspend">
                    <form name="reserve-form" id="reserve-formw" method="post" autocomplete="false"
                          action="{{ route('reservations.edit', (int) showReservationId())}}">
                        @csrf
                        <div class="mb-6 md:mb-12">
                            <x-label for="from-time-suspend" class="text-gray-300">From:</x-label>
                            <x-input id="from-time-suspend" class="input-from block mt-1 w-full from-time"
                                     type="datetime" title="Click on start date" name="from-time" required>
                            </x-input>
                            <input type="hidden" name="from" id="from-suspend">
                        </div>
                        <div class="mb-6 md:mb-12">
                            <x-label for="to-time-suspend" class="text-gray-300">To:</x-label>
                            <x-input id="to-time-suspend" class="input-to block mt-1 w-full to-time"
                                     autocomplete="false"
                                     type="datetime" title="Click on end date" name="to-time-suspend"
                                     autocomplete="chrome-off"
                                     required>
                            </x-input>
                            <input type="hidden" name="to" id="to-suspend">
                        </div>
                        <!--Footer-->
                        <div class="flex justify-end pt-2">
                            <div class="flex items-center justify-end mt-4">
                                <x-button class="ml-3" title="Suspend" type="submit">
                                    <i class='far fa-calendar-check text-larger text-gray-300'></i>
                                </x-button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
            <!-- Cancellation modal content -->
            @if( hasUserReserved())
                <div x-show="showCancel">
                    <form name="reserve-form" id="reserve-formw" method="post" autocomplete="false"
                          action="{{ route('reservations.update',(int) showReservationId())}}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-6 md:mb-12 mt-4">
                            <h4 class="main-color">
                                Are you sure you want to cancel your reservation of {{showReservationNumber()}}
                                on '{{ convertTheClickedDayIntoFarsi( session('day')) }}' ?
                            </h4>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3" title="Yap; I had the change of plan"
                                      type="submit">
                                <i class="fas fa-thumbs-up text-larger text-gray-300"></i>
                            </x-button>

                            <x-button class="ml-4" title="Oops! no please."
                                      @click="event.preventDefault();showModal = false">
                                <i class="fas fa-hand-paper text-larger text-gray-300"></i>
                            </x-button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>


