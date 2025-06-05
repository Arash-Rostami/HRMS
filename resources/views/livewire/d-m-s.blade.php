<div x-data="{
        baseUrl: '{{ asset('') }}',
        docId: '',
        searchTerm: @entangle('searchTerm'),
        count: @entangle('readDocs'),
        confirmedDocs: @entangle('confirmedDocs'),
        isModalOpen: false,
        documentContent: '',
        initStyles() {
            $refs.pagination.querySelectorAll('button, span span').forEach(el => el.classList.add('bg-gray-400'));
            return true;
        },
       confirmAndSend(docId, file) {
         if (typeof file === 'string' && file.toLowerCase().includes('pdf')) {
            this.docId = docId;
             this.documentContent = this.baseUrl + 'authorized/' + file;
            this.isModalOpen = true;
        } else {
            // Non-PDF files use the existing confirmation strategy
            const confirmation = confirm('با کلیک بر روی این دکمه، شما تأیید می‌کنید که این سند را خوانده و از محتوای آن مطلع شدید. آیا ادامه می‌دهید؟');
            if (confirmation) {
                $wire.confirmRead(docId).then(() => {
                    this.confirmedDocs.push(this.docId);
                });
               }
            }
        },
        confirmDocument() {
             if (this.docId !='') {
                this.isModalOpen = false;
                $wire.confirmRead(this.docId).then(() => {
                    this.confirmedDocs.push(this.docId);
                });
            }
        },
        incrementRead(docId) {
            $wire.incrementRead(docId).then(() => {
                this.count.push(this.docId);
            });
        }
    }">
    <!-- Modal for PDF Viewing -->
    <div x-show="isModalOpen"
         class="p-4 fixed inset-0 flex items-center justify-center z-50 bg-transparent bg-opacity-75 w-screen overflow-hidden">
        <div class="bg-main p-8 rounded-lg shadow-lg w-3/4 h-full overflow-hidden">
            <button @click="isModalOpen = false" class="float-right text-main-mode" title="Close me">
                <i class="fas fa-times"></i>
            </button>
            <!-- PDF Viewing in iframe without scroll bar -->
            <iframe :src="documentContent" class="w-full h-[calc(100%-4rem)] overflow-hidden" loading="lazy"
                    type="application/pdf"></iframe>
            <div class="flex justify-center w-full mt-4">
                <button @click="confirmDocument" class="bg-main-mode text-white py-2 px-6 rounded persol-farsi-font">
                    تأیید
                </button>
            </div>
        </div>
    </div>
    <div class="mx-auto p-4 rtl-direction persol-farsi-font text-sm md:text-base">
        {{-- Legend --}}
        <div class="mb-4 flex space-x-4 items-center float-left">
            <div class="flex items-center">
                <span class="w-4 h-4 bg-red-500 inline-block rounded-full mx-2"></span>
                <span class="ml-2 text-sm text-red-500"> امضا نشده</span>
            </div>
            <div class="flex items-center">
                <span class="w-4 h-4 bg-gray-500 inline-block rounded-full mx-2"></span>
                <span class="ml-2 text-sm text-gray-500"> خوانده نشده</span>
            </div>
        </div>
        {{-- Search Box --}}
        <div class="mb-4">
            <label>
                <input type="text"
                       x-model="searchTerm"
                       placeholder="جستجو بر اساس عنوان، کد یا نسخه..."
                       class="w-full md:w-1/2 lg:w-1/3 px-4 py-2 border rounded-lg shadow-sm transition-all duration-300 ease-in-out bg-gray-300 @if (isDarkMode()) bg-gray-800 text-primary-50 @endif">
            </label>
            <button
                @click="searchTerm = ''"
                x-show="searchTerm !== ''"
                title="Clear the search"
                class="px-3 py-2 bg-gray-400 hover:bg-gray-500 rounded-lg shadow-sm text-white transition-all duration-200 ease-in-out">
                <i class="fas fa-undo-alt"></i>
            </button>
            <!-- Filter Buttons Row -->
            <div class="flex space-x-2 flex-row flex-wrap">
                @foreach ($types as $type)
                    <button
                        type="button" @click="searchTerm='{{$type}}'"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-500 mt-6 mx-2 @if(isDarkMode()) bg-gray-600 @endif">
                        {{ $type }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Confirmation Message --}}
        @if ($docs->whereNotIn('id', $confirmedDocs)->isNotEmpty())
            <div class="bg-red-200 border-t-4 border-red-700 rounded-b px-4 py-3 shadow-md mb-5" role="alert">
                <div class="flex flex-col md:flex-row">
                    <div class="py-1">
                        <svg class="fill-current h-6 w-6 text-red-700 mr-4" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20">
                            <path
                                d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                        </svg>
                    </div>
                    <div>
                        <br>
                        <p class="text-sm font-bold text-red-900">
                            این اسناد توسط واحد برنامه‌ریزی و بهبود سیستم به طور رسمی صادر شده‌اند. با کلیک بر روی
                            "مشاهده سند"، تأیید می‌کنید که محتوای آن‌ها را مطالعه کرده و از آن مطلع شدید.
                            این اقدام به عنوان امضای دیجیتال، تأیید آگاهی شما از اطلاعات ارائه شده تلقی می‌شود.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto rounded-xl dms-div">
            <table class="min-w-full bg-[--bg-main] rounded-xl main-color">
                <thead class="bg-gray-500 text-main-theme rounded-xl">
                <tr class="rounded-xl">
                    <th class="text-center py-3 px-4 font-semibold">
                        <i class="fas fa-file-alt ml-1"></i><br>
                        عنوان سند
                    </th>
                    <th class="text-center py-3 px-4 font-semibold">
                        <i class="fas fa-code-branch ml-1"></i><br>
                        نسخه
                    </th>
                    <th class="text-center py-3 px-4 font-semibold">
                        <i class="fas fa-file-download ml-1"></i><br>
                        فایل
                    </th>
                    <th class="text-right py-3 px-4 font-semibold max-w-xs">
                        <i class="fas fa-users ml-1"></i><br>
                        واحد (های) ذی نفع
                    </th>
                    <th class="text-center py-3 px-4 font-semibold">
                        <i class="fas fa-info-circle ml-1"></i><br>
                        وضعیت
                    </th>
                    <th class="text-center py-3 px-4 font-semibold">
                        <i class="fas fa-comment-dots ml-1"></i><br>
                        توضیحات
                    </th>
                    <th class="text-center py-3 px-4 font-semibold">
                        <i class="fas fa-eye ml-1"></i><br>
                        تعداد دفعات مشاهده
                    </th>
                </tr>
                </thead>
                <tbody class="text-gray-700 rounded-xl">
                @foreach($docs as $doc)
                    @if($doc)
                        <tr
                            x-bind:class="{
                                        'border-b border-dotted border-b-main rounded-2xl': true,
                                        'text-gray-300': {{ isDarkMode() ? 'true' : 'false' }},
                                        'bg-gradient-to-l from-transparent from-40% via-transparent via-20 to-red-500 to-90% hover:to-red-200 transition ease-in duration-500': !confirmedDocs.includes({{ $doc->id }}) && !count.includes({{ $doc->id }}),
                                        'bg-gradient-to-l from-transparent from-40% via-transparent via-20 to-gray-500 to-90 hover:to-gray-200 transition ease-in duration-500': confirmedDocs.includes({{ $doc->id }}) && !count.includes({{ $doc->id }}),
                                        'bg-transparent': confirmedDocs.includes({{ $doc->id }}) && count.includes({{ $doc->id }})
                                    }">
                            {{-- Title --}}
                            <td class="text-right py-2 px-4">
                                <span class="text-sm text-main" title="Filter based on this Category keyword">
                                     <i class="fas fa-tags mx-1"></i>
                                    <span class="cursor-pointer"
                                          @click="searchTerm='{{optional($doc->extra)['category'] ?? optional($doc->extra)['Category']}}'">
                                    {{ optional($doc->extra)['category'] ?? optional($doc->extra)['Category'] ?? 'بدون دسته‌بندی' }}
                                    </span>
                                </span>
                                <hr class="my-2 w-1/2 @if(isDarkMode()) opacity-50 @endif">
                                <span class="text-md md:text-lg">
                                {{ $doc->title ?? 'بدون عنوان' }}
                                </span>
                            </td>
                            {{-- Version --}}
                            <td class="text-right py-2 px-4 ltr-direction">
                                {{ $doc->code ?? '' }} - {{ $doc->version ?? 'N/A' }}
                            </td>
                            {{-- File --}}
                            <td class="text-center py-2 px-4 whitespace-nowrap">
                                @if ($doc->file)
                                    @if(in_array($doc->id, $confirmedDocs))
                                        <span class="text-center">
                                            <i class="fas fa-search"></i>
                                        </span><br>
                                        <a href="{{ route('secure-file', $doc->file) }}" target="_blank"
                                           @click="incrementRead({{ $doc->id }})"
                                           class="text-blue-500 underline">
                                            مشاهده سند
                                        </a>
                                    @else
                                        <span class="text-center">
                                        <i class="fas fa-file-signature"></i>
                                        </span><br>
                                        <button @click="confirmAndSend( {{ $doc->id }},  '{{ $doc->file }}' )"
                                                class="text-blue-500 underline">
                                            تأیید خواندن سند
                                        </button>
                                    @endif
                                @else
                                    فایل موجود نیست
                                @endif
                            </td>
                            {{-- Owners --}}
                            <td class="text-right py-2 px-4 max-w-xs truncate cursor-pointer"
                                title=" {!! $doc->getAllDepartmentNamesInFarsi() ?: 'بدون مالک' !!} ">
                                {!! $doc->getAllDepartmentNamesInFarsi() ?: 'بدون مالک' !!}
                            </td>
                            {{-- Status --}}
                            <td class="text-center py-2 px-4 cursor-pointer" title="{{ $doc->getStatusInFarsi() }}">
                                {!!  $doc->getStatusIcon() ?? 'N/A' !!}
                            </td>
                            {{-- Revision Comments --}}
                            <td class="text-right py-2 px-4">
                                {{ $doc->revision ?? 'بدون توضیح' }}
                            </td>
                            {{-- Read Count --}}
                            <td class="text-right py-2 px-4">
                                {{ $doc->reads->sum('read_count') ?? 0 }}
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="rounded-xl px-3">
        <div class="mt-4"
             x-init="$el.querySelectorAll('button, span span').forEach(button => button.classList.add('bg-main-mode', 'text-main-theme'))"
             x-effect="$el.querySelectorAll('button, span span').forEach(button => button.classList.add('bg-main-mode', 'text-main-theme'))">
            {{ $docs->links() }}
        </div>
    </div>
</div>
