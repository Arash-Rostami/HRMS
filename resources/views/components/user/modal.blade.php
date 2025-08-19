<div id="animatedModal"
     dir="rtl"
     class="ignore-elements fixed w-full h-full top-0 left-0 z-[10000000] animated persol-farsi-font @if(isDarkMode()) bg-[#1B232E] @else bg-[#F1F1F1] @endif"
     x-show="showModals"
     x-cloak x-transition:enter="bounceInUp" x-transition:leave="bounceOutDown">
    <div class="h-full overflow-y-auto">
        <div id=" close-button-container"
             class="close-animatedModal"
             @click="showModals=false; showProduct = false; showReservation=false; showPost=false">
            <img class="close-button my-10" src="/img/user/closebt.svg" alt="close-button">
        </div>
        <div class="flex flex-wrap mx-auto justify-center align-middle mb-5"
             x-show="showProduct">
            @php
                $products = [
                    [
                        'href' => 'https://en.persolco.com/mining/',
                        'title' => 'برای مشاهده محصولات معدنی پرسال کلیک کنید.',
                        'img' => '/img/user/mining.webp',
                        'alt' => 'معدن',
                        'name' => 'محصولات معدنی'
                    ],
                    [
                        'href' => 'https://en.persolco.com/chemicals-and-petroleum-derivative-products/',
                         'title' => 'برای مشاهده محصولات شیمیایی پرسال کلیک کنید.',
                        'img' => '/img/user/chemical-products.webp',
                        'alt' => 'شیمیایی',
                        'name' => 'محصولات شیمیایی'
                    ],
                    [
                        'href' => 'https://en.persolco.com/cellulose-product/',
                        'title' => 'برای مشاهده محصولات سلولزی پرسال کلیک کنید.',
                        'img' => '/img/user/cardboard.webp',
                        'alt' => 'کاغذ و مقوا',
                        'name' => 'محصولات سلولوزی'
                    ],
                    [
                        'href' => 'https://vc.persolco.com/',
                        'title' => 'برای مشاهده فعالیت‌های سرمایه‌گذاری  پرسال کلیک کنید.',
                        'img' => '/img/user/investment.webp',
                        'alt' => 'سرمایه گذاری',
                        'name' => 'سرمایه گذاری'
                    ]
                ];
            @endphp
            @foreach($products as $product)
                <div class="w-1/3 md:w-1/5 text-center m-2 section-box">
                    <a target="_blank"
                       href="{{ $product['href'] }}" title="{{ $product['title'] }}">
                        <div class="card-link thumbnail product-thumbnails product-thumbnails-color">
                            <img class="mx-auto product-img object-contain"
                                 loading="lazy"
                                 decoding="async"
                                 src="{{ $product['img'] }}"
                                 alt="{{ $product['alt'] }}">
                            <div class="card-link-text tracking-wider">
                                <p class="text-main">{{ $product['name'] }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="h-96 mx-auto justify-center flex-col section-box"
             x-show="showReservation"
             x-cloak>
            <div class="section-title w-full mx-auto text-center my-auto h-1/2"
                 @click="event.preventDefault();window.open('{{ route('dashboard',['type'=>'office']) }}','_blank')">
                <i class="fas fa-desktop"></i><br>
                <h1 class="text-4xl justify-center">
                    رزواسیون دفتر
                </h1>
            </div>
            <div class="section-title w-full mx-auto text-center my-auto h-1/2"
                 @click="event.preventDefault();window.open('{{ route('dashboard',['type'=>'parking']) }}','_blank')">
                <i class="fas fa-car"></i><br>
                <h1 class="text-4xl">
                    رزرواسیون پارکینگ
                </h1>
            </div>
        </div>
        <div class="flex flex-wrap mx-auto justify-center align-middle mb-5"
             x-show="showPost">
            <div class="h-auto w-auto p-0">
                <img class="md:h-1/2 object-contain mx-auto rounded max-h-[422px] cursor-pointer"
                     alt="post"
                     :src="postImage"
                >
                <div class="p-4 pt-2">
                    <div class="card-link-text tracking-wider text-center px-0 md:px-auto">
                        <p @class(['text-2xl mx-auto','text-gray-400' => isDarkMode()])
                           x-html="postTitle">
                        </p>
                        <span class="text-xs main-color">
                            <i class="fa">&#xf073;</i>
                        </span>
                        <span class="text-xs main-color"
                              x-html="postDate">
                        </span>
                    </div>
                    <div @class(['p-6 text-lg md:px-32 text-justify hr-posts','text-gray-400' => isDarkMode()])
                         x-html="postContent">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






