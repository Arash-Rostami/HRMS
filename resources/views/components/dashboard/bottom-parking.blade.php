<div class="flex flex-grow">
    <x-dashboard.parking-corner/>
    <div class="flex flex-row flex-grow">
        @for($i=333; $i<341;$i++)
            <x-dashboard.vertical-space-bottom :number="$i"/>
        @endfor
    </div>
    <x-dashboard.parking-corner/>
</div>
