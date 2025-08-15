<div class="mb-4 float-left md:w-1/5 w-1/2" dir="ltr">
    <div class="relative" data-te-input-wrapper-init>
        <input id="filter-input"
               type="search"
               class="peer block min-h-[auto] w-full rounded bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:links-thumbnails data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0 links-thumbnails remove-border"
        />
        <label for="filter-input"
            @class([
                'pointer-events-none absolute right-4 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-gray-600 transition-all duration-200 ease-out peer-focus:-translate-y-[1.5rem] peer-focus:scale-[0.8] peer-focus:links-thumbnails peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none',
                'text-gray-200'=> isDarkMode(),
                 ])>
            جستجو ⌕
        </label>
    </div>
</div>
