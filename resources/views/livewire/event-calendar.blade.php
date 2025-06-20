<div
    x-data="{openToast: false, toastMessage:'SMS sent successfully :)',openModal: @entangle('isConfirmModalOpen'), receptor: @entangle('receptor'),event: @entangle('selectedEventType')}">
    <div class="flex flex-col-reverse md:flex-row mx-auto text-sm md:text-base">
        {{--    Events chart--}}
        <div id="events" class="flex flex-col mt-5 md:mt-0 md:w-[30%] md:mr-2 max-h-[350px] overflow-y-scroll shadow-2xl h-2/3 p-[10px] rounded-[5px]"
             wire:init="loadEvents()">
            <div class="force-overflow text-center">
                @if($selectedDayEvents)
                    <div class="text-left">
                    <span class="text-sm text-left opacity-80">
                        {{ makeDoubleDigit($day) }}
                         <span class="text-main">|</span>
                        {{ makeDoubleDigit($currentMonth) }}
                         <span class="text-main">|</span>
                        {{ $currentYear }}
                    </span>
                    </div>
                    @php
                        $totalEvents = array_sum([
                            count($selectedDayEvents['birthDates']),count($selectedDayEvents['startDates']), count($selectedDayEvents['otherEvents']),
                        ]);
                    @endphp
                    @if($totalEvents == 0)
                        <div class="py-2 px-4 mb-2 rounded-lg  links-thumbnails links-thumbnails-color">
                            <span>📭 No events for this day :(</span>
                        </div>
                    @else
                        @foreach(['birthDates' => 'Birthday 🎂', 'startDates' => 'Anniversary 🥂', 'otherEvents' => 'Events 📅'] as $eventType => $title)
                            @if(count($selectedDayEvents[$eventType]) > 0)
                                <h1 class="mb-2">{{ $title }}</h1>
                                @foreach($selectedDayEvents[$eventType] as $event)
                                    <div class="py-2 px-4 mb-2 rounded-lg bg-main-mode text-left">
                                        <span>
                                            {{ $eventType == 'otherEvents'
                                                                ? ($event['title'] .': ' .$event['description'])
                                                                : $event['user']['forename'] . ' ' . $event['user']['surname'] }}
                                        </span>
                                        {{-- message is not sent once or is purely for birthday or start of date--}}
                                        @unless($eventType == 'otherEvents')
                                            @if($messageAbility && !$smsSentStatus[$event['cellphone']] )
                                                <span class="float-right cursor-pointer"
                                                      title="Want to send a congratulatory SMS to this person? 📲"
                                                      @click=" openModal = true;  receptor ='{{ $event['cellphone'] }}'; event ='{{ $eventType }}';">
                                            <i class="fas fa-envelope main-color-reverse"></i>
                                            </span>
                                            @endif
                                        @endunless
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                @endif
            </div>
        </div>

        {{-- Calender chart--}}
        <div class="flex flex-col md:w-[65%] md:ml-2 mb-2">
            <div id="calendar-container">
                <div id="calendar" class="grid grid-cols-7">
                    {{-- Weekday Headers --}}
                    @foreach($persianWeekdayNames as $day)
                        <div class="text-center text-white p-2 bg-main-mode rounded mx-1 mb-2  links-thumbnails links-thumbnails-color">
                            {{ $day }}
                        </div>
                    @endforeach
                    {{-- Empty Day Cells (for month start alignment) --}}
                    @foreach($emptyDays as $emptyDay)
                        <div class="day empty"></div>
                    @endforeach

                    {{-- Calendar Day Cells --}}
                    @foreach($calendarData as $dayData)
                        <div class="day h-14 rounded-lg flex items-center justify-center
                        links-thumbnails links-thumbnails-color transition-all duration-200 ease-in-out
                        @if(isWeekend($currentYear, $currentMonth, $dayData['day'])) bg-weekend @endif
                        @if($dayData['isCurrentDay']) bg-main-mode flash-calendar @endif">

                <span class="w-full h-full flex flex-col items-center justify-center cursor-pointer"
                      wire:click="loadEvents('{{ $dayData['day'] }}')">
                    <span>{{ $dayData['day'] }}</span>
                    {{-- Event Icons --}}
                    <div class="flex space-x-1 mt-1 shadow-lg">
                        @foreach(['startDates' => 'anniversary', 'birthDates' => 'birthday', 'otherEvents' => 'events'] as $eventType => $iconType)
                            @if(count($dayData[$eventType]) > 0)
                                <span title="{{ ucfirst($iconType) }} Events">
                                    {{ $eventIcons[$iconType] }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                </span>
                        </div>
                    @endforeach
                </div>
            </div>
            {{--        buttons --}}
            <div class="buttons flex justify-around md:justify-between items-center mt-2"
                 x-ignore>
                <button wire:click="navigateToPreviousMonth"
                        class="float-left bg-main-mode px-3 py-1 shadow-lg rounded text-white hover:opacity-75">
                    <span> « </span>
                </button>
                <div id="currentMonth">{{ $persianMonthIcons[$currentMonth-1] }} {{ makeDoubleDigit($currentMonth) }}
                    <span class="text-main">|</span>
                    {{$currentYear}}
                </div>
                <button wire:click="navigateToNextMonth"
                        class="float-right bg-main-mode px-3 py-1 shadow-lg rounded text-white hover:opacity-75">
                    <span> » </span>
                </button>
            </div>
        </div>
    </div>

    {{--    Confirm modal--}}
    <div class="absolute bottom-0 left-0 right-0 top-0 bg-opacity-75 flex justify-center items-center"
         x-show="openModal"
         x-transition
         @click.outside="openModal = false">
        <div class="bg-white  @if ( isDarkMode()) bg-[#1F2937] @endif shadow-2xl w-1/2 rounded-md p-4">
            <p class="text-center text-gray-400">Are you sure to send a congratulatory SMS to this person?</p>
            <div class="mt-4 flex justify-center space-x-4">
                <button
                    class="bg-red-500 text-white px-2 py-1 rounded-md" @click="openModal = false">No :(
                </button>
                <button
                    class="bg-green-500 text-white px-2 py-1 rounded-md"
                    @click="openModal = false; $wire.sendSMS()"
                    @open-toast.window="openToast = true; setTimeout(() => openToast = false, 5000)">Yes :)
                </button>
            </div>
        </div>
    </div>

    {{--    Success message toast--}}
    <div class="absolute ignore-elements top-1 right-2 rounded" x-show="openToast">
        <div class="bg-main-mode max-w-xs text-gray-800 rounded-lg px-4 py-2 slide-in-top">
            <div class="cursor-pointer z-50 float-right ">
                <i class="fas fa-window-close text-gray-900" title="Close"></i>
            </div>
            <br>
            <span x-text="toastMessage"></span>
        </div>
    </div>
</div>

