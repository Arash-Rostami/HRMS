<div class="flex flex-col"
     x-show="activeTab === 'new'"
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-500"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">

    {{--Heading--}}
    @include('livewire.suggestion.flowchart')

    {{--Editing Toggle--}}
    <div class="p-0 md:p-3 mt-3 mb-3 md:mb-1">
        <label class="switch" wire:click="toggleEditing">
            <input type="checkbox" wire:model="suggestion.isEditable">
            <span @class([ 'slider round','bg-main-mode' => $suggestion['isEditable'],'bg-gray-400' => !$suggestion['isEditable'],'box-shadow' => $suggestion['isEditable'],])></span>
        </label>
        <span>{{ $suggestion['isEditable'] ? 'در حال ویرایش ...' : 'ویرایش' }}</span>
    </div>

    {{--Editable Suggestion Choice--}}
    @if($suggestion['isEditable'] && !$suggestion['isEditing'])
        <div class="flex flex-col md:flex-row pb-6 md:pb-0 md:p-3">
            <div class="w-[20%] self-center">
                {{-- Input for editing --}}
                <label for="editing-suggestion" class="block mb-2">
                    <i class="fas fa-pencil-alt text-xs text-main"></i>
                    عنوان پیشنهاد:
                </label>
            </div>
            <div class="pb-6 md:pb-0 md:p-3 w-[40%]">
                <select wire:model.defer="suggestion.editableRecord"
                        wire:change="editSuggestion"
                        id="editing-suggestion"
                        class="w-full border border-gray-300 text-gray-500 rounded-md p-1 md:p-2">
                    <option value="" selected disabled> &nbsp; &nbsp; &nbsp; &nbsp;انتخاب کنید</option>
                    @foreach($suggestion['review'] as $editable)
                        <option value="{{ $editable->id }}"
                                wire:key="suggestion-{{ $editable->id }}">{{ $editable->title }} </option>
                    @endforeach
                </select>
            </div>
            <div class="w-[40%]"></div>
        </div>

    @elseif(!$suggestion['isEditable'] || $suggestion['isEditing'])
        {{--1st row--}}
        <div class="flex flex-col md:flex-row pb-6 md:pb-0 md:p-3">

            <div class="flex flex-col pb-6 md:pb-0 md:p-3 w-full md:w-[50%]">
                {{--Title--}}
                <div class="w-full mb-4">
                    <label for="suggestion-title" class="block mb-2"><i
                            class="fas fa-tag text-xs text-main"></i>
                        عنوان:
                    </label>
                    <input type="text" wire:model="suggestion.title" id="suggestion-title"
                           @if($suggestion['isEditing']) disabled @endif
                           class="w-full border border-gray-300 text-gray-500 rounded-md p-1 md:p-2">
                    @error('suggestion.title')
                    <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                {{--Text--}}
                <div class="w-full">
                    <label for="suggestion-description" class="block mb-2">
                        <i class="fa fa-edit text-xs text-main"></i>
                        شرح پیشنهاد و استدلالها و محاسبات مربوط به هر یک از بهبودهای پنج گانه:
                    </label>
                    <textarea wire:model="suggestion.description.self"
                              id="suggestion-description"
                              placeholder="* اگر پيشنهاد شما مؤثر بر هيچيك از موارد بالا نباشد، به جريان انداختن اين فرم ممكن نخواهد بود."
                              class="w-full border border-gray-300 text-gray-500 rounded-md p-2"></textarea>
                    @error('suggestion.description.self')
                    <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="w-full md:w-[10%]"></div>
            {{--Deps--}}
            <div class="w-full md:w-[20%]">
                <label for="organizational-unit" class="block mb-2"> <i
                        class="fa fa-address-card text-xs text-main"></i>
                    نام واحد(های) ذی نفع:
                </label>
                <select multiple title="⌘ Ctrl-clicking"
                        wire:model="suggestion.departments" id="organizational-unit"
                        class="w-full border border-gray-300 rounded-md p-1 md:p-2 h-3/4 cursor-pointer">
                    @foreach($suggestion['departmentNames'] as $key => $name)
                        @unless( in_array($key, [auth()->user()->profile->department,'MA']))
                            <option class="text-gray-500" value="{{ $key }}">{{ $name }}</option>
                        @endunless
                    @endforeach
                </select>
            </div>
        </div>


        {{--2nd row--}}
        <div class="flex flex-col md:flex-row pb-6 md:pb-0 md:p-3">
            <div class="flex flex-col md:flex-row pb-6 md:p-3 w-full md:w-[50%]">
                <div class="w-full md:w-[50%] pt-2">
                    <p class="block mb-2"><i class="fas fa-lightbulb text-xs text-main"></i>
                        این پیشنهاد در راستای کدام از قواعد پرسال
                        است؟</p>
                    <div class="flex items-center mb-2">
                        <input type="checkbox" wire:model="suggestion.rule" value="simplify"
                               id="suggestion-rule-1"
                               class="ml-2">
                        <label class="text-sm" for="suggestion-rule-1" x-text="rules.simplify"></label>
                    </div>
                    <div class="flex items-center mb-2">
                        <input type="checkbox" wire:model="suggestion.rule" value="prioritize"
                               id="suggestion-rule-2" class="ml-2">
                        <label class="text-sm" for="suggestion-rule-2" x-text="rules.prioritize"></label>
                    </div>
                    <div class="flex items-center mb-2">
                        <input type="checkbox" wire:model="suggestion.rule" value="collaborate"
                               id="suggestion-rule-3" class="ml-2">
                        <label class="text-sm" for="suggestion-rule-3" x-text="rules.collaborate"></label>
                    </div>
                    <div class="flex items-center mb-2">
                        <input type="checkbox" wire:model="suggestion.rule" value="boost"
                               id="suggestion-rule-4"
                               class="ml-2">
                        <label class="text-sm" for="suggestion-rule-4" x-text="rules.boost"></label>
                    </div>
                    @error('suggestion.rule')
                    <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-full md:w-[10%]"></div>
                <div class="w-full md:w-[50%] pt-2">
                    <p class="block mb-2">
                        <i class="fa fa-rocket text-xs text-main"></i>
                        این پیشنهاد موجب كدامیگ از بهبودهاي زیر خواهد شد؟</p>
                    <div class="flex items-center mb-2">
                        <input type="checkbox" wire:model="suggestion.purpose" value="cost"
                               id="improvement-area-1"
                               class="ml-2">
                        <label class="text-sm" for="improvement-area-1" x-text="purposes.cost"></label>
                    </div>
                    <div class="flex items-center mb-2">
                        <input type="checkbox" wire:model="suggestion.purpose" value="time"
                               id="improvement-area-2"
                               class="ml-2">
                        <label class="text-sm" for="improvement-area-2" x-text="purposes.time"></label>
                    </div>
                    <div class="flex items-center mb-2">
                        <input type="checkbox" wire:model="suggestion.purpose" value="workload"
                               id="improvement-area-3"
                               class="ml-2">
                        <label class="text-sm" for="improvement-area-3" x-text="purposes.workload"></label>
                    </div>
                    <div class="flex items-center mb-2">
                        <input type="checkbox" wire:model="suggestion.purpose" value="sales"
                               id="improvement-area-4"
                               class="ml-2">
                        <label class="text-sm" for="improvement-area-4" x-text="purposes.sales"></label>
                    </div>
                    <div class="flex items-center mb-2">
                        <input type="checkbox" wire:model="suggestion.purpose" value="profit"
                               id="improvement-area-5"
                               class="ml-2">
                        <label class="text-sm" for="improvement-area-5" x-text="purposes.profit"></label>
                    </div>
                    @error('suggestion.purpose')
                    <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="w-full md:w-[10%]"></div>
            {{--Upload attachment--}}
            <div class="w-full md:w-[30%] md:w-1/6 m-auto md:mx-0 text-justify max-w-xs"
                 x-data="{ isUploading: false, progress: 0, isUploaded:false }"
                 x-on:livewire-upload-start="isUploading = true"
                 x-on:livewire-upload-finish="isUploading = false; isUploaded = true"
                 x-on:livewire-upload-error="isUploading = false"
                 x-on:livewire-upload-progress="progress = $event.detail.progress"
            >
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file"
                           class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg
                                   cursor-pointer bg-gray-100 @if ( isDarkMode())  bg-main @endif dark:hover:bg-bray-800 hover:bg-gray-100
                                   dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-300">
                        <svg aria-hidden="true" class="w-8 h-8 mb-3 text-gray-400 main-color" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p x-show="!isUploaded" class="text-sm text-gray-500 dark:text-gray-400 px-4">
                            <span class="font-semibold"> فایل ضمیمه</span>
                        </p>
                        <p x-show="!isUploaded" class="text-xs hidden md:inline text-gray-500 dark:text-gray-400 px-4">
                            PDF, PNG, JPG (MAX 2MB)
                        </p>
                        <div x-show="isUploaded" title="uploaded successfully">
                            ✔️
                        </div>
                        <input id="dropzone-file" class="hidden" type="file"
                               wire:model="suggestion.attachment"/>
                        <span x-show="isUploading">
                              <progress class="mx-auto rounded-l" max="100" x-bind:value="progress"></progress>
                        </span>
                    </label>
                </div>

                @error('suggestion.attachment')
                <span class=" text-red-500">{{ $message }}</span>
                @enderror
            </div>

        </div>

        {{--3rd row--}}
        @if($suggestion['submitted'])
            <div class="flex flex-col md:flex-row pb-6 md:pb-0 md:p-3">
                <div class="w-full md:w-1/2 pt-2 flex space-x-4">
                    <button type="button"
                            @click="open = true"
                            class="px-4 py-2 bg-main-mode text-white rounded-md ml-2"
                            title="📖 View Guide">
                        <span><i class="fas fa-book"></i> مطالعه روند ارسال پیشنهادات</span>
                    </button>

                    <button type="submit"
                            @if(session('success')) disabled @endif
                            wire:click="submitSuggestion"
                            wire:loading.attr="disabled"
                            wire:loading.class="bg-red-700"
                            wire:loading.class.remove="bg-main-mode"
                            wire:target="submitSuggestion"
                            class="px-4 py-2 bg-main-mode text-white rounded-md mr-2"
                            title="✉️ Submit">
                        <span wire:loading.remove wire:target="submitSuggestion"> <i class="fas fa-paper-plane"></i> ارسال</span>
                        <span wire:loading wire:target="submitSuggestion"><i class="fas fa-spinner fa-spin"></i> ارسال...</span>
                    </button>
                </div>
            </div>
        @endif
        <div x-show="open" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-80"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-80"
             class="flex items-center justify-center z-50">
            <div class="fixed inset-0 bg-black opacity-70" @click="open = false"></div>
            <div
                class="bg-neutral-300 @if(isDarkMode()) bg-main-theme @endif relative top-2 p-2 md:p-6 rounded-lg shadow-lg w-full max-h-screen overflow-auto">
                <!-- Close Button -->
                <button @click="open = false" title="Click to close the flowchart"
                        class="relative md:bottom-3 text-main font-bold float-right hover:scale-110">
                    <i class="fas fa-times cursor-pointer"></i>
                </button>
                <!-- Image -->
                <img src="{{ asset('img/user/suggestionProcedure.png') }}" alt="Suggestion Process Guide"
                     class="w-full h-auto rounded-lg cursor-pointer" title="Click to enlarge the flowchart" data-lity>
            </div>
        </div>

        {{--divider--}}
        <div class="w-full mx-auto border border-dotted border-b-1 border-t-0 border-l-0 border-r-0 pb-4"></div>

        {{--laoder of the self-fill--}}
        <div class="flex items-center mb-2 md:p-3">
            <input type="checkbox" wire:model="suggestion.selfFill" name="selfFill" id="selfFill"
                   class="ml-2">
            <label class="flex items-center text-justify" for="selfFill">
                بازخورد سایر اعضا: با فعال کردن این گزینه، می‌توانید نظرات ذی نفعان را ثبت کنید و مسئولیت صحت بازخوردها
                را به
                عهده بگیرید.
            </label>
        </div>

        {{--SELFFILL section of team--}}
        @if($suggestion['selfFill'])
            <div class="flex flex-col md:flex-row items-center md:p-3">
                <div class="flex flex-col w-full md:w-1/3">
                    <div class="mt-4 mb-2">
                        <label class="block mb-2" for="status-team">
                            <i class="fas fa-microphone text-xs text-main"></i>
                            لطفاً نظر کلی سایر اعضای تیم خود را پیرامون پیشنهادتان ثبت کنید.
                        </label>
                        <ul>
                            <li class="pb-1">
                                <label class="flex items-center">
                                    <input type="radio" wire:model="suggestion.feedback.team" value="agree">
                                    <span class="mr-2 text-sm" x-text="feedbackResponse.agree"></span>
                                </label>
                            </li>
                            <li class="pb-1">
                                <label class="flex items-center">
                                    <input type="radio" wire:model="suggestion.feedback.team"
                                           value="neutral">
                                    <span class="mr-2 text-sm" x-text="feedbackResponse.neutral"></span>
                                </label>
                            </li>
                            <li class="pb-1">
                                <label class="flex items-center">
                                    <input type="radio" wire:model="suggestion.feedback.team"
                                           value="disagree">
                                    <span class="mr-2 text-sm" x-text="feedbackResponse.disagree"></span>
                                </label>
                            </li>
                        </ul>
                        @error("suggestion.feedback.team")
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="w-full md:w-1/6"></div>
                <div class="w-full md:w-1/3 pt-2">
                    <label for="description-team" class="block mb-2">
                        <i class="fa fa-edit text-xs text-main"></i>
                        توضیحات:
                    </label>
                    <textarea wire:model="suggestion.description.team" id="description-team"
                              class="w-full border border-gray-300 text-gray-500 rounded-md p-2"
                              rows="3"></textarea>
                    @error("suggestion.description.team")
                    <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endif

        {{--SELFFILL section of other departments--}}
        @isset($suggestion['departments'])
            @foreach($suggestion['departments'] as $department)
                <div x-show="selfFill">
                    <div
                        class="w-full mx-auto border border-dotted border-b-1 border-t-0 border-l-0 border-r-0 pb-4"></div>
                    <div class="flex flex-col md:flex-row items-center md:p-3">
                        <div class="flex flex-col w-full md:w-1/3">
                            <div class="mt-4 mb-2">
                                <label class="block mb-2" for="status-{{$department}}">
                                    <i class="fas fa-microphone text-xs text-main"></i>
                                    لطفاً نظر کلی
                                    <span class="bg-main-mode pb-1 px-2 ml-1 rounded">
                                                {{ $suggestion['departmentNames'][$department] }}
                                            </span>
                                    را پیرامون
                                    پیشنهادتان ثبت کنید.
                                </label>
                                <ul>
                                    <li class="pb-1">
                                        <label class="flex items-center">
                                            <input type="radio"
                                                   wire:model="suggestion.feedback.{{$department}}"
                                                   value="agree">
                                            <span class="mr-2 text-sm"
                                                  x-text="feedbackResponse.agree"></span>
                                        </label>
                                    </li>
                                    <li class="pb-1">
                                        <label class="flex items-center">
                                            <input type="radio"
                                                   wire:model="suggestion.feedback.{{$department}}"
                                                   value="neutral">
                                            <span class="mr-2 text-sm"
                                                  x-text="feedbackResponse.neutral"></span>
                                        </label>
                                    </li>
                                    <li class="pb-1">
                                        <label class="flex items-center">
                                            <input type="radio"
                                                   wire:model="suggestion.feedback.{{$department}}"
                                                   value="disagree">
                                            <span class="mr-2 text-sm"
                                                  x-text="feedbackResponse.disagree"></span>
                                        </label>
                                    </li>
                                </ul>
                                @error("suggestion.feedback.{$department}")
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full md:w-1/6"></div>
                        <div class="w-full md:w-1/3 pt-2">
                            <label for="description-{{ $department }}" class="block mb-2">
                                <i class="fa fa-edit text-xs text-main"></i>
                                توضیحات:
                            </label>
                            <textarea wire:model="suggestion.description.{{ $department }}"
                                      id="description-{{ $department }}" required
                                      class="w-full border border-gray-300  text-gray-500 rounded-md p-2"
                                      rows="3"></textarea>
                            @error("suggestion.description.{$department}")
                            {{--                                        <span class="text-red-500">{{ $message }}</span>--}}
                            @enderror
                        </div>
                    </div>
                </div>
            @endforeach
        @endisset
    @endif
</div>
