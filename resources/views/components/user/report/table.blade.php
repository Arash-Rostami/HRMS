@php
      // prepare for PDF report viewer
        $reportsState = [];
        foreach ($reports as $report) {
            $reportsState[$report->id] = [
                'open' => false,
                'pdfAvailable' => file_exists(public_path($report->file_path))
            ];
        }
@endphp
<div id="report-list">
    <div class="flex flex-col persol-farsi-font"
         x-data="{ reportsState: {{ json_encode($reportsState) }} }">
        @foreach($reports as $report)
            <div class="w-full card-job links-thumbnails my-1 py-2 pr-2">
                <div class="flex flex-col md:flex-row justify-center items-center p-2">

                    <div class="w-full md:w-[7%] text-center">
                        <p class="text-gray-500 mb-2" title="{{ $report->department }} Department">
                            {{ getFarsiNameOfDepartment($report->department) }}
                        </p>
                    </div>

                    <div class="w-full md:w-[60%]  mx-2">
                        <p class="text-gray-500 mb-2" title="{{ $report->created_at->diffForHumans() }}">
                            {{  strip_tags($report->description) }}
                        </p>
                    </div>

                    <div class="w-full md:w-[15%]">
                        <h3 class="mb-2" title="{{ $report->created_at->diffForHumans() }}">
                            {{ $report->title }}
                        </h3>
                    </div>

                    <div class="w-full md:w-[15%] md:pl-12 mb-4 md:mb-0 text-left">
                        <template x-if="!reportsState[{{ $report->id }}].open">
                            <button @click="reportsState[{{ $report->id }}].open = true"
                                    title="click to view report"
                                    class="bg-main-mode p-2 md:px-2 md:py-1 shadow-lg rounded text-white px-4 py-2 hover:opacity-50 mx-auto">
                                <i class="fas fa-eye"></i>
                                <span class="hidden md:inline-block ml-1"><i class="fas fa-file-pdf mr-2"></i></span>
                            </button>
                        </template>
                        <template x-if="reportsState[{{ $report->id }}].open">
                            <button @click="reportsState[{{ $report->id }}].open = false"
                                    title="click to close report"
                                    class="bg-red-800 text-white px-4 py-2 rounded hover:opacity-50">
                                <i class="fas fa-times"></i>
                                <span class="hidden md:inline-block ml-1"><i class="fas fa-file-pdf mr-2"></i></span>
                            </button>
                        </template>
                    </div>
                </div>
                <div class="flex w-full h-screen"
                     x-show="reportsState[{{ $report->id }}].open"
                     x-transition:enter.duration.500ms
                     x-transition:leave.duration.600ms>
                    <iframe loading="lazy"
                            class="w-full h-full border-3 border-gray-500 p-10"
                            x-show="reportsState[{{ $report->id }}].pdfAvailable"
                            src="{{ $report->file_path }}"
                            type="application/pdf">
                    </iframe>
                    <p class="text-center mx-auto rtl-direction"
                       x-show="!reportsState[{{ $report->id }}].pdfAvailable">
                        فایل PDF موجود نیست.
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    <div id="pagination-reports"
         dir="ltr"
         class="m-2 w-full pagination pagination-reports">
        {{ $reports->links() }}
    </div>
</div>
