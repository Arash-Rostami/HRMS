<div class="flex flex-grow">
    <x-dashboard.parking-corner/>
    <div class="flex flex-row flex-grow">
        @for($i=100; $i<108;$i++)
            <x-dashboard.vertical-space-top :number="$i"/>
        @endfor
    </div>
    <x-dashboard.parking-corner/>
</div>
