<div class="flex flex-wrap h-auto farsi-module persol-farsi-font">
    {{-- main news--}}
    <div class="w-full md:w-1/2 text-center p-1" style="height: 125%;">
        @foreach($pins as $pin)
            <div class="card-link rounded links-thumbnails links-thumbnails-color h-auto p-0 bg-weekend">
                <span
                    class="relative top-2 left-1/2 bg-main-mode text-white text-xs px-1 py-0 md:px-2 md:py-1 rounded cursor-help"
                    title="pinned post"><i class="fas fa-thumbtack transform rotate-[30deg]" aria-hidden="true"></i></span>
                <img id="postImage" class="mx-auto" src="{{ $pin->image }}" alt="post"
                     onload=" (this.naturalWidth > this.naturalHeight) ? this.classList.add('w-full'): this.style.maxHeight = '500px'">
                {{--post--}}
                <div class="p-4 pt-2">
                    {{--title--}}
                    <div class="card-link-text tracking-wider text-justify md:text-center px-0 md:px-auto">
                        <p class="text-sm font-normal">
                            {!!  $pin->title !!}
                            <span class="text-xs main-color">
                                  &nbsp;&nbsp; <i class="fa">&#xf073;</i> {{ $pin->created_at }}
                            </span>
                        </p>
                    </div>
                    {{--text--}}
                    <div class="mt-1 md:mt-4 text-center">
                        <p class="text-justify text-xs md:text-base mb-4 post-text tracking-4">
                            {!! substr(strip_tags($pin->body), 0, 65)  !!} ...
                        </p>
                        {{--                        desktop or tablet--}}
                        <a id="desktop-link-pagination"
                           class="user-panel-modal text-white post-link mt-2 hidden md:block mx-auto cursor-pointer bg-main-mode p-2 md:px-2 md:py-1 shadow-lg rounded hover:opacity-75"
                           @click="
                           showModals=true;showPost=true;
                               postTitle='{{ $pin->title }}';
                               postContent = '{{ str_replace('<a ', '<a target="_blank" ', $pin->body) }}';
                               postImage = '{{ $pin->image }}';
                               postDate='{{ $pin->created_at }}';">
                            Read more
                        </a>
                        {{--                        cellphone--}}
                        <div class="mt-4 md:hidden">
                            <a id="mobile-link-pagination"
                               class="user-panel-modal text-white post-link text-sm px-4 py-1 cursor-pointer bg-main-mode p-2 md:px-2 md:py-1 shadow-lg rounded hover:opacity-75"
                               @click="
                           showModals=true;showPost=true;
                               postTitle='{{ $pin->title }}';
                               postContent = '{{ str_replace('<a ', '<a target="_blank" ', $pin->body) }}';
                               postImage = '{{ $pin->image }}';
                               postDate='{{ $pin->created_at }}';">
                                More
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
        <a class="user-panel-modal post-link text-sm mt-5 hidden px-4 py-1 rounded cursor-pointer"
           href="#animatedModal" @click="showReservation=false; showPost=false">
        </a>
    </div>
    {{-- side news--}}
    <div class="w-full md:w-1/2 text-center flex flex-wrap" style="height: 100%">
        <div id="post-list" class="flex flex-wrap w-full">
            @include('components.user.post-list', ['posts' => $posts])
        </div>
    </div>
</div>
