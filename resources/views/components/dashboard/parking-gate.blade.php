<div class="flex">
{{--    <img class="w-8 md:w-14 mx-6 md:mx-20 rotate-1" alt="park-sign" src="/img/off-rail.png"--}}
{{--         x-init="setInterval(()=>{$el.src=($el.src.includes('on'))?'/img/off-rail.png': '/img/on-rail.png'}, 2000)">--}}
<!-- The overlay -->
    <div id="myNav" class="overlay" x-data>
        <!-- Button to close the overlay navigation -->
        <span class="closebtn cursor-pointer" @click="Search.closeNav()">&times;</span>
        <!-- Overlay content -->
        <div class="overlay-content">
            <div>
                <x-label class="main-color" for="email" value="Who?"/>
                <x-input class="block mx-auto mt-1 w-1/2 md:w-1/5 inline-block"
                         type="search" name="search" id="search" placeholder="type name in English" autofocus>
                </x-input>

                <x-input class="block mx-auto mt-1 w-1/8 md:w-20 inline-block"
                         type="number" id="day" min="1" max="31" placeholder="day">
                </x-input>

                <x-button class="mt-3 inline-block relative top-1" title="Search" id="find" @click="Search.send()">
                    <i class="fas fa-search text-larger text-gray-300 "></i>
                </x-button>
            </div>
            <div id="result"></div>
        </div>
    </div>
</div>
