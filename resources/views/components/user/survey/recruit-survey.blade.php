<div class="md:p-4 md:ml-6">
    <form wire:submit.prevent="register">

        {{-- STEP 1 --}}
        @if ($currentStep == 1)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="1/15 steps">
                    <div class="gauge h-6 rounded-full" style="width: 7%"></div>
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
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="2/15 steps">
                    <div class="gauge h-6 rounded-full" style="width: 13%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label for="stars">
                        How informative or useful my first-day meeting was:
                    </label><br>

                    <fieldset class="stars text-center">
                        <span class="star-cb-group">
                          <input type="radio" id="rating-5" name="rating" value="5" title="5" wire:model="usefulness"
                                 wire:click="increase"/>
                            <label for="rating-5"></label>
                          <input type="radio" id="rating-4" name="rating" value="4" title="4" wire:model="usefulness"
                                 wire:click="increase"/>
                            <label for="rating-4"></label>
                          <input type="radio" id="rating-3" name="rating" value="3" title="3" wire:model="usefulness"
                                 wire:click="increase"/>
                            <label for="rating-3"></label>
                          <input type="radio" id="rating-2" name="rating" value="2" title="2" wire:model="usefulness"
                                 wire:click="increase"/>
                            <label for="rating-2"></label>
                          <input type="radio" id="rating-1" name="rating" value="1" title="1" wire:model="usefulness"
                                 wire:click="increase"/>
                            <label for="rating-1"></label>
                          <input type="radio" id="rating-0" name="rating" value="0" class="star-cb-clear"
                                 wire:model="usefulness"/>
                            <label for="rating-0">0</label>
                        </span>
                    </fieldset>
                    <span class="text-red-500 text-sm">@error('usefulness') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 3 --}}
        @if ($currentStep == 3)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="3/15 steps">
                    <div class="gauge h-6 rounded-full" style="width: 19%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label for="stars">
                        Considering the length of this meeting, how effectively information could be kept:
                    </label><br>

                    <fieldset class="stars text-center">
                        <span class="star-cb-group">
                          <input type="radio" id="rating-5" name="rating" value="5" title="5" wire:model="length"
                                 wire:click="increase"/>
                            <label for="rating-5"></label>
                          <input type="radio" id="rating-4" name="rating" value="4" title="4" wire:model="length"
                                 wire:click="increase"/>
                            <label for="rating-4"></label>
                          <input type="radio" id="rating-3" name="rating" value="3" title="3" wire:model="length"
                                 wire:click="increase"/>
                            <label for="rating-3"></label>
                          <input type="radio" id="rating-2" name="rating" value="2" title="2" wire:model="length"
                                 wire:click="increase"/>
                            <label for="rating-2"></label>
                          <input type="radio" id="rating-1" name="rating" value="1" title="1" wire:model="length"
                                 wire:click="increase"/>
                            <label for="rating-1"></label>
                          <input type="radio" id="rating-0" name="rating" value="0" class="star-cb-clear"
                                 wire:model="length"/>
                            <label for="rating-0">0</label>
                        </span>
                    </fieldset>
                    <span class="text-red-500 text-sm">@error('length') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 4 --}}
        @if ($currentStep == 4)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver-2">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="4/15 steps">
                    <div class="gauge h-6 rounded-full" style="width: 25%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label class="text-justify">
                        My understanding of the company, its leaders, and its departments:
                    </label><br>

                    <fieldset class="stars text-center">
                        <span class="star-cb-group">
                          <input type="radio" id="rating-5-team" name="rating" value="5" title="5"
                                 wire:model="staffInsight" wire:click="increase"/>
                            <label for="rating-5-team"></label>
                          <input type="radio" id="rating-4-team" name="rating" value="4" title="4"
                                 wire:model="staffInsight" wire:click="increase"/>
                            <label for="rating-4-team"></label>
                          <input type="radio" id="rating-3-team" name="rating" value="3" title="3"
                                 wire:model="staffInsight" wire:click="increase"/>
                            <label for="rating-3-team"></label>
                          <input type="radio" id="rating-2-team" name="rating" value="2" title="2"
                                 wire:model="staffInsight" wire:click="increase"/>
                            <label for="rating-2-team"></label>
                          <input type="radio" id="rating-1-team" name="rating" value="1" title="1"
                                 wire:model="staffInsight" wire:click="increase"/>
                            <label for="rating-1-team"></label>
                          <input type="radio" id="rating-0-team" name="rating" value="0" class="star-cb-clear"
                                 wire:model="staffInsight"/>
                            <label for="rating-0-team">0</label>
                        </span>
                    </fieldset>
                    <span class="text-red-500 text-sm">@error('staffInsight') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 5 --}}
        @if ($currentStep == 5)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="5/15 steps">
                    <div class="gauge h-6 rounded-full" style="width: 32%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        My understanding of Persol's products or services:
                    </label><br>

                    <fieldset class="stars text-center">
                        <span class="star-cb-group">
                          <input type="radio" id="rating-5-manager" name="rating" value="5" title="5"
                                 wire:model="productInsight" wire:click="increase"/>
                            <label for="rating-5-manager"></label>
                          <input type="radio" id="rating-4-manager" name="rating" value="4" title="4"
                                 wire:model="productInsight" wire:click="increase"/>
                            <label for="rating-4-manager"></label>
                          <input type="radio" id="rating-3-manager" name="rating" value="3" title="3"
                                 wire:model="productInsight" wire:click="increase"/>
                            <label for="rating-3-manager"></label>
                          <input type="radio" id="rating-2-manager" name="rating" value="2" title="2"
                                 wire:model="productInsight" wire:click="increase"/>
                            <label for="rating-2-manager"></label>
                          <input type="radio" id="rating-1-manager" name="rating" value="1" title="1"
                                 wire:model="productInsight" wire:click="increase"/>
                            <label for="rating-1-manager"></label>
                          <input type="radio" id="rating-0-manager" name="rating" value="0" class="star-cb-clear"
                                 wire:model="productInsight" wire:click="increase"/>
                            <label for="rating-0-manager">0</label>
                        </span>
                    </fieldset>

                    <span class="text-red-500 text-sm">@error('productInsight') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 6 --}}
        @if ($currentStep == 6)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver-2">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="6/15 steps">
                    <div class="gauge h-6 rounded-full" style="width: 38%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        Your understanding of PERSOL's payroll information:
                    </label><br>

                    <fieldset class="stars text-center">
                        <span class="star-cb-group">
                          <input type="radio" id="rating-5-company" name="rating" value="5" title="5"
                                 wire:model="infoInsight" wire:click="increase"/>
                            <label for="rating-5-company"></label>
                          <input type="radio" id="rating-4-company" name="rating" value="4" title="4"
                                 wire:model="infoInsight" wire:click="increase"/>
                            <label for="rating-4-company"></label>
                          <input type="radio" id="rating-3-company" name="rating" value="3" title="3"
                                 wire:model="infoInsight" wire:click="increase"/>
                            <label for="rating-3-company"></label>
                          <input type="radio" id="rating-2-company" name="rating" value="2" title="2"
                                 wire:model="infoInsight" wire:click="increase"/>
                            <label for="rating-2-company"></label>
                          <input type="radio" id="rating-1-company" name="rating" value="1" title="1"
                                 wire:model="infoInsight" wire:click="increase"/>
                            <label for="rating-1-company"></label>
                          <input type="radio" id="rating-0-company" name="rating" value="0" class="star-cb-clear"
                                 wire:model="infoInsight" wire:click="increase"/>
                            <label for="rating-0-company">0</label>
                        </span>
                    </fieldset>

                    <span class="text-red-500 text-sm">@error('infoInsight') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 7 --}}
        @if ($currentStep == 7)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="7/15 steps">
                    <div class="gauge h-6 rounded-full" style="width: 45%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        My understanding of PERSOL's IT support:
                    </label><br>

                    <fieldset class="stars text-center">
                        <span class="star-cb-group">
                          <input type="radio" id="rating-5-join" name="rating" value="5" title="5"
                                 wire:model="itInsight" wire:click="increase"/>
                            <label for="rating-5-join"></label>
                          <input type="radio" id="rating-4-join" name="rating" value="4" title="4"
                                 wire:model="itInsight" wire:click="increase"/>
                            <label for="rating-4-join"></label>
                          <input type="radio" id="rating-3-join" name="rating" value="3" title="3"
                                 wire:model="itInsight" wire:click="increase"/>
                            <label for="rating-3-join"></label>
                          <input type="radio" id="rating-2-join" name="rating" value="2" title="2"
                                 wire:model="itInsight" wire:click="increase"/>
                            <label for="rating-2-join"></label>
                          <input type="radio" id="rating-1-join" name="rating" value="1" title="1"
                                 wire:model="itInsight" wire:click="increase"/>
                            <label for="rating-1-join"></label>
                          <input type="radio" id="rating-0-join" name="rating" value="0" class="star-cb-clear"
                                 wire:model="itInsight" wire:click="increase"/>
                            <label for="rating-0-join">0</label>
                        </span>
                    </fieldset>

                    <span class="text-red-500 text-sm">@error('itInsight') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 8 --}}
        @if ($currentStep == 8)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver-2">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="8/15 steps">
                    <div class="gauge h-6 rounded-full" style="width: 52%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        How useful my interaction with other members of staff was:
                    </label><br>

                    <fieldset class="stars text-center">
                        <span class="star-cb-group">
                          <input type="radio" id="rating-5-newcomer" name="rating" value="5" title="5"
                                 wire:model="interaction" wire:click="increase"/>
                            <label for="rating-5-newcomer"></label>
                          <input type="radio" id="rating-4-newcomer" name="rating" value="4" title="4"
                                 wire:model="interaction" wire:click="increase"/>
                            <label for="rating-4-newcomer"></label>
                          <input type="radio" id="rating-3-newcomer" name="rating" value="3" title="3"
                                 wire:model="interaction" wire:click="increase"/>
                            <label for="rating-3-newcomer"></label>
                          <input type="radio" id="rating-2-newcomer" name="rating" value="2" title="2"
                                 wire:model="interaction" wire:click="increase"/>
                            <label for="rating-2-newcomer"></label>
                          <input type="radio" id="rating-1-newcomer" name="rating" value="1" title="1"
                                 wire:model="interaction" wire:click="increase"/>
                            <label for="rating-1-newcomer"></label>
                          <input type="radio" id="rating-0-newcomer" name="rating" value="0" class="star-cb-clear"
                                 wire:model="interaction" wire:click="increase"/>
                            <label for="rating-0-newcomer">0</label>
                        </span>
                    </fieldset>

                    <span class="text-red-500 text-sm">@error('interaction') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 9 --}}
        @if ($currentStep == 9)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="9/15 steps">
                    <div class="gauge h-6 rounded-full" style="width: 59%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        My understanding of Persol's culture and values:
                    </label><br>

                    <fieldset class="stars text-center">
                        <span class="star-cb-group">
                          <input type="radio" id="rating-5-buddy" name="rating" value="5" title="5" wire:model="culture"
                                 wire:click="increase"/>
                            <label for="rating-5-buddy"></label>
                          <input type="radio" id="rating-4-buddy" name="rating" value="4" title="4" wire:model="culture"
                                 wire:click="increase"/>
                            <label for="rating-4-buddy"></label>
                          <input type="radio" id="rating-3-buddy" name="rating" value="3" title="3" wire:model="culture"
                                 wire:click="increase"/>
                            <label for="rating-3-buddy"></label>
                          <input type="radio" id="rating-2-buddy" name="rating" value="2" title="2" wire:model="culture"
                                 wire:click="increase"/>
                            <label for="rating-2-buddy"></label>
                          <input type="radio" id="rating-1-buddy" name="rating" value="1" title="1" wire:model="culture"
                                 wire:click="increase"/>
                            <label for="rating-1-buddy"></label>
                          <input type="radio" id="rating-0-buddy" name="rating" value="0" class="star-cb-clear"
                                 wire:model="culture"/>
                            <label for="rating-0-buddy">0</label>
                        </span>
                    </fieldset>

                    <span class="text-red-500 text-sm">@error('culture') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif


        {{-- STEP 10 --}}
        @if ($currentStep == 10)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver-2">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="10/15 steps">
                    <div class="gauge h-6 rounded-full" style="width: 66%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        How pleasant my meeting experience was:
                    </label><br>

                    <fieldset class="stars text-center">
                        <span class="star-cb-group">
                          <input type="radio" id="rating-5-newcomer" name="rating" value="5" title="5"
                                 wire:model="experience" wire:click="increase"/>
                            <label for="rating-5-newcomer"></label>
                          <input type="radio" id="rating-4-newcomer" name="rating" value="4" title="4"
                                 wire:model="experience" wire:click="increase"/>
                            <label for="rating-4-newcomer"></label>
                          <input type="radio" id="rating-3-newcomer" name="rating" value="3" title="3"
                                 wire:model="experience" wire:click="increase"/>
                            <label for="rating-3-newcomer"></label>
                          <input type="radio" id="rating-2-newcomer" name="rating" value="2" title="2"
                                 wire:model="experience" wire:click="increase"/>
                            <label for="rating-2-newcomer"></label>
                          <input type="radio" id="rating-1-newcomer" name="rating" value="1" title="1"
                                 wire:model="experience" wire:click="increase"/>
                            <label for="rating-1-newcomer"></label>
                          <input type="radio" id="rating-0-newcomer" name="rating" value="0" class="star-cb-clear"
                                 wire:model="experience" wire:click="increase"/>
                            <label for="rating-0-newcomer">0</label>
                        </span>
                    </fieldset>

                    <span class="text-red-500 text-sm">@error('experience') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 11 --}}
        @if ($currentStep == 11)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="11/15 steps">
                    <div class="gauge h-6 rounded-full" style="width: 73%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        The likelihood of my recommending this meeting to others:
                    </label><br>

                    <fieldset class="stars text-center">
                        <span class="star-cb-group">
                          <input type="radio" id="rating-5-buddy" name="rating" value="5" title="5"
                                 wire:model="recommendation" wire:click="increase"/>
                            <label for="rating-5-buddy"></label>
                          <input type="radio" id="rating-4-buddy" name="rating" value="4" title="4"
                                 wire:model="recommendation" wire:click="increase"/>
                            <label for="rating-4-buddy"></label>
                          <input type="radio" id="rating-3-buddy" name="rating" value="3" title="3"
                                 wire:model="recommendation" wire:click="increase"/>
                            <label for="rating-3-buddy"></label>
                          <input type="radio" id="rating-2-buddy" name="rating" value="2" title="2"
                                 wire:model="recommendation" wire:click="increase"/>
                            <label for="rating-2-buddy"></label>
                          <input type="radio" id="rating-1-buddy" name="rating" value="1" title="1"
                                 wire:model="recommendation" wire:click="increase"/>
                            <label for="rating-1-buddy"></label>
                          <input type="radio" id="rating-0-buddy" name="rating" value="0" class="star-cb-clear"
                                 wire:model="recommendation"/>
                            <label for="rating-0-buddy">0</label>
                        </span>
                    </fieldset>

                    <span class="text-red-500 text-sm">@error('recommendation') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 12 --}}
        @if ($currentStep == 12)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver-2">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="12/15 steps">
                    <div class="gauge h-6 rounded-full" style="width: 79%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        Which part of the meeting was your most favorite?
                    </label><br>

                    <textarea class="mt-5 gauge-meter border border-gray-300 text-sm text-gray-700 rounded-lg focus:ring-gray-500 block w-full
                    focus:border-gray-500 p-2.5 dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                              id="mostFav" type="text"
                              placeholder="{{!empty($mostFav) ? $mostFav : 'write NONE even if you do not want to respond'}}"
                              wire:model="mostFav"> </textarea>


                    <span class="text-red-500 text-sm">@error('mostFav') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 13 --}}
        @if ($currentStep == 13)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="13/15 steps">
                    <div class="gauge h-6 rounded-full" style="width: 85%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        Which part of the meeting was your least favorite?
                    </label><br>

                    <textarea class="mt-5 gauge-meter border border-gray-300 text-sm text-gray-700 rounded-lg focus:ring-gray-500 block w-full
                    focus:border-gray-500 p-2.5 dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                              id="leastFav" type="text"
                              placeholder="{{!empty($leastFav) ? $leastFav : 'write NONE even if you do not want to respond'}}"
                              wire:model="leastFav"> </textarea>
                    <span class="text-red-500 text-sm">@error('leastFav') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 14 --}}
        @if ($currentStep == 14)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver-2">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="14/15 steps">
                    <div class="gauge h-6 rounded-full" style="width: 92%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        What would you like to see added to this meeting?
                    </label><br>
                    <textarea class="mt-5 gauge-meter border border-gray-300 text-sm text-gray-700 rounded-lg focus:ring-gray-500 block w-full
                    focus:border-gray-500 p-2.5 dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                              id="addition" type="text"
                              placeholder="{{!empty($addition) ? $addition : 'write NONE even if you do not want to respond'}}"
                              wire:model="addition"> </textarea>


                    <span class="text-red-500 text-sm">@error('addition') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 15 --}}
        @if ($currentStep == 15)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver-2">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="15/15 steps">
                    <div class="gauge h-6 rounded-full" style="width: 100%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        What suggestions would like to make?
                    </label><br>
                    <textarea class="mt-5 gauge-meter border border-gray-300 text-sm text-gray-700 rounded-lg focus:ring-gray-500 block w-full
                    focus:border-gray-500 p-2.5 dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                              id="suggestion" type="text"
                              placeholder="{{!empty($suggestion) ? $suggestion : 'write NONE even if you do not want to respond'}}"
                              wire:model="suggestion"> </textarea>


                    <span class="text-red-500 text-sm">@error('suggestion') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        <div
            class="survey-submit text-center mx-auto justify-content-between w-1/2 bg-gray-300 @if ( isDarkMode())  bg-main @endif pt-2 pb-2 rounded">
            @if ($currentStep > 1)
                <button type="button" class="border-r-2 p-2 text-center" wire:click="decrease"
                        title="{{ $previousStep }}">
                    <i class="fa fa-arrow-circle-left"></i>
                </button>
            @endif

            @if ($currentStep < 15)
                <button type="button" wire:click="increase" title="{{ $nextStep }}">
                    <i class="fa fa-arrow-circle-right"></i>
                </button>
            @endif

            @if ($currentStep == 15 && !empty($suggestion) && !empty($addition) )
                <button type="submit" title="Submit">
                    <i class="fas fa-check-circle"></i>
                </button>
            @endif
        </div>
    </form>
</div>
