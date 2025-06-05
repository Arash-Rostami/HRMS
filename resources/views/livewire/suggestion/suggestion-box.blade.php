<div class="w-full md:w-3/4 my-10 mx-auto rounded-lg animate-[fade-in-down_1s_ease-in-out]"
     x-show="suggestionBox"
     x-transition:leave="transition ease-in duration-500"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div class="w-full h-11 rounded-t-lg bg-gray-200 @if(isDarkMode()) bg-main @endif flex items-center">
        <span class="w-3 h-3 rounded-full bg-red-400 mr-3 ml-1"></span>
        <span class="w-3 h-3 rounded-full bg-yellow-400 mx-1"></span>
        <span class="w-3 h-3 rounded-full bg-green-400 mx-1"></span>
        <span class="mr-auto ml-4 text-gray-500 cursor-pointer"
              @click="suggestionBox = false">
            <i class="fas fa-times"></i>
        </span>
    </div>
    <div
        class="bg-gray-300 @if(isDarkMode()) bg-gray-600 @endif border-t-0 w-full h-auto text-gray-900 p-8">
        {{--timestamp--}}
        <div class="ltr-direction text-right">
            <small x-text="selectedRecord.created_at"></small> <i class="fa fa-clock"></i>
            <br>
        </div>
        {{--rules--}}
        <div class="flex flex-row flex-wrap">
            <template x-for="rule in selectedRecord.rule">
                <div class="bg-gray-200 @if(isDarkMode()) bg-main @endif text-gray-500 px-4 py-1 my-2 mx-4 rounded"
                     x-text="rules[rule]"></div>
            </template>
        </div>
        {{--purposes--}}
        <div class="flex flex-row flex-wrap">
            <template x-for="purpose in selectedRecord.purpose">
                <div class="bg-gray-200 @if(isDarkMode()) bg-main @endif px-4 py-1 my-2 mx-4 rounded main-color"
                     x-text="purposes[purpose]"></div>
            </template>
        </div>
        {{--departments--}}
        <div class="flex flex-row flex-wrap">
            <i class="fa fa-link cursor-pointer" title="ذی نفعان"></i>
            <template x-for="department in JSON.parse(selectedRecord.department)">
                <div class="bg-gray-200 @if(isDarkMode()) bg-main @endif px-4 py-1 my-2 mx-4 rounded text-amber-500"
                     x-text="allDepsSelected[department]"></div>
            </template>
        </div>
        {{--title--}}
        <div class="flex flex-row flex-wrap">
            <i class="fas fa-comment text-sm ml-2"></i>
            <h2 class="text-lg font-bold" x-text="selectedRecord.title"></h2>
            <h2 class="text-lg font-bold" x-text="feedbackResponse[selectedRecord.feedback]"></h2>
        </div>
        {{--description--}}
        <div class="md:p-4 text-justify text-black">
            <p x-ref="description" x-text="selectedRecord.description || selectedRecord.comments"></p>
        </div>
        {{--department--}}
        <div class="flex flex-row flex-wrap md:p-4">
            <p x-text="selectedRecord.dep"></p>
            <p x-show="!selectedRecord.hasOwnProperty('dep')"
               x-text="selectedRecord.department"></p>
        </div>
    </div>
</div>
