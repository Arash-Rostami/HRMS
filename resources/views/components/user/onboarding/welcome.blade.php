<div class="hidden block opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block
 p-2 pr-4 persol-farsi-font animate-[fade-in_1s_ease-in-out]"
     dir="rtl"
     id="pills-welcome"
     role="tabpanel"
     data-te-tab-active
     aria-labelledby="pills-welcome">
    <div class="welcome-bg"
         x-data="{
             openVideoModal: false,
             videoSrc: '',
             handleVideoClose() {
                 const player = this.$refs.videoPlayer || document.querySelector('.video-modal video');
                 if (player) {
                     player.pause();
                     player.currentTime = 0;
                 }
                 this.openVideoModal = false;
             }
         }">
        <div class="flex flex-wrap">
            <div class="flex items-center mb-6">
                <div>
                    <h2 class="font-bold text-main">به پرسال تیم ما خوش آمدید!</h2>
                </div>
            </div>
            <p class="p-2 text-justify">
                از اینکه تصمیم گرفتید بخشی از تیم ما باشید، ما بسیار خرسندیم.
                ما باور داریم که شروعی قوی، پایه‌گذار مسیری موفق در سازمان است. به همین دلیل، فرآیند آنبوردینگ در شرکت
                ما به‌گونه‌ای طراحی شده که ضمن انتقال اطلاعات مهم، حس تعلق و آشنایی عمیق با فرهنگ سازمانی را برای شما
                ایجاد کند.
                در این بخش، شما با ساختار شرکت، ارزش‌های کلیدی، مزایا، پاسخ به سوالات رایج و منابعی که به‌عنوان عضو جدید
                در اختیارتان است آشنا خواهید شد. این مسیر تعاملی و جذاب است، پس با دقت مرحله به مرحله (با کلیک بر نوار
                کناری) آن را دنبال کنید☺️

            </p>
        </div>
        <div class="flex text-center py-8 mt-5">
            <b class="p-2 d-block text-main">
                مشاهده کلیپ‌های خوش‌آمدگویی
            </b>
        </div>
        <div class="flex flex-wrap">
            @php
                $videos = [
                    [
                        'src' => '/video/ceo-f.mp4',
                        'img' => '/img/user/ceo-f',
                        'alt' => 'ceo-female',
                        'title' => 'پیام خوش آمدگویی از پروا سلطانی (مدیر عامل)'
                    ],
                    [
                        'src' => '/video/ceo-m.mp4',
                        'img' => '/img/user/ceo-m',
                        'alt' => 'ceo-male',
                        'title' => 'پیام خوش آمدگویی از پدرام سلطانی (رئیس هیئت مدیره)'
                    ],
                    [
                        'src' => '/video/persol.mp4',
                        'img' => '/img/user/welcome-card',
                        'alt' => 'welcome-card',
                        'title' => 'تور پرسال'
                    ]
                ];
            @endphp
            @foreach($videos as $video)
                <div class="w-2/3 mx-auto md:mx-0 my-4 md:w-1/6">
                    <a href="#"
                       @click.prevent="openVideoModal = true; videoSrc = '{{ $video['src'] }}'"
                       class="block hover:opacity-90 transition-opacity"
                       title="{{ $video['title'] }}">
                        <img
                            class="thumbnail welcome-thumbnails welcome-thumbnails-color rounded hover:grayscale-0 transform transition-all duration-300 ease-out"
                            :class="hover ? 'scale-105' : 'scale-100'"
                            :src="hover ? '{{ $video['img'] }}-play.svg' : '{{ $video['img'] }}.svg'"
                            alt="{{ $video['alt'] }}"
                            x-data="{ hover: false }"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:leave="transition ease-in duration-200"
                            @mouseover="hover = true"
                            @mouseout="hover = false">
                    </a>
                </div>
            @endforeach
        </div>
        <template x-teleport="body">
            <div class="video-modal"
                 x-show="openVideoModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click.away="handleVideoClose()"
                 style="display: none;"
            >
                <div class="video-modal-content">
                    <button class="video-modal-close"
                            @click="handleVideoClose()">
                        &times;
                    </button>
                    <video x-ref="videoPlayer" :src="videoSrc" controls autoplay controlsList="nodownload"
                           class="w-full h-full object-contain">
                    </video>
                </div>
            </div>
        </template>
    </div>
</div>
