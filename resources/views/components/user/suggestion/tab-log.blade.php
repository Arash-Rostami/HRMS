@php
    $thClass = 'py-2 px-4 border-b';
    $tdBase = 'py-2 px-4 border-b border-dotted border-b-main';

    $headers = [
        ['icon' => 'fas fa-quote-right',    'label' => 'عنوان',           'visible' => ''],
        ['icon' => 'fas fa-file-alt',         'label' => 'توضیحات',         'visible' => ''],
        ['icon' => 'fas fa-users',         'label' => 'نظر ذینفعان',            'visible' => ''],
        ['icon' => 'fas fa-info-circle',      'label' => 'وضعیت',          'visible' => 'hidden md:table-cell'],
        ['icon' => 'fas fa-user-check',       'label' => 'پرشده شخصی',      'visible' => 'hidden lg:table-cell'],
        ['icon' => 'fas fa-paperclip',        'label' => 'پیوست',          'visible' => 'hidden lg:table-cell'],
        ['icon' => 'fas fa-times-circle',     'label' => 'لغو',             'visible' => 'hidden lg:table-cell'],
        ['icon' => 'fas fa-comment-dots',     'label' => 'پاسخ',            'visible' => ''],
    ];
@endphp

<div x-show="activeTab === 'sent'"
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-500"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">

    <h1 class="p-2 text-justify leading-relaxed">
        <i class="fa fa-exclamation-triangle text-yellow-500 mr-2"></i>
        برای مشاهده پیشنهادها یا بازخوردها، لطفاً روی عنوان پیشنهاد یا نام واحد کلیک کنید تا بازخوردهای مرتبط نمایش داده
        شوند.
    </h1>
    <div
        class="overflow-x-hidden rounded-lg shadow-md my-3 @if(isDarkMode()) hover:bg-gray-900/20 @else hover:bg-gray-200 @endif">
        <table class="min-w-full">
            <colgroup>
                <col class="md:w-[20%]"> <!-- title -->
                <col class="md:w-[10%]"> <!-- description -->
                <col class="md:w-[25%]"> <!-- departments -->
                <col class="md:w-[5%]">  <!-- status -->
                <col class="md:w-[5%]">  <!-- autofill -->
                <col class="md:w-[5%]">  <!-- attachment -->
                <col class="md:w-[5%]">  <!-- cancel -->
                <col class="md:w-[5%]">  <!-- respond -->
            </colgroup>
            <thead class="bg-gray-400 text-gray-700 text-right">
            <tr>
                @foreach($headers as $h)
                    <th class="{{ $thClass }} {{ $h['visible'] }}">
                        <i class="{{ $h['icon'] }} ml-1 it"></i>
                        <br>
                        {{ $h['label'] }}
                    </th>
                @endforeach
            </tr>
            </thead>

            <tbody>
            @foreach($suggestionWithReview->groupBy('title') as $title => $records)
                @foreach($records as $record)
                    @php
                        $backgroundClass = isAborted($record)
                            ? 'bg-gradient-to-r from-gray-500 via-transparent to-transparent bg-repeat-x bg-size-[2px] h-[100%]'
                            : (isAwaitingDecision($record) ? 'bg-gradient-to-r from-orange-500 via-transparent to-transparent bg-repeat-x bg-size-[2px] h-[100%]' : '');
                        $managerResponded = false;
                        foreach ($record->reviews as $review) {
                            if ($review->department === 'مدیریت') {
                                $managerResponded = true;
                                break;
                            }
                        }
                    @endphp
                    <tr @class([
                        'hover:bg-gray-900/20' => isDarkMode(),
                        'hover:bg-gray-200'    => !isDarkMode(),
                        $backgroundClass
                        ])
                        title="{{ (isAborted($record)) ? 'پیشنهاد توسط پیشنهاد دهنده کنسل شد' : '' }}">
                        @if($loop->first)
                            <td class="{{ $tdBase }} align-top" rowspan="{{ $records->count() }}">
                                <img class="h-12 w-12 rounded-full object-cover"
                                     title="{{ $record->user->forenameInitials }}"
                                     src="{{ $record->user->profile->image }}"
                                     alt="profile">
                                <div>
                                    <div class="font-medium">{{ $record->user->full_name }}</div>
                                    <div class="text-gray-500 text-xs">{{ $record->user?->profile->department }}</div>
                                </div>
                                <br>
                                <span
                                    class="text-main-mode cursor-help font-semibold flex items-center text-xs md:text-base"
                                    title="تعداد رکوردهای مرتبط">
                                    {!! str_repeat('<i class="fas fa-star"></i>', $records->count()) !!}
                                </span>
                                <span class="cursor-help" title="{{ $title }}">
                                    {{ Str::limit($title, 40) }}
                                </span>
                            </td>
                        @endif
                        {{--Description--}}
                        <td class="{{ $tdBase }} cursor-pointer"
                            title="مشاهده پیشنهاد"
                            wire:click="selectSuggestion({{ $record->id }})">
                            {{ showFewFirstPersians($record->description, 15) }}
                            <span class="cursor-pointer">
                                <i class="fas fa-eye text-xs"></i>
                            </span>
                        </td>
                        {{-- Departments --}}
                        <td class="{{ $tdBase }} align-top text-xs w-full md:w-auto">
                            @unless(is_null($record->department))
                                {{-- Section 1: Official Departmental Reviews --}}
                                <div class="rounded-lg p-2" title="مشاهده نظر">
                                    <div class="font-semibold mb-2">نظرات ثبت شده:</div>
                                    <div class="space-y-0">
                                        @forelse ($record->reviews->unique('department') as $review)
                                            <a href="#" wire:click.prevent="selectReview({{ $review->id }})"
                                               class="flex justify-between items-center group p-1 rounded-md">
                                            <span @class([
                                                   'text-xs font-medium p-2 rounded-lg flex items-center bg-gray-300',
                                                   'bg-gray-700' => isDarkMode(),
                                                   'bg-green-200' => $review->feedback === 'agree',
                                                   'bg-red-100' => $review->feedback === 'disagree',
                                                   'bg-green-900' => $review->feedback === 'agree' && isDarkMode(),
                                                   'bg-red-900 ' => $review->feedback === 'disagree' && isDarkMode(),
                                                    ])>
                                                <span class="mr-1">{{ $review->feedbackIcon() }}</span>
                                                <span class="text-justify md:hidden">
                                                    {{ showFewFirstPersians($review->department, 12) }}
                                                </span>
                                                <span class="text-justify hidden md:block">
                                                    {{ $review->department }}
                                                </span>
                                                @if(isUserDep($review->department, $record->user?->profile->department))
                                                    <span class="text-xs relative bottom-3 -rotate-90">📌</span>
                                                @endif
                                            </span>
                                                <i class="fa fa-eye  "></i>
                                            </a>
                                            @unless($loop->last)
                                                <hr class="my-6 border-0 border-dotted border-t-[1.5px] border-gray-400 bg-gradient-to-r from-transparent via-gray-400 to-transparent">
                                            @endunless
                                        @empty
                                            <span class="text-gray-500">موردی ثبت نشده است.</span>
                                        @endforelse
                                    </div>
                                </div>
                            @endunless
                            {{-- Section 2: Action & Referral Workflow --}}
                            @if(!$record->inProcessReviews->isEmpty())
                                <div class="rounded-lg p-2 mt-2">
                                    <div class="font-semibold mb-2">در حال بررسی
                                        توسط:
                                    </div>
                                    <div class="space-y-0">
                                        @foreach ($record->inProcessReviews as $reviewInProcess)
                                            @foreach (json_decode($reviewInProcess->referral) as $dep)
                                                @foreach ($record->reviews->filter(function ($recordReview) use ($dep, $suggestion) {
                                                    return $recordReview->department == $suggestion['departmentNames'][$dep];
                                                }) as $review)
                                                    <div class="flex justify-between items-center p-1">
                                                        <div class="flex items-center">
                                                        <span
                                                            title="{{ $review->complete == 'yes' ? 'تکمیل شده' : 'در انتظار' }}"
                                                            @class([
                                                               'text-xs font-medium p-2 rounded-lg flex items-center bg-gray-300 cursor-help',
                                                               'bg-gray-700' => isDarkMode(),
                                                               'bg-green-200' =>$review->complete == 'yes',
                                                               'bg-yellow-200' => $review->complete == 'no',
                                                               'bg-green-900' => $review->complete == 'yes' && isDarkMode(),
                                                               'bg-yellow-900 ' => $review->complete == 'no' && isDarkMode(),
                                                                ])>
                                                            {{ $review->complete == 'yes' ? '✔' : '⏳' }}
                                                            {{ showFewFirstPersians($review->department, 12) }}
                                                            @if(isUserDep($review->department, $record->user?->profile->department))
                                                                <span class="text-xs relative bottom-3 -rotate-90">
                                                                    📌
                                                                </span>
                                                            @endif
                                                        </span>
                                                        </div>
                                                        <div class="flex items-center">
                                                            @if(isRelevantDepManager($dep))
                                                                <button title="اعلام پایان پروسه"
                                                                        class="ml-1 {{ !isRelevantDepManager($dep) ? 'cursor-help' : '' }}"
                                                                        wire:click="endProcess({{ $reviewInProcess }}, '{{ $dep }}')">
                                                                    <i class="fa fa-stop-circle"></i>
                                                                </button>
                                                            @endif
                                                            @if(isRelevantDepManager($dep) or isManager())
                                                                <button
                                                                    class="mr-1"
                                                                    wire:click="selectReview({{ $reviewInProcess->id }}, true)"
                                                                    title="مشاهده نظرات">
                                                                    <i class="fa fa-eye  "></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @unless($loop->last)
                                                        <hr class="my-6 border-0 border-dotted border-t-[1.5px] border-gray-400 bg-gradient-to-r from-transparent via-gray-400 to-transparent">
                                                    @endunless
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </td>
                        {{-- Status --}}
                        <td class="{{ $tdBase }} hidden md:table-cell text-center" title="وضعیت فعلی">
                            {{ $record->stageIcon() }}
                        </td>
                        {{-- Auto fill --}}
                        <td class="{{ $tdBase }} hidden lg:table-cell text-center cursor-help">
                            @if($record->self_fill)
                                <span title="بازخورد داده شده توسط پیشنهاد دهنده"><i class="fas fa-check"></i></span>
                            @else
                                <span title="بازخورد داده شده توسط دیگران"><i class="fas fa-times"></i></span>
                            @endif
                        </td>
                        {{-- Attachment --}}
                        <td class="{{ $tdBase }} hidden lg:table-cell text-center">
                            @if(!empty($record->attachment))
                                <a href="{{ $record->attachment }}" target="_blank" title="مشاهده پیوست"
                                   class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @else
                                <span title="بدون ضمیمه" class="text-gray-400">
                                    <i class="fas fa-ban"></i>
                                </span>
                            @endif
                        </td>
                        {{-- Cancel --}}
                        <td class="{{ $tdBase }} text-center hidden lg:table-cell">
                             <span @if(canCancelSuggestion($record))
                                       class="cursor-pointer"
                                   title="لغو پیشنهاد"
                                   wire:click="showConfirmBox('آیا مطمئن هستید که می‌خواهید پیشنهاد خود را لغو کنید؟', 'abortSuggestion({{$record->id}})')"
                                   @else
                                       class="cursor-not-allowed"
                                   title="{{ isSuggestionResponded($record) ? 'فرصت کنسل پایان یافته' : 'غیر قابل کنسل' }}"
                                   @endif>
                                 <i class="fas {{ $record->abort == 'yes' ? 'fa-check' : 'fa-times' }}"></i>
                             </span>
                        </td>
                        {{-- Respond --}}
                        <td class="{{ $tdBase }} text-center">
                            @if(isAborted($record) )
                                <span class="cursor-not-allowed" title="کنسل شده و بدون نیاز به پاسخ">
                                    <i class="fas fa-comment-slash text-gray-400"></i>
                                </span>
                            @elseif (isManager())
                                <span class="{{ $managerResponded ? 'cursor-default' : 'cursor-pointer' }}"
                                      title="{{ $managerResponded ? 'پاسخ داده شده' : 'پاسخ' }}"
                                      wire:click="{{ $managerResponded ? '' : 'giveResponseTo(' . $record->id . ')' }}">
                                   @if($managerResponded)
                                        <i class="fas fa-check"></i>
                                    @else
                                        <i class="fas fa-comment-dots"></i>
                                    @endif
                                </span>
                            @elseif(isDepartmentManager())
                                @if(hasGivenFeedback($record->id))
                                    <span class="cursor-not-allowed" title="نظرات ارسال شده">
                                        <i class="fas fa-check"></i>
                                    </span>
                                @else
                                    <span class="cursor-pointer"
                                          title="ثبت نظرات"
                                          wire:click="giveResponseTo({{ $record->id }})"><i
                                            class="fas fa-comment-dots"></i>
                                    </span>
                                @endif
                            @else
                                <span class="cursor-not-allowed" title="مشاهده برای هم واحدی ها">
                                    <i class="fas fa-eye-slash text-gray-400"></i>
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="rounded-xl px-3" dir="ltr">
        <div class="mt-4"
             x-data="{
                 applyTheme() {
                   this.$el.querySelectorAll('button, span span')
                     .forEach(el => el.classList.add('bg-main-mode', 'text-main-theme'));
                 }
               }"
             x-init="applyTheme()"
             x-effect="applyTheme()">
            {{ $suggestionWithReview->links('vendor.livewire.simple-tailwind') }}
        </div>
    </div>
    @include('components.user.suggestion.suggestion-box')
</div>
