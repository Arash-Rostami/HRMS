<div class="flex flex-grow">
    <x-dashboard.office-corner/>
    <div class="flex flex-row flex-grow">
        @inject("seats", "App\Models\Seat")
        @foreach($seats->getFromTo(0,6) as $seat)
            <x-dashboard.vertical-office-top :desk="$seat"/>
        @endforeach
    </div>
    <x-dashboard.office-corner/>
</div>
