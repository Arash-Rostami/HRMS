{{--filter the result--}}
<div class="flex flex-col">
    {{--    filter by searching--}}
    <div class="mb-4 ml-auto md:w-1/5 w-1/2 persol-farsi-font flex">
        <div class="relative flex-1" data-te-input-wrapper-init>
            <input type="search" class="peer block min-h-[auto] w-full rounded bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all
    duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:links-thumbnails data-[te-input-state-active]:placeholder:opacity-100
    motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:links-thumbnails
    [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0 links-thumbnails remove-border text-right"
                   id="filter-input-faq"/>
            <label for="filter-input-faq" class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6]
    text-gray-600 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8]
    peer-focus:links-thumbnails peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8]
    motion-reduce:transition-none  @if ( isDarkMode()) text-gray-200 @endif">جستجو</label>
        </div>
    </div>
    {{--    filter by selecting tags/categories--}}
    <div class="flex flex-row-reverse flex-wrap ml-auto px-3 pb-6 gap-1">
        <button onclick="filterContent('all')"
                class="px-2 py-2 text-sm bg-main-mode text-white rounded-lg hover:opacity-70 border-r border-white persol-farsi-font">
            همه
        </button>
        @foreach($faqs->unique('category') as $faq)
            <button @click="filterContent('{{ $faq->category }}')"
                    class="px-2 py-2 text-sm bg-main-mode text-white rounded-lg hover:opacity-70 border-r border-white persol-farsi-font">
                {{ $faq->category }}
            </button>
        @endforeach
    </div>
</div>

<div id="accordionFAQ" class="rtl-direction persol-farsi-font">
    @foreach($faqs as $faq)
        <div data-category="{{ $faq->category }}"
             class="faqs faq-container rounded-t-lg border links-thumbnails  bg-[--bg-main]">
            <h2 class="mb-0" id="heading{{ $faq->id }}">
                <button
                    class="group faq-search relative flex w-full items-center rounded-t-[15px] border-0 px-5 py-4 text-right text-base transition [overflow-anchor:none] hover:z-[2] focus:z-[3] focus:outline-none  @if ( isDarkMode()) bg-main-theme @endif [&:not([data-te-collapse-collapsed])]:bg-white [&:not([data-te-collapse-collapsed])]:text-primary [&:not([data-te-collapse-collapsed])]:[box-shadow:inset_0_-1px_0_rgba(229,231,235)]  dark:[&:not([data-te-collapse-collapsed])]:text-primary-400 dark:[&:not([data-te-collapse-collapsed])]:[box-shadow:inset_0_-1px_0_rgba(75,85,99)]"
                    type="button"
                    data-te-collapse-init
                    data-te-collapse-collapsed
                    data-te-target="#collapse{{ $faq->id }}"
                    aria-expanded="false"
                    aria-controls="collapse{{ $faq->id }}">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                              d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    &nbsp; {!! $faq->question !!}
                    <span
                        class="mr-auto h-5 w-5 shrink-0 rotate-[180deg] fill-[#336dec] transition-transform duration-200 ease-in-out group-[[data-te-collapse-collapsed]]:rotate-0 group-[[data-te-collapse-collapsed]]:fill-[#212529] motion-reduce:transition-none dark:fill-blue-300 dark:group-[[data-te-collapse-collapsed]]:fill-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor"
                     class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                </svg>
            </span>
                </button>
            </h2>
            <div class="!visible hidden" id="collapse{{ $faq->id }}"
                 data-te-collapse-item
                 data-te-collapse-show
                 aria-labelledby="heading{{ $faq->id }}"
                 data-te-parent="#accordionFAQ">
                <div class="px-5 py-4 faq-search">{!! str_replace('<a ', '<a target="_blank" ', $faq->answer) !!}</div>
            </div>
        </div>
    @endforeach
</div>
