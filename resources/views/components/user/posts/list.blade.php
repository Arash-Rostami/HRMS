<div class="flex flex-col lg:flex-row farsi-module persol-farsi-font justify-evenly gap-3">
    <div class="flex-shrink-1 flex-grow-1 lg:w-1/2">
        @unless(request()->ajax())
            @foreach($pins as $pin)
                <div class="card-link links-thumbnails-color h-auto rounded bg-weekend p-0 flex flex-col">
                    <span title="پست پین شده"
                          class="relative flex flex-grow-0 justify-center w-7 top-2 cursor-help rounded text-main px-1 py-0 md:p-2 backdrop-blur-sm">
                        <i class="fas fa-thumbtack rotate-[30deg] mx-auto" aria-hidden="true"></i>
                    </span>
                    <img id="postImage"
                         class="rounded-2xl p-2 mx-auto max-h-[350px] object-cover transform transition duration-500 ease-in-out hover:scale-[1.02] hover:brightness-110 hover:saturate-125"
                         src="{{ $pin->image }}"
                         alt="post"
                         loading="lazy"
                         decoding="async"
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
                                {!! Str::limit(strip_tags($pin->body), 65)  !!}
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
                    <a class="user-panel-modal post-link text-sm mt-5 hidden px-4 py-1 rounded cursor-pointer"
                       href="#animatedModal"
                       @click="showReservation=false; showPost=false">
                    </a>
                </div>
            @endforeach
        @endunless
    </div>
    <div id="post-list"
         class="flex flex-col flex-shrink-1 flex-grow-1 @if(request()->ajax()) min-w-full overflow-x-hidden @else() lg:w-1/2 @endif ">
        <div class="flex flex-col sm:flex-row justify-evenly">
            <x-user.posts.slider :posts="$posts"/>
        </div>
        <div class="flex flex-row justify-evenly">
            <nav class="m-2 w-full pagination pagination-posts" style="direction: ltr !important;">
                {{ $posts->links() }}
            </nav>
        </div>
    </div>
</div>
