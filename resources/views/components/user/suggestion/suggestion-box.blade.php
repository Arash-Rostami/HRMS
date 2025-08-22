<div
    dir="rtl"
    x-show="suggestionBox"
    class="fixed inset-0 flex items-center justify-center z-[999] persol-farsi-font backdrop-blur-sm animate-[fade-in_0.3s_both]"
    @click="suggestionBox = false">
    <div class="w-full md:w-2/3 max-h-[90vh] overflow-y-auto rounded-lg  shadow-lg "
         x-show="suggestionBox">
        <!-- Header -->
        <div @class([
                'w-full h-11 rounded-t-lg flex items-center',
                'bg-gray-200' => !isDarkMode(),
                'bg-main' => isDarkMode(),
            ])>
            <span class="w-3 h-3 rounded-full bg-red-400 mr-3 ml-1"></span>
            <span class="w-3 h-3 rounded-full bg-yellow-400 mx-1"></span>
            <span class="w-3 h-3 rounded-full bg-green-400 mx-1"></span>
            <span class="mr-auto ml-4 text-gray-500 hover:text-red-500 transition-colors duration-300 cursor-pointer"
                  @click="suggestionBox = false">
                <i class="fas fa-times"></i>
            </span>
        </div>
        <!-- Content -->
        <div @class([
                    'border-t-0 w-full h-auto p-8',
                    'bg-gray-300' => !isDarkMode(),
                    'bg-gray-600' => isDarkMode(),
                ])>
            {{--timestamp--}}
            <div class="ltr-direction text-right">
                <small x-text="selectedRecord.created_at"></small> <i class="fa fa-clock"></i>
                <br>
            </div>
            {{--rules--}}
            <div class="flex flex-row flex-wrap">
                <template x-for="rule in selectedRecord.rule">
                    <div class="bg-gray-200 @if(isDarkMode()) bg-main @endif px-4 py-1 my-2 mx-4 rounded"
                         x-text="rules[rule]"></div>
                </template>
            </div>
            {{--purposes--}}
            <div class="flex flex-row flex-wrap">
                <template x-for="purpose in selectedRecord.purpose">
                    <div class="bg-gray-200 @if(isDarkMode()) bg-main @endif px-4 py-1 my-2 mx-4 rounded"
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
            <div class="flex flex-row flex-wrap text-black">
                <i class="fas fa-comment text-sm ml-2"></i>
                <h2 class="text-lg font-bold" x-text="selectedRecord.title"></h2>
                <h2 class="text-lg font-bold" x-text="feedbackResponse[selectedRecord.feedback]"></h2>
            </div>
            {{--description--}}
            <div class="md:p-4 text-justify text-black animate-none">
                <p style="animation:none!important;" x-ref="description"
                   x-text="selectedRecord.description || selectedRecord.comments"></p>
            </div>
            {{--department--}}
            <div class="flex flex-row flex-wrap md:p-4 text-black">
                <p x-text="selectedRecord.dep"></p>
                <p x-show="!selectedRecord.hasOwnProperty('dep')" x-text="selectedRecord.department"></p>
            </div>
        </div>
    </div>
</div>
