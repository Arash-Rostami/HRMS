<div class="md:p-4 md:ml-6">
    <form wire:submit.prevent="register">


        {{-- STEP 1 --}}
        @if ($currentStep == 1)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter w-full h-6 rounded-full" title="1/9 steps">
                    <div class="gauge h-6 rounded-full" style="width: 11%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label for="names">
                        First, enter your first and last names:
                    </label><br>
                    <input class="gauge-meter border border-gray-300 text-sm text-gray-700 rounded-lg focus:ring-gray-500 block w-full
                    focus:border-gray-500 p-2.5 dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                           id="names" type="text" placeholder="{{$names}}" wire:model="names" required>
                    <span class="text-red-500 text-sm">@error('names') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 2 --}}
        @if ($currentStep == 2)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver-2">
                <div class="gauge-meter w-full h-6 rounded-full" title="2/9 steps">
                    <div class="gauge h-6 rounded-full" style="width: 22%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label for="radio">
                        Is this a one-person offer or a team-backed one?
                    </label><br>

                    <div class="flex flex-wrap justify-center p-2.5">
                        <div class="flex items-center mr-4">
                            <input id="red-radio" type="radio" value="1" wire:model="presenter" name="colored-radio" wire:click="increase"
                                   class="gauge-meter w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500 dark:focus:green-600 dark:ring-offset-gray-800 focus:ring-2">
                            <label for="red-radio" class="ml-2">One person</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="yellow-radio" type="radio" value="2" wire:model="presenter" name="colored-radio" wire:click="increase"
                                   class="gauge-meter w-4 h-4 text-yellow-400 border-gray-300 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2">
                            <label for="yellow-radio" class="ml-2">More than one</label>
                        </div>
                        <span class="text-red-500 text-sm">@error('presenter') * {{ $message }}@enderror</span>

                    </div>

                </div>
            </div>
        @endif

        {{-- STEP 3 --}}
        @if ($currentStep == 3)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter w-full h-6 rounded-full" title="3/9 steps">
                    <div class="gauge h-6 rounded-full" style="width: 33%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label for="stars">
                        To how many people this offer applies?
                    </label><br>

                    <div class="flex flex-wrap justify-center p-2.5">
                        <div class="flex items-center mr-4">
                            <input id="red-radio" type="radio" value="1" wire:model="scopes" name="colored-radio" wire:click="increase"
                                   class="gauge-meter w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500 dark:focus:green-600 dark:ring-offset-gray-800 focus:ring-2">
                            <label for="red-radio" class="ml-2">One or some </label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="yellow-radio" type="radio" value="2" wire:model="scopes" name="colored-radio" wire:click="increase"
                                   class="gauge-meter w-4 h-4 text-yellow-400 border-gray-300 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2">
                            <label for="yellow-radio" class="ml-2">Everyone</label>
                        </div>
                        <span class="text-red-500 text-sm">@error('scopes') * {{ $message }}@enderror</span>
                    </div>
                </div>
            </div>
        @endif

        {{-- STEP 4 --}}
        @if ($currentStep == 4)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver-2">
                <div class="gauge-meter w-full h-6 rounded-full" title="4/9 steps">
                    <div class="gauge h-6 rounded-full" style="width: 44%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label for="names">
                        Please choose a name or title for your suggestion:
                    </label><br>
                    <div class="flex items-center mr-4 py-4">
                        <input class="gauge-meter border border-gray-300 text-sm text-gray-700 rounded-lg focus:ring-gray-500 block w-full
                    focus:border-gray-500 p-2.5 dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                               id="names" type="text" placeholder="{{$title}}" wire:model="title" required>
                        <span class="text-red-500 text-sm">@error('title') * {{ $message }}@enderror</span>
                    </div>
                </div>
            </div>
        @endif

        {{-- STEP 5 --}}
        @if ($currentStep == 5)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter w-full h-6 rounded-full" title="5/9 steps">
                    <div class="gauge h-6 rounded-full" style="width: 55%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        Can you describe your suggestion in detail?
                    </label><br>

                    <textarea class="mt-5 gauge-meter border border-gray-300 text-sm text-gray-700 rounded-lg focus:ring-gray-500 block w-full
                    focus:border-gray-500 p-2.5 dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                              id="improvement" type="text" placeholder="{{$suggestion}}"
                              wire:model="suggestion"> </textarea>
                    <span class="text-red-500 text-sm">@error('suggestion') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 6 --}}
        @if ($currentStep == 6)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver-2">
                <div class="gauge-meter w-full h-6 rounded-full" title="6/9 steps">
                    <div class="gauge h-6 rounded-full" style="width: 66%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        Can you say which shortcomings, problems or obstacles this suggestion can remove or
                        what benefits will it bring us?
                    </label><br>

                    <textarea class="mt-5 gauge-meter border border-gray-300 text-sm text-gray-700 rounded-lg focus:ring-gray-500 block w-full
                    focus:border-gray-500 p-2.5 dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                              id="improvement" type="text" placeholder="{{$advantage}}"
                              wire:model="advantage"> </textarea>
                    <span class="text-red-500 text-sm">@error('advantage') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 7 --}}
        @if ($currentStep == 7)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter w-full h-6 rounded-full" title="7/9 steps">
                    <div class="gauge h-6 rounded-full" style="width: 77%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        Can you say more about the implementation methods, schedule, and facilities
                        necessary for this suggestion?
                    </label><br>

                    <textarea class="mt-5 gauge-meter border border-gray-300 text-sm text-gray-700 rounded-lg focus:ring-gray-500 block w-full
                    focus:border-gray-500 p-2.5 dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                              id="improvement" type="text" placeholder="{{$method}}"
                              wire:model="method"> </textarea>
                    <span class="text-red-500 text-sm">@error('method') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 8 --}}
        @if ($currentStep == 8)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver-2">
                <div class="gauge-meter w-full h-6 rounded-full" title="8/9 steps">
                    <div class="gauge h-6 rounded-full" style="width: 88%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label for="radio">
                        Do you have any financial estimate for this suggestion?
                    </label><br>

                    <div class="flex flex-wrap justify-center p-2.5">
                        <div class="flex items-center mr-4">
                            <input id="red-radio" type="radio" value="1" wire:model="estimation" name="colored-radio" wire:click="increase"
                                   class="gauge-meter w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500 dark:focus:green-600 dark:ring-offset-gray-800 focus:ring-2">
                            <label for="red-radio" class="ml-2">Yes :)</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="yellow-radio" type="radio" value="0" wire:model="estimation" name="colored-radio" wire:click="increase"
                                   class="gauge-meter w-4 h-4 text-red-400 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2">
                            <label for="yellow-radio" class="ml-2">No :(</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="yellow-radio" type="radio" value="2" wire:model="estimation" name="colored-radio" wire:click="increase"
                                   class="gauge-meter w-4 h-4 text-yellow-400 border-gray-300 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2">
                            <label for="yellow-radio" class="ml-2">It's free</label>
                        </div>
                        @if ($estimation == 1)
                            <div class="mt-6 text-justify max-w-xs">
                                <label for="names">
                                    Please include a price:
                                </label><br>
                                <input class="gauge-meter border border-gray-300 text-sm text-gray-700 rounded-lg focus:ring-gray-500 block w-full
                                     focus:border-gray-500 p-2.5 dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                       id="names" type="text" placeholder="{{$estimate}}" wire:model="estimate"
                                       required>
                                <span class="text-red-500 text-sm">@error('estimate') * {{ $message }}@enderror</span>
                            </div>
                        @endif
                        <span class="text-red-500 text-sm">@error('estimation') * {{ $message }}@enderror</span>
                    </div>

                </div>
            </div>
        @endif

        {{-- STEP 9 --}}
        @if ($currentStep == 9)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter w-full h-6 rounded-full" title="9/9 steps">
                    <div class="gauge h-6 rounded-full" style="width: 100%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        Do you want to provide a file --photo or document-- related to your suggestion?
                    </label><br>
                    <div class="flex items-center mr-4 justify-center w-full p-4">
                        <label for="dropzone-file"
                               class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg aria-hidden="true" class="w-8 h-8 mb-3 text-gray-400 main-color" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="text-sm text-gray-500 dark:text-gray-400 px-4">
                                    <span class="font-semibold">Click to upload</span>
                                    or drag & drop
                                </p>
                                <hr>
                                <p class="text-xs hidden md:inline text-gray-500 dark:text-gray-400 px-4">
                                    SVG, PNG, JPG or GIF (MAX. 800x400px)
                                </p>
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" wire:model="photo"/>
                        </label>
                    </div>
                    <span class="text-red-500 text-sm">@error('photo') * {{ $message }} @enderror</span>

                </div>
            </div>
        @endif


        <div class="text-center mx-auto justify-content-between w-1/2 bg-main pt-2 pb-2 rounded">
            @if ($currentStep > 1)
                <button type="button" class="border-r-2 p-2 text-center" wire:click="decrease" title="{{ $previousStep }}">
                    <i class="fa fa-arrow-circle-left"></i>
                </button>
            @endif

            @if ($currentStep < 9)
                <button type="button" wire:click="increase" title="{{ $nextStep }}">
                    <i class="fa fa-arrow-circle-right"></i>
                </button>
            @endif

            @if ($currentStep == 9)
                <button type="submit" title="Submit">
                    <i class="fas fa-check-circle"></i>
                </button>
            @endif
        </div>

    </form>
</div>
