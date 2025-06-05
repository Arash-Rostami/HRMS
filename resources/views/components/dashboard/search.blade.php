<div class="flex">
    <!-- The overlay -->
    <div id="myNav" class="overlay-search">
        <!-- Button to close the overlay navigation -->
        <span class="closebtn cursor-pointer" @click="Search.closeNav()">&times;</span>
        <!-- Overlay content -->
        <div class="overlay-search-content">
            <div>
                <x-input class="block mx-auto mt-1 w-1/2 md:w-1/5 inline-block"
                         type="search" name="search" id="search" placeholder="type name or number in English" autofocus>
                </x-input>

                <x-input class="block mx-auto mt-1 w-1/8 md:w-20 inline-block"
                         type="number" id="day" min="1" max="31" placeholder="day">
                </x-input>

                <x-button class="mt-3 inline-block relative top-1" title="Search" id="find" @click="Search.send()">
                    <i class="fas fa-search text-larger text-gray-300 "></i>
                </x-button>
                <!-- Show all users -->
                <x-button class="mt-3 inline-block relative top-1" title="List all users of today" id="find"
                          @click="Search.list()">
                    <i class="fas fa-list-ol text-larger text-gray-500 "></i>
                </x-button>
            </div>
            <div class="flex flex-wrap">
                <div class="w-1/3"></div>
                <div id="result" class="text-left ml-auto mr-auto cursor-pointer"></div>
                <div class="w-1/3"></div>
            </div>
        </div>
    </div>
</div>
