@if($selectedTicket)
    <div x-data="{ isClosing: false}" x-cloak
         x-bind:class="{ 'animate-[fade-in-down_1s_ease-in-out]': !isClosing, 'animate-[fade-out_1s_ease-in-out]': isClosing }"
         class="relative inset-0 bg-opacity-75 flex justify-center items-center py-4 px-0 animate-[fade-in-down_1s_ease-in-out]
        rtl-direction persol-farsi-font">
        <div class="rounded-lg w-full max-w-4xl p-6 lg:p-8 shadow-full">
            <div class="flex justify-between items-center mb-4 ltr-direction">
                <h3 class="text-md md:text-xl font-bold text-main-mode cursor-help" title="Ticket Number">
                    🎫
                    <span title=" {{  $this->getFormattedTimeStamp($selectedTicket, 'created_at')  }}">
                      {{ $this->getFormattedTicketId($selectedTicket)  }}
                    </span>
                </h3>
                <button class="text-gray-500 hover:text-gray-700"
                        @click="isClosing = true; setTimeout(() => $wire.set('selectedTicket', null), 500)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- Tabs -->
            <div class="border-b border-gray-200 mb-6 rtl-direction">
                <nav class="flex space-x-4 justify-around">
                    <button wire:click="$set('activeTab', 'request')"
                            class="px-4 py-2 rounded-md shadow focus:outline-none bg-gray-400 text-gray-700 font-bold
                            @if($activeTab === 'request') bg-main-mode @endif">
                        <i class="fas fa-file-alt ml-2"></i> درخواست
                    </button>
                    <button
                            wire:click="$set('activeTab', 'response')"
                            class="px-4 py-2 rounded-md shadow focus:outline-none bg-gray-400 text-gray-700 font-bold
                        @if($activeTab === 'response') bg-main-mode @endif">
                        <i class="fas fa-reply ml-2"></i> پاسخ
                    </button>
                </nav>
            </div>
            <!-- Tab Content -->
            <div>
                @if($activeTab === 'request')
                    <!-- Request Tab -->
                    <div class="space-y-12 mb-7">
                        <p>
                            <strong class="p-4 ml-4 text-main-mode">حوزه درخواست:</strong>
                            @if($selectedTicket['request_type'] == 'access')
                                Access to
                            @else
                                Support for
                            @endif
                            {{ $this->getRequestAreaLabel($selectedTicket['request_type'], $selectedTicket['request_area']) }}
                        </p>
                        <p>
                            <strong class="p-4 ml-4 text-main-mode">موضوع:</strong>
                            {{ $selectedTicket['request_subject'] ?? '' }}
                        </p>
                        <p class="text-justify">
                            <strong class="p-4 ml-4 text-main-mode">توضیحات:</strong>
                            {{ $selectedTicket['description'] ?? '' }}
                        </p>
                        <!-- Requester Files Preview -->
                        @if(!empty($selectedTicket['requester_files']))
                            <div class="flex flex-wrap space-x-4 mt-4 cursor-pointer">
                                <strong class="w-full text-main-mode mb-2">فایل‌های ضمیمه:</strong>
                                @foreach($selectedTicket['requester_files'] as $file)
                                    <div class="w-16 h-16 bg-gray-400 border rounded-md overflow-hidden">
                                        @if(Str::contains($file['file'], ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset( $file['file']) }}"
                                                 title="View attachment" alt="Attachment" data-lity
                                                 class="object-cover w-full h-full">
                                        @else
                                            <a href="{{ asset($file['file']) }}" target="_blank"
                                               title="Download or view file">
                                                <i class="fas fa-file text-gray-600 text-2xl flex items-center justify-center w-full h-full"></i>
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="flex justify-content-evenly w-full p-4 pt-8 mt-8">
                        <div class="flex items-center cursor-help" title="وضعیت">
                            @if($selectedTicket['status'] === 'open')
                                <i class="fas fa-circle text-green-500 ml-2 animate-pulse" title="باز"></i>
                                <span class="text-green-600 font-semibold">باز</span>
                            @elseif($selectedTicket['status'] === 'in-progress')
                                <i class="fas fa-spinner text-yellow-500 ml-2 animate-spin" title="در حال انجام"></i>
                                <span class="text-yellow-600 font-semibold">در حال انجام</span>
                            @elseif($selectedTicket['status'] === 'closed')
                                <i class="fas fa-check-circle text-gray-500 ml-2" title="بسته شده"></i>
                                <span class="text-gray-600 font-semibold">بسته شده</span>
                            @endif
                        </div>
                        <div class="flex items-center cursor-help" title="اولویت">
                            @if($selectedTicket['priority'] === 'low')
                                <i class="fas fa-exclamation-triangle text-green-500 ml-2" title="کم"></i>
                                <span class="text-green-600 font-semibold">کم</span>
                            @elseif($selectedTicket['priority'] === 'medium')
                                <i class="fas fa-exclamation-triangle text-yellow-500 ml-2" title="متوسط"></i>
                                <span class="text-yellow-600 font-semibold">متوسط</span>
                            @elseif($selectedTicket['priority'] === 'high')
                                <i class="fas fa-exclamation-triangle text-red-500 ml-2" title="زیاد"></i>
                                <span class="text-red-600 font-semibold">زیاد</span>
                            @endif
                        </div>
                        <div class="flex items-center ltr-direction cursor-help" title="تاریخ ایجاد">
                            <span
                                    class="text-blue-500">{{ $this->getFormattedTimeStamp($selectedTicket,'created_at') }}</span>
                            <i class="fas fa-calendar-alt text-blue-500 ml-2"></i>
                        </div>
                    </div>
                @elseif($activeTab === 'response')
                    <!-- Response Tab -->
                    <div class="space-y-12 mb-7">
                        <p>
                            <strong class="p-4 ml-4 text-main-mode">مسئول:</strong>
                            {{ optional($selectedTicket['assignee'])['forename'] ?? '' }} {{ optional($selectedTicket['assignee'])['surname'] ?? 'اختصاص نیافته است' }}
                        </p>
                        <p>
                            <strong class="p-4 ml-4 text-main-mode text-justify">نتیجه عملیات:</strong>
                            {{ $selectedTicket['action_result'] ?? 'نامشخص' }}
                        </p>
                        <!-- Assignee Files Preview -->
                        @if(!empty($selectedTicket['assignee_files']))
                            <div class="flex flex-wrap space-x-4 mt-4">
                                <strong class="w-full text-main-mode mb-2">فایل‌های ضمیمه:</strong>
                                @foreach($selectedTicket['assignee_files'] as $file)
                                    <div class="w-16 h-16 bg-gray-400 border rounded-md overflow-hidden cursor-pointer">
                                        @if(Str::contains($file['file'], ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset($file['file']) }}"
                                                 alt="Attachment" title="View attachment" data-lity
                                                 class="object-cover w-full h-full">
                                        @else
                                            <a href="{{ asset($file['file']) }}" target="_blank"
                                               title="Download or view file">
                                                <i class="fas fa-file text-gray-600 text-2xl flex items-center justify-center w-full h-full"></i>
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="flex justify-content-evenly w-full p-4 pt-8 mt-8">
                        <div class="flex items-center ltr-direction">
                            <p class="cursor-help text-blue-500 ltr-direction" title="تاریخ تکمیل">
                                {{ $this->getFormattedTimeStamp($selectedTicket,'completion_date') ?? 'نامشخص' }}
                                <i class="fas fa-calendar-alt text-blue-500 ml-2"></i>
                            </p>
                        </div>
                        <div class="flex items-center">
                            <p class="cursor-help" title="امتیاز رضایت">
                                {!!  str_repeat('<i class="fas fa-star text-yellow-500 "></i>', number_format($selectedTicket['satisfaction_score'], 0))  !!}
                            </p>
                        </div>
                        <div class="flex items-center">
                            <p class="cursor-help text-success-500" title="اثربخشی">
                                <i class="fas fa-chart-line ml-2"></i>
                                {!!  str_repeat('၊|', number_format($selectedTicket['effectiveness'], 0))  !!}

                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
