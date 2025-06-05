@if($suggestion['confirmBox'])
    <div
        class="absolute z-[1000] left-0 bottom-0 right-0 top-0 bg-opacity-75 flex justify-center items-center">
        @unless($suggestion['response'])
            <div class="bg-gray-200 @if(isDarkMode()) bg-main-theme @endif w-1/2 rounded-md p-4 text-center">
                <p class="text-gray-500">{{ $suggestion['confirmationText'] }}</p>
                <div class="mt-4 flex justify-center space-x-4">
                    <button class="bg-red-500 text-white px-2 py-1 mx-2 rounded-md"
                            wire:click="showConfirmBox">
                        خیر :(
                    </button>
                    <button class="bg-green-500 text-white px-2 py-1 mx-2 rounded-md"
                            wire:click="{{$suggestion['confirmedMethod']}}">
                        بله :)
                    </button>
                </div>
                @endunless
                <div
                    class="bg-gray-200 @if(isDarkMode()) bg-main-theme @endif w-[90%] md:w-1/2 rounded-md p-4 text-right">
                    <div class="mt-2 m-2 p-4 flex flex-col" x-show="response">
                                     <span class="mr-auto ml-4 text-gray-500 cursor-pointer float-left"
                                           wire:click="$set('suggestion.confirmBox', false)">
                                        <i class="fas fa-times"></i>
                                    </span>
                        <div>
                            <label class="block mb-2" for="status-team">
                                <i class="fas fa-microphone text-xs text-main"></i>
                                لطفاً نظر کلی خود را پیرامون پیشنهاد ثبت کنید.
                            </label>
                            <ul>
                                @php
                                    $feedback = isManager() ? 'suggestion.feedback.ceo' : 'suggestion.feedback.nonceo';
                                    $description = isManager() ? 'suggestion.description.ceo' : 'suggestion.description.nonceo';
                                @endphp
                                <li class="pb-1">
                                    <label class="flex items-center">
                                        <input type="radio" wire:model="{{ $feedback }}"
                                               value="agree">
                                        <span class="mr-2 text-sm" x-text="finalResponse.agree"></span>
                                    </label>
                                </li>

                                <li class="pb-1">
                                    <label class="flex items-center">
                                        <input type="radio" wire:model="{{ $feedback }}"
                                               value="disagree">
                                        <span class="mr-2 text-sm"
                                              x-text="finalResponse.disagree"></span>
                                    </label>
                                </li>
                                @if(isManager())
                                    <li class="pb-1">
                                        <label class="flex items-center">
                                            <input type="radio" wire:model="{{ $feedback }}"
                                                   value="incomplete">
                                            <span class="mr-2 text-sm"
                                                  x-text="finalResponse.under_review"></span>
                                        </label>
                                    </li>
                                @elseif(isDepartmentManager())
                                    <li class="pb-1">
                                        <label class="flex items-center">
                                            <input type="radio" wire:model="{{$feedback}}"
                                                   value="neutral">
                                            <span class="mr-2 text-sm"
                                                  x-text="finalResponse.neutral"></span>
                                        </label>
                                    </li>
                                @endif
                                @error($feedback)
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                                @error('suggestion.feedback.ceo')
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                                @error('suggestion.feedback.nonceo')
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </ul>
                        </div>
                        <div class="pt-2">
                            <label for="description-team" class="block mb-2">
                                <i class="fa fa-edit text-xs text-main"></i>
                                توضیحات برای پیشنهاد دهنده:
                            </label>
                            <textarea
                                wire:model="{{ $description }}"
                                class="w-full border border-gray-300 text-gray-500 rounded-md p-2"
                                rows="5"></textarea>
                            @error($description)
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{--ceo referal--}}
                        @if (isset($suggestion['feedback']['ceo']) && $suggestion['feedback']['ceo'] === 'agree')
                            {{--divider--}}
                            <div
                                class="w-full mx-auto border border-dotted border-b-1 border-t-0 border-l-0 border-r-0 pb-4"></div>
                            <div class="flex flex-col md:flex-row mt-2 fade-in">
                                {{--departments--}}
                                <div class="w-full md:w-[40%]">
                                    <label for="organizational-unit" class="block mb-2"> <i
                                            class="fa fa-address-card text-xs text-main"></i>
                                        ارجاع به واحد(های) مرتبط:
                                    </label>
                                    @error('suggestion.departments-ceo')
                                    <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                    <select multiple
                                            wire:model="suggestion.description.ceo-departments"
                                            id="organizational-unit-ceo"
                                            class="w-full border border-gray-300 rounded-md p-1 md:p-2 h-3/4">
                                        @foreach($suggestion['departmentNames'] as $key => $name)
                                            @unless( in_array($key, [auth()->user()->profile->department,'MA']))
                                                <option class="text-gray-500"
                                                        value="{{ $key }}">{{ $name }}</option>
                                            @endunless
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-full md:w-[10%]"></div>
                                {{--description --}}
                                <div class="w-full md:w-[50%] pt-2 md:pt-0">
                                    <label for="description-team" class="block mb-2">
                                        <i class="fa fa-edit text-xs text-main"></i>
                                        توضیحات برای واحد(های) مرتبط:
                                    </label>
                                    @error("suggestion.description.ceo-referral")
                                    <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                    <textarea wire:model="suggestion.description.ceo-referral"
                                              id="description-ceo-referral" rows="5"
                                              class="w-full border border-gray-300 text-gray-500 rounded-md p-2">
                                    </textarea>
                                </div>
                            </div>
                        @endif
                        <div class="w-full md:w-1/6 pt-2">
                            <button
                                type="submit"
                                title="submit"
                                class="px-4 py-2 mx-auto md:mx-auto block bg-main-mode text-white rounded-md"
                                wire:loading.class="bg-red-700"
                                wire:loading.class.remove="bg-main-mode"
                                wire:click="submitResponse"
                                wire:target="submitResponse"
                                wire:loading.attr="disabled">
                                 <span wire:loading.remove  wire:target="submitResponse"><i class="fas fa-envelope"></i></span>
                                 <span wire:loading  wire:target="submitResponse"><i class="fas fa-spinner fa-spin"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endif
