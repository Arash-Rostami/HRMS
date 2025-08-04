@foreach($posts as $post)
    <article class="w-1/2 p-1">
        <div class="card-link rounded links-thumbnails links-thumbnails-color bg-weekend
                    flex flex-col justify-between h-full min-h-[450px] md:min-h-[470px]">
            <header class="flex-grow">
                <img class="mx-auto mt-3 max-h-44 w-auto object-contain"
                     src="{{ $post->image }}"
                     alt="{{ strip_tags($post->title) }}"
                     loading="lazy">

                <div class="p-4 pt-2">
                    <h3 class="card-link-text tracking-wider text-justify md:text-center">
                        <span class="text-sm font-normal">
                            {!! $post->title !!}
                        </span>
                        <time class="text-xs main-color block mt-1">
                            <i class="fa" aria-hidden="true">&#xf073;</i>
                            {{ $post->created_at }}
                        </time>
                    </h3>

                    <div class="mt-1 md:mt-2">
                        <p class="text-justify text-xs md:text-base post-text break-words line-clamp-3">
                            {!! substr(strip_tags($post->body), 0, 65) !!}...
                        </p>
                    </div>
                </div>
            </header>
            <footer class="pb-2 text-center">
                <button type="button"
                        class="user-panel-modal post-link bg-main-mode text-white shadow-lg rounded
                               hover:opacity-75 transition-opacity duration-200 cursor-pointer
                               hidden md:inline-block px-2 py-1 mt-4"
                        @click="showModals=true; showPost=true;
                               postTitle='{{ addslashes($post->title) }}';
                               postContent='{{ addslashes(str_replace('<a ', '<a target="_blank" ', $post->body)) }}';
                               postImage='{{ $post->image }}';
                               postDate='{{ $post->created_at }}'">
                    بیشتر
                </button>
                <button type="button"
                        class="user-panel-modal post-link bg-main-mode text-white shadow-lg rounded
                               hover:opacity-75 transition-opacity duration-200 cursor-pointer
                               md:hidden text-sm px-4 py-1"
                        @click="showModals=true; showPost=true;
                               postTitle='{{ addslashes($post->title) }}';
                               postContent='{{ addslashes(str_replace('<a ', '<a target="_blank" ', $post->body)) }}';
                               postImage='{{ $post->image }}';
                               postDate='{{ $post->created_at }}'">
                    بیشتر
                </button>
            </footer>
        </div>
    </article>
@endforeach

<nav class="m-2 w-full pagination pagination-posts" style="direction: ltr !important;">
    {{ $posts->links() }}
</nav>
