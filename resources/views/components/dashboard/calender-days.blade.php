@foreach( listWeekDays() as $day)
    {{--load from Table.js--}}
    <div x-init="Table.listDays()">
        <div class="flex mb-4 md:mb-1 flex-col md:p-2 reservation-calender cursor-pointer rounded days"
             @click="window.location='reservations/'+$el.dataset.date" data-date=""
             :class="{'alert-box' : $el.dataset.date == {{ session('day') ?? 0}}}">
            <div class="flex self-center mx-2 md:relative md:top-12 md:text-base">{{ shorten($day) }}</div>
            <div class="flex self-center mx-2"><i class="far fa-calendar text-xl md:text-6xl"></i></div>
            <div class="flex self-center mx-2 date"></div>
        </div>
    </div>
@endforeach
