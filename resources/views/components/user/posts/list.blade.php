<div class="flex flex-wrap items-start farsi-module persol-farsi-font">
    <div class="w-full md:w-1/2 text-center p-1">
        @unless(request()->ajax())
            @foreach($pins as $pin)
                <div class="card-link links-thumbnails-color h-auto rounded bg-weekend p-0">
                    <span
                        class="relative top-2 left-1/2 -translate-x-1/2 cursor-help rounded bg-main-mode px-1 py-0 text-xs text-white md:px-2 md:py-1"
                        title="pinned post">
                        <i class="fas fa-thumbtack rotate-[30deg]" aria-hidden="true"></i>
                    </span>
                    <img id="postImage"
                         class="mx-auto max-h-[450px] object-cover"
                         src="{{ $pin->image }}"
                         alt="post"
                         x-data="{ isLandscape: false, ready: false }"
                         x-on:load="isLandscape = $el.naturalWidth > $el.naturalHeight; ready = true;"
                         :class="{ 'w-full': ready && isLandscape }"
                         :style="ready && !isLandscape ? 'max-height: 500px;' : ''"/>

                    <div class="p-4 pt-2">
                        <div class="card-link-text text-justify tracking-wider md:text-center">
                            <p class="font-normal text-sm">
                                {!! $pin->title !!}
                                <span class="main-color ml-2 text-xs">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                        {{ $pin->created_at->format('M d, Y') }}
                                </span>
                            </p>
                        </div>
                        <div class="mt-1 text-center md:mt-4">
                            <p class="post-text mb-4 text-justify text-xs tracking-wide md:text-base">
                                {{ Str::limit(strip_tags($pin->body), 65) }}
                            </p>

                            <a class="user-panel-modal post-link mx-auto block cursor-pointer rounded bg-main-mode px-4 py-1 text-sm text-white shadow-lg hover:opacity-75 md:px-2 md:py-2 md:text-base"
                               @click="
                                showModals=true; showPost=true;
                                postTitle='{{ $pin->title }}';
                                postContent = '{{ str_replace('<a ', '<a target="_blank" ', $pin->body) }}';
                                postImage = '{{ $pin->image }}';
                                postDate='{{ $pin->created_at }}';">
                                بیشتر
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            <a class="user-panel-modal post-link text-sm mt-5 hidden px-4 py-1 rounded cursor-pointer"
               href="#animatedModal"
               @click="showReservation=false; showPost=false">
            </a>
        @endunless
    </div>
    <div class="w-full @if(request()->ajax()) min-w-full @else() md:w-1/2 @endif text-center p-1 flex flex-col">
        <div id="post-list" class="flex flex-wrap flex-none w-full md:w-[750px] mx-auto">
            <x-user.posts.slider :posts="$posts"/>
        </div>
    </div>
</div>
