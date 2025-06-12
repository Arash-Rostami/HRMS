@foreach($links->filter(fn($link) => $link['link'] === 'external')->chunk(4) as $chunks)
    <div class="flex items-start flex-wrap md:flex-nowrap">
        @foreach($chunks as $chunk)
            <div class="w-1/2 md:w-1/4 text-center p-1">
                <a target="_blank"
                   href="{{ (!is_null($chunk->internal_url) && isInternalISP()) ? $chunk->internal_url : $chunk->url }}"
                   title="{{ $chunk->url_description }}">
                    <div class="card-link rounded links-thumbnails links-thumbnails-color bg-weekend">
                        <img class="border-solid border-b-2 border-gray-600" src="{{ $chunk->image }}"
                             alt="{{ $chunk->image_description }}">
                        <div class="card-link-text tracking-wider">
                            <p class="hidden md:block">{{ $chunk->url_title }}</p>
                            <img class="mt-5 md:hidden opacity-60 w-1/2 mx-auto my-auto" src="{{ $chunk->icon }}"
                                 alt="{{$chunk->icon_description}}">
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endforeach
