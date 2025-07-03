<div class="md:p-4 md:ml-6">
    <form wire:submit.prevent="register">

        {{-- STEP 1 --}}
        @if ($currentStep == 1)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="1/14 steps">
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
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="2/14 steps">
                    <div class="gauge h-6 rounded-full" style="width: 14%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label for="radio">
                        For how many days you have been in PERSOL?
                    </label><br>

                    <div class="flex flex-wrap justify-center p-2.5">
                        <div class="flex items-center mr-4">
                            <input id="red-radio" type="radio" value="30" wire:model="days" name="colored-radio" wire:click="increase"
                                   class="gauge-meter w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2">
                            <label for="red-radio" class="ml-2 survey-days">30 days</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="yellow-radio" type="radio" value="60" wire:model="days" name="colored-radio" wire:click="increase"
                                   class="gauge-meter w-4 h-4 text-yellow-400 border-gray-300 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2">
                            <label for="yellow-radio" class="ml-2 survey-days">60 days</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="green-radio" type="radio" value="90" wire:model="days" name="colored-radio" wire:click="increase"
                                   class="gauge-meter w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2">
                            <label for="green-radio" class="ml-2 survey-days">90 days</label>
                        </div>
                        <span class="text-red-500 text-sm">@error('days') * {{ $message }}@enderror</span>

                    </div>

                </div>
            </div>
        @endif

        {{-- STEP 3 --}}
        @if ($currentStep == 3)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="3/14 steps">
                    <div class="gauge h-6 rounded-full" style="width: 21%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label for="stars">
                        The resources available in the onboarding stage:
                    </label><br>

                    <fieldset class="stars text-center">
                        <span class="star-cb-group">
                          <input type="radio" id="rating-5" name="rating" value="5" title="5" wire:model="resource" wire:click="increase"/>
                            <label for="rating-5"></label>
                          <input type="radio" id="rating-4" name="rating" value="4" title="4" wire:model="resource" wire:click="increase"/>
                            <label for="rating-4"></label>
                          <input type="radio" id="rating-3" name="rating" value="3" title="3" wire:model="resource" wire:click="increase"/>
                            <label for="rating-3"></label>
                          <input type="radio" id="rating-2" name="rating" value="2" title="2" wire:model="resource" wire:click="increase"/>
                            <label for="rating-2"></label>
                          <input type="radio" id="rating-1" name="rating" value="1" title="1" wire:model="resource" wire:click="increase"/>
                            <label for="rating-1"></label>
                          <input type="radio" id="rating-0" name="rating" value="0" class="star-cb-clear"
                                 wire:model="resource"/>
                            <label for="rating-0">0</label>
                        </span>
                    </fieldset>
                    <span class="text-red-500 text-sm">@error('resource') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 4 --}}
        @if ($currentStep == 4)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver-2">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="4/14 steps">
                    <div class="gauge h-6 rounded-full" style="width: 28%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label class="text-justify">
                        The role of your team in your own success:
                    </label><br>

                    <fieldset class="stars text-center">
                        <span class="star-cb-group">
                          <input type="radio" id="rating-5-team" name="rating" value="5" title="5" wire:model="team" wire:click="increase"/>
                            <label for="rating-5-team"></label>
                          <input type="radio" id="rating-4-team" name="rating" value="4" title="4" wire:model="team" wire:click="increase"/>
                            <label for="rating-4-team"></label>
                          <input type="radio" id="rating-3-team" name="rating" value="3" title="3" wire:model="team" wire:click="increase"/>
                            <label for="rating-3-team"></label>
                          <input type="radio" id="rating-2-team" name="rating" value="2" title="2" wire:model="team" wire:click="increase"/>
                            <label for="rating-2-team"></label>
                          <input type="radio" id="rating-1-team" name="rating" value="1" title="1" wire:model="team" wire:click="increase"/>
                            <label for="rating-1-team"></label>
                          <input type="radio" id="rating-0-team" name="rating" value="0" class="star-cb-clear"
                                 wire:model="team"/>
                            <label for="rating-0-team">0</label>
                        </span>
                    </fieldset>
                    <span class="text-red-500 text-sm">@error('team') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 5 --}}
        @if ($currentStep == 5)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="5/14 steps">
                    <div class="gauge h-6 rounded-full" style="width: 35%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        The role of your manager/senior in defining your responsibilities:
                    </label><br>

                    <fieldset class="stars text-center">
                        <span class="star-cb-group">
                          <input type="radio" id="rating-5-manager" name="rating" value="5" title="5"
                                 wire:model="manager" wire:click="increase"/>
                            <label for="rating-5-manager"></label>
                          <input type="radio" id="rating-4-manager" name="rating" value="4" title="4"
                                 wire:model="manager" wire:click="increase"/>
                            <label for="rating-4-manager"></label>
                          <input type="radio" id="rating-3-manager" name="rating" value="3" title="3"
                                 wire:model="manager" wire:click="increase"/>
                            <label for="rating-3-manager"></label>
                          <input type="radio" id="rating-2-manager" name="rating" value="2" title="2"
                                 wire:model="manager" wire:click="increase"/>
                            <label for="rating-2-manager"></label>
                          <input type="radio" id="rating-1-manager" name="rating" value="1" title="1"
                                 wire:model="manager" wire:click="increase"/>
                            <label for="rating-1-manager"></label>
                          <input type="radio" id="rating-0-manager" name="rating" value="0" class="star-cb-clear"
                                 wire:model="manager" wire:click="increase"/>
                            <label for="rating-0-manager">0</label>
                        </span>
                    </fieldset>

                    <span class="text-red-500 text-sm">@error('manager') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 6 --}}
        @if ($currentStep == 6)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver-2">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="6/14 steps">
                    <div class="gauge h-6 rounded-full" style="width: 42%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        Your understanding of PERSOL's mission & vision, culture & values, and management:
                    </label><br>

                    <fieldset class="stars text-center">
                        <span class="star-cb-group">
                          <input type="radio" id="rating-5-company" name="rating" value="5" title="5"
                                 wire:model="company" wire:click="increase"/>
                            <label for="rating-5-company"></label>
                          <input type="radio" id="rating-4-company" name="rating" value="4" title="4"
                                 wire:model="company" wire:click="increase"/>
                            <label for="rating-4-company"></label>
                          <input type="radio" id="rating-3-company" name="rating" value="3" title="3"
                                 wire:model="company" wire:click="increase"/>
                            <label for="rating-3-company"></label>
                          <input type="radio" id="rating-2-company" name="rating" value="2" title="2"
                                 wire:model="company" wire:click="increase"/>
                            <label for="rating-2-company"></label>
                          <input type="radio" id="rating-1-company" name="rating" value="1" title="1"
                                 wire:model="company" wire:click="increase"/>
                            <label for="rating-1-company"></label>
                          <input type="radio" id="rating-0-company" name="rating" value="0" class="star-cb-clear"
                                 wire:model="company" wire:click="increase"/>
                            <label for="rating-0-company">0</label>
                        </span>
                    </fieldset>

                    <span class="text-red-500 text-sm">@error('company') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 7 --}}
        @if ($currentStep == 7)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="7/14 steps">
                    <div class="gauge h-6 rounded-full" style="width: 50%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        How satisfied you are with your decision of joining PERSOL:
                    </label><br>

                    <fieldset class="stars text-center">
                        <span class="star-cb-group">
                          <input type="radio" id="rating-5-join" name="rating" value="5" title="5" wire:model="join" wire:click="increase"/>
                            <label for="rating-5-join"></label>
                          <input type="radio" id="rating-4-join" name="rating" value="4" title="4" wire:model="join" wire:click="increase"/>
                            <label for="rating-4-join"></label>
                          <input type="radio" id="rating-3-join" name="rating" value="3" title="3" wire:model="join" wire:click="increase"/>
                            <label for="rating-3-join"></label>
                          <input type="radio" id="rating-2-join" name="rating" value="2" title="2" wire:model="join" wire:click="increase"/>
                            <label for="rating-2-join"></label>
                          <input type="radio" id="rating-1-join" name="rating" value="1" title="1" wire:model="join" wire:click="increase"/>
                            <label for="rating-1-join"></label>
                          <input type="radio" id="rating-0-join" name="rating" value="0" class="star-cb-clear"
                                 wire:model="join" wire:click="increase"/>
                            <label for="rating-0-join">0</label>
                        </span>
                    </fieldset>

                    <span class="text-red-500 text-sm">@error('join') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 8 --}}
        @if ($currentStep == 8)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver-2">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="8/14 steps">
                    <div class="gauge h-6 rounded-full" style="width: 57%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        How helpful the onboarding process is for other newcomers:
                    </label><br>

                    <fieldset class="stars text-center">
                        <span class="star-cb-group">
                          <input type="radio" id="rating-5-newcomer" name="rating" value="5" title="5"
                                 wire:model="newcomer" wire:click="increase"/>
                            <label for="rating-5-newcomer"></label>
                          <input type="radio" id="rating-4-newcomer" name="rating" value="4" title="4"
                                 wire:model="newcomer" wire:click="increase"/>
                            <label for="rating-4-newcomer"></label>
                          <input type="radio" id="rating-3-newcomer" name="rating" value="3" title="3"
                                 wire:model="newcomer" wire:click="increase"/>
                            <label for="rating-3-newcomer"></label>
                          <input type="radio" id="rating-2-newcomer" name="rating" value="2" title="2"
                                 wire:model="newcomer" wire:click="increase"/>
                            <label for="rating-2-newcomer"></label>
                          <input type="radio" id="rating-1-newcomer" name="rating" value="1" title="1"
                                 wire:model="newcomer" wire:click="increase"/>
                            <label for="rating-1-newcomer"></label>
                          <input type="radio" id="rating-0-newcomer" name="rating" value="0" class="star-cb-clear"
                                 wire:model="newcomer" wire:click="increase"/>
                            <label for="rating-0-newcomer">0</label>
                        </span>
                    </fieldset>

                    <span class="text-red-500 text-sm">@error('newcomer') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 9 --}}
        @if ($currentStep == 9)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="9/14 steps">
                    <div class="gauge h-6 rounded-full" style="width: 64%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        How your Buddy helped you feel better over the initial days:
                    </label><br>

                    <fieldset class="stars text-center">
                        <span class="star-cb-group">
                          <input type="radio" id="rating-5-buddy" name="rating" value="5" title="5" wire:model="buddy" wire:click="increase"/>
                            <label for="rating-5-buddy"></label>
                          <input type="radio" id="rating-4-buddy" name="rating" value="4" title="4" wire:model="buddy" wire:click="increase"/>
                            <label for="rating-4-buddy"></label>
                          <input type="radio" id="rating-3-buddy" name="rating" value="3" title="3" wire:model="buddy" wire:click="increase"/>
                            <label for="rating-3-buddy"></label>
                          <input type="radio" id="rating-2-buddy" name="rating" value="2" title="2" wire:model="buddy" wire:click="increase"/>
                            <label for="rating-2-buddy"></label>
                          <input type="radio" id="rating-1-buddy" name="rating" value="1" title="1" wire:model="buddy" wire:click="increase"/>
                            <label for="rating-1-buddy"></label>
                          <input type="radio" id="rating-0-buddy" name="rating" value="0" class="star-cb-clear"
                                 wire:model="buddy"/>
                            <label for="rating-0-buddy">0</label>
                        </span>
                    </fieldset>

                    <span class="text-red-500 text-sm">@error('buddy') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 10 --}}
        @if ($currentStep == 10)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver-2">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="10/14 steps">
                    <div class="gauge h-6 rounded-full" style="width: 71%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        What recommendations would you like to make to improve the role of Buddy?
                    </label><br>

                    <textarea class="mt-5 gauge-meter border border-gray-300 text-sm text-gray-700 rounded-lg focus:ring-gray-500 block w-full
                    focus:border-gray-500 p-2.5 dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                              id="role-buddy" type="text" placeholder="{{$roleOfBuddy}}"
                              wire:model="roleOfBuddy"> </textarea>


                    <span class="text-red-500 text-sm">@error('roleOfBuddy') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 11 --}}
        @if ($currentStep == 11)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="11/14 steps">
                    <div class="gauge h-6 rounded-full" style="width: 78%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        What specific challenges or achievements you have had throughout the onboarding process?
                    </label><br>

                    <textarea class="mt-5 gauge-meter border border-gray-300 text-sm text-gray-700 rounded-lg focus:ring-gray-500 block w-full
                    focus:border-gray-500 p-2.5 dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                              id="challenge" type="text" placeholder="{{$challenge}}"
                              wire:model="challenge"> </textarea>


                    <span class="text-red-500 text-sm">@error('challenge') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 12 --}}
        @if ($currentStep == 12)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver-2">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="12/14 steps">
                    <div class="gauge h-6 rounded-full" style="width: 85%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        Which specific stages of onboarding process was the most helpful, apart from the first session?
                    </label><br>

                    <textarea class="mt-5 gauge-meter border border-gray-300 text-sm text-gray-700 rounded-lg focus:ring-gray-500 block w-full
                    focus:border-gray-500 p-2.5 dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                              id="stage" type="text" placeholder="{{$stage}}"
                              wire:model="stage"> </textarea>


                    <span class="text-red-500 text-sm">@error('stage') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 13 --}}
        @if ($currentStep == 13)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="13/14 steps">
                    <div class="gauge h-6 rounded-full" style="width: 92%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        Which specific stages of onboarding process can be improved, apart from the first session?
                    </label><br>

                    <textarea class="mt-5 gauge-meter border border-gray-300 text-sm text-gray-700 rounded-lg focus:ring-gray-500 block w-full
                    focus:border-gray-500 p-2.5 dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                              id="improvement" type="text" placeholder="{{$improvement}}"
                              wire:model="improvement"> </textarea>
                    <span class="text-red-500 text-sm">@error('improvement') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        {{-- STEP 14 --}}
        @if ($currentStep == 14)
            <div class="p-4 text-center mx-auto align-middle items-center flip-scale-down-ver-2">
                <div class="gauge-meter-modified w-full h-6 rounded-full" title="14/14 steps">
                    <div class="gauge h-6 rounded-full" style="width: 100%"></div>
                </div>
                <div class="mt-6 text-justify max-w-xs">
                    <label>
                        What other helpful suggestions you would like to make?
                    </label><br>
                    <textarea class="mt-5 gauge-meter border border-gray-300 text-sm text-gray-700 rounded-lg focus:ring-gray-500 block w-full
                    focus:border-gray-500 p-2.5 dark:placeholder-gray-400 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                              id="suggestion" type="text" placeholder="{{$suggestion}}"
                              wire:model="suggestion"> </textarea>


                    <span class="text-red-500 text-sm">@error('suggestion') * {{ $message }}@enderror</span>
                </div>
            </div>
        @endif

        <div class="survey-submit text-center mx-auto justify-content-between w-1/2 bg-gray-300 @if ( isDarkMode())  bg-main @endif pt-2 pb-2 rounded">
            @if ($currentStep > 1)
                <button type="button" class="border-r-2 p-2 text-center" wire:click="decrease"
                        title="{{ $previousStep }}">
                    <i class="fa fa-arrow-circle-left"></i>
                </button>
            @endif

            @if ($currentStep < 14)
                <button type="button" wire:click="increase" title="{{ $nextStep }}">
                    <i class="fa fa-arrow-circle-right"></i>
                </button>
            @elseif ($currentStep == 14)
                <button type="submit" title="Submit">
                    <i class="fas fa-check-circle"></i>
                </button>
            @endif
        </div>

    </form>
</div>
