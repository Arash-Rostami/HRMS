@php
    $files = [
           [
               'href' => '/files/values/index.html',
               'src' => '/img/user/principles.svg',
               'alt' => 'The principles and values of Persol',
               'title' => 'اصول و ارزش های سازمانی پرسال',
               'hoverSrc' => '/img/user/principles-read.svg'
           ],
           [
               'href' => '/files/competencies/index.html',
               'src' => '/img/user/competencies.svg',
               'alt' => 'The booklet of competencies in Persol',
               'title' => 'کتابچه شایستگی سازمانی پرسال',
               'hoverSrc' => '/img/user/competencies-read.svg'
           ],
           [
               'href' => '/files/SOP/index.html',
               'src' => '/img/user/job-details.svg',
               'alt' => 'Persol Office SOP',
               'title' => 'دستورالعمل شیوه نامه محیط کار ',
               'hoverSrc' => '/img/user/job-details-read.svg'
           ]
       ];
@endphp
<div class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block
 w-full p-2 pr-4 persol-farsi-font animate-[fade-in_1s_ease-in-out]"
     id="pills-files"
     role="tabpanel"
     aria-labelledby="pills-files">
    <div class="files-bg" x-data>
        <p class="p-2 mb-2 text-main"><strong>کتابچه های راهنمای سازمانی:</strong></p>
        <div class="w-full">
            <p class="p-2 text-justify mb-5">
                از شما دعوت و تقاضا می گردد که برای آشنایی بیشتر با نظام و ساختار سازمانی پرسال، مطالب زیر اعم از
                <strong class="main-color"> اصول و ارزش ها، کتابچه شایستگی همچنین دستورالعمل شیوه نامه محیط
                    کار </strong>
                را با دقت مورد مطالعه و بررسی دقیق قرار دهید.
            </p>
        </div>
        <div class="flex flex-wrap">
            @foreach ($files as $file)
                <div class="w-2/3 mx-auto md:mx-2 my-4 md:w-1/6 hover:opacity-90 transition-opacity">
                    <a target="_blank" href="{{ $file['href'] }}">
                        <img class="thumbnail files-thumbnails files-thumbnails-color"
                             src="{{ $file['src'] }}"
                             alt="{{ $file['alt'] }}"
                             title="{{ $file['title'] }}"
                             @mouseover="$el.setAttribute('src', '{{ $file['hoverSrc'] }}')"
                             @mouseout="$el.setAttribute('src', '{{ $file['src'] }}')">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
