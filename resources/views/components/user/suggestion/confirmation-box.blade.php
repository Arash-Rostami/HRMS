@if($suggestion['confirmBox'])
    @php
        $headerClasses = [
            'w-full h-11 rounded-t-lg flex justify-end items-center transition-colors duration-300',
            'bg-gray-200 hover:bg-gray-300' => !isDarkMode(),
            'bg-main hover:bg-gray-700' => isDarkMode(),
        ];

        $modalClasses = [
            'rounded-md p-0 text-center',
            'bg-gray-300' => !isDarkMode(),
            'bg-gray-600' => isDarkMode(),
        ];

        $errorClasses = [
            'text-red-500 text-sm px-2 py-1 rounded-md transition-colors duration-300 my-5',
            'bg-gray-800' => isDarkMode(),
        ];

        $feedback = isManager() ? 'suggestion.feedback.ceo' : 'suggestion.feedback.nonceo';
        $description = isManager() ? 'suggestion.description.ceo' : 'suggestion.description.nonceo';
    @endphp
    <div
            class="absolute z-[1000] left-0 bottom-0 right-0 top-0 bg-opacity-75 flex justify-center items-center backdrop-blur">

        <div @class(array_merge($modalClasses, [
            'w-1/2' => !$suggestion['response'],
            'w-[90%] md:w-1/2 text-right' => $suggestion['response']
        ]))>

            {{-- Common Header --}}
            <div @class($headerClasses)>
                    <span
                            class="mr-auto ml-4 text-gray-500 hover:text-red-500 transition-colors duration-300 cursor-pointer"
                            wire:click="resetSuggestions">
                        <i class="fas fa-times"></i>
                    </span>
            </div>

            {{-- Confirmation Content --}}
            @unless($suggestion['response'])
                <div class="p-8">
                    <p>{{ $suggestion['confirmationText'] }}</p>
                    <div class="mt-4 flex justify-center space-x-4">
                        <button class="bg-red-500 text-white p-2 rounded-md ml-2 hover:bg-red-600 transition"
                                wire:click="showConfirmBox">
                            لغو عملیات
                        </button>
                        <button class="bg-green-500 text-white p-2 rounded-md mr-2 hover:bg-green-600 transition"
                                wire:click="{{ $suggestion['confirmedMethod'] }}">
                            بله، حذف شود
                        </button>
                    </div>
                </div>
            @else
                {{-- Response Content --}}
                <div class="mt-2 m-2 p-4 flex flex-col" x-show="response">

                    {{-- Feedback Section --}}
                    <div>
                        <label class="block mb-2" for="status-team">
                            <i class="fas fa-microphone text-xs text-main"></i>
                            لطفاً نظر کلی خود را پیرامون پیشنهاد ثبت کنید.
                        </label>

                        <ul>
                            {{-- Common radio options --}}
                            @foreach([
                                'agree' => 'finalResponse.agree',
                                'disagree' => 'finalResponse.disagree'
                            ] as $value => $text)
                                <li class="pb-1">
                                    <label class="flex items-center">
                                        <input type="radio" wire:model="{{ $feedback }}" value="{{ $value }}">
                                        <span class="mr-2 text-sm" x-text="{{ $text }}"></span>
                                    </label>
                                </li>
                            @endforeach

                            {{-- Role-specific options --}}
                            @if(isManager())
                                <li class="pb-1">
                                    <label class="flex items-center">
                                        <input type="radio" wire:model="{{ $feedback }}" value="incomplete">
                                        <span class="mr-2 text-sm" x-text="finalResponse.under_review"></span>
                                    </label>
                                </li>
                            @elseif(isDepartmentManager())
                                <li class="pb-1">
                                    <label class="flex items-center">
                                        <input type="radio" wire:model="{{ $feedback }}" value="neutral">
                                        <span class="mr-2 text-sm" x-text="finalResponse.neutral"></span>
                                    </label>
                                </li>
                            @endif

                            @error($feedback)
                            <span @class($errorClasses)>{{ $message }}</span>
                            @enderror
                        </ul>
                    </div>

                    {{-- Description Section --}}
                    <div class="pt-2">
                        <label for="description-team" class="block mb-2">
                            <i class="fa fa-edit text-xs text-main"></i>
                            توضیحات برای پیشنهاد دهنده:
                        </label>
                        <textarea wire:model="{{ $description }}"
                                  class="w-full border border-gray-300 text-gray-500 rounded-md p-2"
                                  rows="5"></textarea>
                        @error($description)
                        <span @class($errorClasses)>{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- CEO Referral Section --}}
                    @if(isset($suggestion['feedback']['ceo']) && $suggestion['feedback']['ceo'] === 'agree')
                        <div
                                class="w-full mx-auto border-b border-dotted border-gray-400 pb-4 transition-all duration-300 ease-in-out hover:border-gray-600"></div>

                        <div class="flex flex-col md:flex-row mt-2 fade-in">
                            {{-- Departments Selection --}}
                            <div class="w-full md:w-[40%]">
                                <label for="organizational-unit" class="block mb-2">
                                    <i class="fa fa-address-card text-xs text-main"></i>
                                    ارجاع به واحد(های) مرتبط:
                                </label>
                                <select multiple
                                        wire:model="suggestion.description.ceo-departments"
                                        id="organizational-unit-ceo"
                                        class="w-full border border-gray-300 rounded-md p-1 md:p-2 h-3/4">
                                    @foreach($suggestion['departmentNames'] as $key => $name)
                                        @unless(in_array($key, [auth()->user()->profile->department,"MA"]))
                                            <option class="text-gray-500" value="{{ $key }}">{{ $name }}</option>
                                        @endunless
                                    @endforeach
                                </select>
                                @error('suggestion.description.ceo-departments')
                                <span @class($errorClasses)>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full md:w-[10%]"></div>

                            {{-- Referral Description --}}
                            <div class="w-full md:w-[50%] pt-2 md:pt-0">
                                <label for="description-team" class="block mb-2">
                                    <i class="fa fa-edit text-xs text-main"></i>
                                    توضیحات برای واحد(های) مرتبط:
                                </label>
                                <textarea wire:model="suggestion.description.ceo-referral"
                                          id="description-ceo-referral" rows="5"
                                          class="w-full border border-gray-300 text-gray-500 rounded-md p-2">
                                </textarea>
                                @error("suggestion.description.ceo-referral")
                                <span @class($errorClasses)>{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    {{-- Submit Button --}}
                    <div class="w-full md:w-1/6 pt-2 mx-auto">
                        <button type="submit"
                                title="ارسال"
                                class="px-4 py-2 mx-auto md:mx-auto block bg-main-mode text-white rounded-md
                                       hover:bg-blue-700 transition-colors duration-300 ease-in-out
                                       focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2"
                                wire:loading.class="bg-red-700"
                                wire:loading.class.remove="bg-main-mode"
                                wire:click="submitResponse"
                                wire:target="submitResponse"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="submitResponse">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <span wire:loading wire:target="submitResponse">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                        </button>
                    </div>
                </div>
            @endunless
        </div>
    </div>
@endif
