@foreach($links->filter(fn($link) => $link['link'] === 'internal')->chunk(4) as $chunks)
    <div class="flex items-start flex-wrap md:flex-nowrap cursor-pointer">
        @foreach($chunks as $chunk)
            <div class="w-1/2 md:w-1/4 text-center p-1">
                <a
                        @if (($chunk->url_title == 'Reservation System' && $chunk->image_description == 'reservation') || ($chunk->url_title == 'Products Page' && $chunk->image_description == 'product'))
                            class="user-panel-modal"
                        @else
                            href="{{ (!is_null($chunk->internal_url) && isInternalISP()) ? $chunk->internal_url : $chunk->url }}"
                        target="_blank"
                        @endif
                        @if($chunk->url_title == 'Reservation System' and $chunk->image_description == 'reservation')
                            @click="showModals=true;showProduct = false; showPost=false; showReservation=true; "
                        @elseif($chunk->url_title == 'Products Page' and $chunk->image_description == 'product')
                            @click="showModals=true;showReservation=false; showPost=false; showProduct = true; "
                        @endif
                        title="{{ $chunk->url_description }}">
                    <div class="card-link rounded links-thumbnails links-thumbnails-color bg-weekend">
                        <img class="border-solid border-b-2 border-gray-600" src="{{ $chunk->image }}"
                             alt="{{ $chunk->image_description }}">
                        <div class="card-link-text tracking-wider">
                            <p class="hidden md:block">{{ $chunk->url_title }}</p>
                            <img class="mt-5 md:hidden opacity-60 w-1/2 mx-auto" src="{{ $chunk->icon }}"
                                 alt="{{ $chunk->icon_description }}">
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endforeach
