<div class="flex flex-grow">
    @inject("seats", "App\Models\Seat")
    <x-dashboard.office-corner/>
    <div class="flex flex-row flex-grow">
        @foreach($seats->getFromTo(6,6) as $seat)
            <x-dashboard.vertical-office-bottom :desk="$seat"/>
        @endforeach
    </div>
    <x-dashboard.office-corner/>
</div>
