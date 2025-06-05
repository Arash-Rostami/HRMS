@foreach($posts as $post)
    <div class="w-1/2 text-center h-auto mt-1 p-1">
        <div
            class="card-link rounded links-thumbnails links-thumbnails-color h-full p-0 min-h-[470px] md:min-h-[450px] flex flex-col justify-between">
            <div>
                <img class="mx-auto max-h-44 w-auto" src="{{$post->image}}" alt="post">
                {{-- post --}}
                <div class="p-4 pt-2">
                    <div class="card-link-text tracking-wider text-justify md:text-center px-0 md:px-auto">
                        <p class="text-sm md:text-base">
                            {!! $post->title !!}
                            <span class="text-xs main-color"><i class="fa">&#xf073;</i> {{ $post->created_at }}</span>
                        </p>
                    </div>
                    {{-- text --}}
                    <div class="mt-1 md:mt-2 text-center">
                        <p class="text-justify text-xs md:text-base mb-4 break-words">
                            {!! substr(strip_tags($post->body), 0, 65)  !!} ...
                        </p>
                    </div>
                </div>
            </div>
            <div class="text-center mb-2">
                {{-- desktop or tablet --}}
                <a class="user-panel-modal post-link md:px-4 md:py-2 md:mt-4 hidden md:block rounded mx-auto cursor-pointer"
                   x-on:click="
                   showModals=true;showPost=true;
                       postTitle = '{{ $post->title }}';
                       postContent = '{{ str_replace('<a ', '<a target="_blank" ', $post->body) }}';
                       postImage = '{{ $post->image }}';
                       postDate = '{{ $post->created_at }}'">
                    Read more
                </a>
                <br>
                {{-- cellphone --}}
                <a class="user-panel-modal post-link text-sm md:hidden px-4 py-1 relative bottom-4 rounded cursor-pointer"
                   x-on:click="
                   showModals=true;showPost=true;
                       postTitle = '{{ $post->title }}';
                       postContent = '{{ str_replace('<a ', '<a target="_blank" ', $post->body) }}';
                       postImage = '{{ $post->image }}';
                       postDate = '{{ $post->created_at }}';">
                    More
                </a>
            </div>
        </div>
    </div>
@endforeach



<div class="m-2 w-full pagination pagination-posts" style="direction:ltr!important;">
    {{ $posts->links() }}
</div>



