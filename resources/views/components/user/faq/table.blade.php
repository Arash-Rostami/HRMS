{{--filter the result--}}
<div class="flex flex-col">
    {{--    filter by searching--}}
    <div class="mb-4 ml-auto md:w-1/5 w-1/2 persol-farsi-font flex" dir="ltr">
        <div class="relative flex-1" data-te-input-wrapper-init>
            <input type="search"
                   class="peer block min-h-[auto] w-full rounded bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all
    duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:links-thumbnails data-[te-input-state-active]:placeholder:opacity-100
    motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:links-thumbnails
    [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0 links-thumbnails remove-border text-right"
                   id="filter-input-faq"/>
            <label for="filter-input-faq"
                   class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6]
    text-gray-400 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8]
    peer-focus:links-thumbnails peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8]
    motion-reduce:transition-none">جستجو</label>
        </div>
    </div>
    {{--    filter by selecting tags/categories--}}
    <div class="flex flex-row flex-wrap ml-auto px-3 pb-6 gap-1">
        <button onclick="filterContent('all')"
                class="px-2 py-2 text-sm bg-main-mode text-white rounded-lg hover:opacity-70 border-r border-white">
            همه
        </button>
        @foreach($faqs->unique('category') as $faq)
            <button @click="filterContent('{{ $faq->category }}')"
                    class="px-2 py-2 text-sm bg-main-mode text-white rounded-lg hover:opacity-70 border-r border-white">
                {{ $faq->category }}
            </button>
        @endforeach
    </div>
</div>
{{--    Q & A --}}
<div id="accordionFAQ" class="space-y-2">
    @foreach($faqs as $faq)
        <div data-category="{{ $faq->category }}"
             class="faqs faq-container rounded-t-lg border links-thumbnails  bg-[--bg-main]
             rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
            <h2 class="mb-0" id="heading{{ $faq->id }}">
                <button
                    @class([
                    'group relative flex w-full items-center px-5 py-4 text-left transition-all duration-300',
                    'text-gray-800 bg-white hover:text-blue-600 font-medium',
                    'text-gray-100 bg-main-theme hover:text-blue-300' => isDarkMode(),
                        'rounded-t-xl' => !$loop->first
                    ])
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
                <div class="px-5 py-4 faq-search max-w-none"
                >{!! str_replace('<a ', '<a target="_blank" ', $faq->answer) !!}</div>
            </div>
        </div>
    @endforeach
</div>
