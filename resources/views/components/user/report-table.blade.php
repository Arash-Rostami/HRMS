<div id="report-list">
    <div class="flex flex-col persol-farsi-font"
         x-data="{ @foreach($reports as $report) isReport{{$report->id}}Open: false, isPdf{{$report->id}}Available: {{ json_encode(file_exists(public_path($report->file_path))) }}, @endforeach }">
        @foreach($reports as $report)
            <div class="w-full card-job links-thumbnails my-1 py-2 pr-2">
                <div class="flex flex-col-reverse md:flex-row justify-center items-center p-2">
                    <div class="w-full md:w-[15%] md:pl-12 mb-4 md:mb-0">
                        <template x-if="!isReport{{$report->id}}Open">
                            <button @click="isReport{{$report->id}}Open = true" title="click to view report"
                                    class="bg-green-800 text-white px-4 py-2 rounded hover:opacity-50 mx-auto">
                                <i class="fas fa-eye"></i>
                                <span class="hidden md:inline-block ml-1">
                            <i class="fas fa-file-pdf mr-2"></i>
                        </span>
                            </button>
                        </template>
                        <template x-if="isReport{{$report->id}}Open">
                            <button @click="isReport{{$report->id}}Open = false" title="click to close report"
                                    class="bg-red-800 text-white px-4 py-2 rounded hover:opacity-50">
                                <i class="fas fa-times"></i>
                                <span class="hidden md:inline-block ml-1">
                            <i class="fas fa-file-pdf mr-2"></i>
                        </span>
                            </button>
                        </template>
                    </div>
                    <div class="w-full md:w-[7%] rtl-direction text-center">
                        <p class="text-gray-500 mb-2" title="{{ $report->department }} Department">
                            {{ getFarsiNameOfDepartment($report->department) }}
                        </p>
                    </div>
                    <div class="w-full md:w-[60%] rtl-direction mx-2">
                        <p class="text-gray-500 mb-2" title="{{ $report->created_at->diffForHumans() }}">
                            {{  strip_tags($report->description) }}
                        </p>
                    </div>
                    <div class="w-full md:w-[15%] rtl-direction">
                        <h3 class="mb-2" title="{{ $report->created_at->diffForHumans() }}">
                            {{ $report->title }}
                        </h3>
                    </div>
                </div>
                <div class="flex w-full h-screen"
                     x-show="isReport{{$report->id}}Open"
                     x-transition:enter.duration.500ms
                     x-transition:leave.duration.600ms>
                    <iframe
                        loading="lazy"
                        class="w-full h-full border-3 border-gray-500 p-10"
                        x-show="isPdf{{$report->id}}Available"
                        src="{{ $report->file_path }}" type="application/pdf">
                        <p class="text-center">
                            برای مشاهده گزارش، نرم‌افزار مشاهده‌کننده PDF را نصب کنید. می‌توانید
                            <a href="{{ $report->file_path }}" target="_blank">
                                اینجا کلیک کنید تا فایل PDF را دانلود
                                کنید.
                            </a>
                        </p>
                    </iframe>
                    <p class="text-center mx-auto rtl-direction"
                       x-show="!isPdf{{$report->id}}Available">
                        فایل PDF موجود نیست.
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    <div id="pagination-reports" class="m-2 w-full pagination pagination-reports" style="direction:ltr!important;">
        {{ $reports->links() }}
    </div>
</div>

