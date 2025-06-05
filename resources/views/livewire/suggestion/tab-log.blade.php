<div
    x-show="activeTab === 'sent'"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-500"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">
    <p class="md:mr-6 p-2 text-sm text-justify">
        <i class="fa fa-exclamation-triangle"></i>
        برای رویت پیشنهاد یا بازخورد، روی پیشنهاد یا نام واحد کلیک کرده تا بازخورد های مربوطه در پایین جدول ظاهر شده و
        نمایش داده شوند.
    </p>
    <div class="mx-auto my-3 md:p-4 ">
        <div class="thumbnail links-thumbnails container-scrollbar custom-scrollbar">
            {{--heading of table--}}
            <div class="flex flex-row px-2 md:p-6 w-full bg-gray-300
                @if ( isDarkMode()) bg-main @endif rounded-lg min-w-[800px]">
                <div class=" py-1 px-3 w-[15%] text-center"> عنوان</div>
                <div class=" py-1 px-3 w-[20%] text-left">ارسال کننده</div>
                <div class=" py-1 px-3 w-[30%] text-center">توضیحات</div>
                <div class=" py-1 px-3 w-[30%] text-center">واحد</div>
                <div class="flex flex-row w-full text-left">
                    <div class="py-1 px-3 w-[20%]"> وضعیت</div>
                    <div class="py-1 px-3 w-[30%]"> پرشده شخصی</div>
                    <div class="py-1 px-3 w-[15%]"> پیوست</div>
                    <div class="py-1 px-3 cursor-pointer w-[15%]"> لغو</div>
                    <div class="py-1 px-3 cursor-pointer w-[20%]"> پاسخ</div>
                </div>
            </div>
            @foreach($suggestionWithReview->groupBy('title') as $title => $records)
                @if($records->isNotEmpty())
                    <div
                        class="flex flex-row items-center w-full border-gray-200 @if(!$loop->last) border-b-2 @endif border-dotted min-w-[800px]">
                        <div class="px-4 w-[15%]">
                            {{--title--}}
                            <span class="text-main cursor-help"
                                  title="the number of records related">
                                {{ str_repeat('★', $records->count()) }}
                            </span>
                            <br>
                            {{  showFewFirstPersians($title,15) }}
                        </div>
                        {{--Other body fields of table--}}
                        <div class="flex flex-col w-full">
                            @foreach($records as $record)
                                @php
                                    $backgroundClass = isAborted($record)
                                        ? 'bg-gradient-to-r from-gray-500 via-transparent to-transparent bg-repeat-x bg-size-[2px] h-[100%]'
                                        : (isAwaitingDecision($record)
                                            ? 'bg-gradient-to-r from-orange-500 via-transparent to-transparent bg-repeat-x bg-size-[2px] h-[100%]'
                                            : '');
                                @endphp
                                <div
                                    class="py-4 flex flex-row {{ $backgroundClass }}"
                                    title="{{ (isAborted($record)) ? 'suggestion aborted by suggester' : null }}">
                                    {{--image--}}
                                    <div class="text-center py-2 px-3 cursor-help w-[20%]">
                                        <img
                                            alt="profile-photo"
                                            class="rounded-full mx-auto"
                                            src="{{ $record->user->profile->image }}"
                                            title=" {{ $record->user->forenameInitials }}"
                                            width="60" height="60">
                                    </div>
                                    {{--description--}}
                                    <div class="text-right py-2 px-3 cursor-pointer w-[25%]"
                                         title="view suggestion"
                                         wire:click="selectSuggestion({{ $record->id }})">
                                        {{ showFewFirstPersians($record->description, 20) }}
                                    </div>
                                    {{--departments--}}
                                    <div class="text-center py-2 px-3 w-[35%]">
                                        @unless(is_null($record->department))
                                            @php $managerResponded = false @endphp
                                            @foreach ($record->reviews as $review)
                                                @php $managerResponded = $managerResponded ?: $review->department === 'مدیریت' @endphp
                                                {{--opinion--}}
                                                <div class="flex flex-row cursor-help">
                                                    <div class="w-[10%]"
                                                         title="{{ $review->feedbackPersian() }}">
                                                        {{ $review->feedbackIcon() }}
                                                    </div>
                                                    {{--names--}}
                                                    <div title="{{ $review->department }}"
                                                         class="w-[75%] bg-gray-300 text-center rounded
                                                         @if(isDarkMode()) bg-main @endif
                                                         @if(isUserDep($review->department,$record->user->profile->department)) main-color font-bold @endif">
                                                        {{ showFewFirstPersians($review->department, 12)  }}
                                                    </div>
                                                    {{--feedback--}}
                                                    <div class="w-[10%] cursor-pointer"
                                                         title="view comments"
                                                         wire:click="selectReview({{ $review->id }})">
                                                        {{ '📋' }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-center">تعیین نشده است</span><br>
                                        @endunless
                                        {{--process/action department--}}
                                        @foreach ($record->inProcessReviews as $reviewInProcess)
                                            <br>
                                            @foreach (json_decode($reviewInProcess->referral) as $dep)
                                                @foreach ($record->reviews->filter(function ($recordReview) use ($dep, $suggestion) {
                                                    return $recordReview->department == $suggestion['departmentNames'][$dep];
                                                }) as $review)
                                                    <div class="flex flex-row cursor-help">
                                                        <div
                                                            title="{{ isRelevantDepManager($dep) ? 'end or unnd process' : '' }}"
                                                            class="w-[10%] cursor-pointer {{ isRelevantDepManager($dep) ? '' : 'cursor-help' }}"
                                                            wire:click="{{ isRelevantDepManager($dep) ? 'endProcess(' . $reviewInProcess . ', \'' . $dep . '\')' : '' }}">
                                                            {{ ($review->complete == 'yes') ? '✔' : '⏳'  }}
                                                        </div>
                                                        {{-- names --}}
                                                        <div title="{{ $review->department }}"
                                                             class="w-[75%] bg-main-mode text-center rounded @if (isDarkMode()) bg-main @endif">
                                                            {{ showFewFirstPersians($review->department, 12)  }}
                                                        </div>
                                                        {{-- action --}}
                                                        <div
                                                            @if(isRelevantDepManager($dep) or isManager())
                                                                class="w-[10%] cursor-pointer"
                                                            title="view comments"
                                                            wire:click="selectReview({{ $reviewInProcess->id }},{{ true }})"
                                                            @else
                                                                class="w-[10%] cursor-not-allowed"
                                                            title="no comments"
                                                            @endif
                                                        >
                                                            {{ '📋' }}</div>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </div>
                                    <div class="flex flex-row w-full justify-around">
                                        <div class="text-center py-2 px-3 max-w-[130px] break-words">
                                            {{ $record->stageIcon() }}
                                        </div>
                                        @if($record->self_fill)
                                            <div class="text-center px-1 cursor-help"
                                                 title="feedback given by suggester">
                                                ✔️
                                            </div>
                                        @else
                                            <div class="text-center px-1 cursor-help"
                                                 title="feedback given by others">
                                                ❌
                                            </div>
                                        @endif
                                        <div class="text-center px-1">
                                            @if(!empty($record->attachment))
                                                <a href="{{ $record->attachment }}"
                                                   target="_blank"
                                                   title="click to view">👁️</a>
                                            @else
                                                <span title="nothing to view">🚫</span>
                                            @endif
                                        </div>
                                        <div
                                            @if (canCancelSuggestion($record))
                                                class="text-center px-1 pl-4 cursor-pointer"
                                            title="cancel your suggestion"
                                            wire:click="showConfirmBox('آیا مطمئن هستید که می‌خواهید پیشنهاد خود را لغو کنید؟', 'abortSuggestion({{$record->id}})')"
                                            @else
                                                class="text-center px-1 pl-4 cursor-not-allowed"
                                            title="{{ isSuggestionResponded($record) ?  '! too late to cancel' :'cannot be cancelled' }}"
                                            @endif>
                                            {{ $record->abort == 'yes' ? '✔️' : '❌' }}
                                        </div>
                                        @if(isAborted($record) )
                                            <div
                                                wire:key="aborted-{{ $record->id }}"
                                                class="text-center px-1 pl-4 cursor-not-allowed"
                                                title="no need for response as it is cancelled">❌
                                            </div>
                                        @elseif (isManager())
                                            <div
                                                class="text-center px-1 pl-4 cursor-pointer"
                                                title="{{ $managerResponded ? 'responded' : 'respond to suggestion' }}"
                                                wire:key="manager-response-{{ $record->id }}"
                                                wire:click="{{ $managerResponded ? '' : 'giveResponseTo(' . $record->id . ')' }}">
                                                {{ $managerResponded ? '✔️' : '💬' }}
                                            </div>
                                        @elseif(isDepartmentManager())
                                            @if(hasGivenFeedback($record->id))
                                                <div
                                                    wire:key="feedback-given-{{ $record->id }}"
                                                    class="text-center px-1 pl-4 cursor-not-allowed"
                                                    title="comments already submitted">✔️
                                                </div>
                                            @else
                                                <div wire:key="response-{{ $record->id }}"
                                                     wire:click="giveResponseTo({{ $record->id }})"
                                                     class="text-center px-1 pl-4 cursor-pointer"
                                                     title="please write your comments">💬
                                                </div>
                                            @endif
                                        @else
                                            <div
                                                wire:key="teammates-view-{{ $record->id }}"
                                                class="text-center px-1 pl-4 cursor-not-allowed"
                                                title="view only for teammates">
                                                ❌
                                            </div>

                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="suggestion-links p-2 mt-2">
            {{ $suggestionWithReview->links() }}
        </div>
    </div>
    {{--suggestion box--}}
    @include('livewire.suggestion.suggestion-box')
</div>
