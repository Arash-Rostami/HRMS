<div class="flex flex-column flex-wrap">
    @foreach($jobs->chunk(4) as $chunks)
        <div class="flex flex-wrap md:flex-nowrap w-full farsi-module persol-farsi-font justify-between">
            @foreach($chunks as $job)
                <div class="w-1/2 md:w-1/4 text-center p-1" style="min-width: 25% !important;">
                    <div class="flip-card card-job links-thumbnails h-auto w-full">
                        <div class="flip-card-inner h-auto">
                            <div class="flip-card-front">
                                @php
                                    $avatar = match($job->gender) {'Male' => '/img/user/male_avatar.svg', 'Female' => '/img/user/female_avatar.svg','Any' => '/img/user/neutral_avatar.svg' };
                                @endphp
                                <img class="w-1/2 mx-auto" title="{{  $job->gender }} gender"
                                     src="{{ $avatar }}"
                                     alt="Avatar">
                                <div class="container-job p-1">
                                    <h2 class="border-b border-dotted border-[var(--main)] pb-1">{!!  $job->position !!}</h2>
                                    <h4><b>مدرک تحصیلی:</b></h4>
                                    <p class="text-justify">
                                        {!!  $job->certificate  !!}
                                    </p>
                                </div>
                            </div>
                            <div class="flip-card-back p-2 h-auto">
                                <div class="p-1">
                                    <h4><b>سابقه کار:</b></h4>
                                    <p class="text-justify ">
                                        {!!  $job->experience  !!}
                                    </p>
                                </div>
                                <hr class="my-2">
                                <div class="p-1">
                                    <h4><b>مهارت‌ها:</b></h4>
                                    <p class="text-justify">
                                        {!!  $job->skill  !!}
                                    </p>
                                </div>
                                <div class="share-post" title="share this opportunity with others">
                                    <label for="postUrl"></label>
                                    <input type="text" class="postUrl" readonly
                                           value="{!! strip_tags($job->link) !!}">
                                    <button class="copyButton">
                                        <i class='fas fa-link'></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{--To place the empty EXTRA divs in the place for making the fixed position of cards--}}
            @for($i = count($chunks); $i < 4; $i++)
                <div class="w-1/2 md:w-1/4 text-center p-1" style="min-width: 25% !important;">
                    <div class="flip-card card-job links-thumbnails h-auto w-full">
                        <div class="flip-card-inner h-auto">
                            <div class="flip-card-front">
                                <img class="w-1/2 mx-auto invisible" title="gender" src="{{ $avatar }}" alt="Avatar">
                                <div class="container-job p-1"><p class="text-justify"></p></div>
                            </div>
                            <div class=" p-2 h-auto">
                                <div class="p-1"><p class="text-justify "></p></div>
                                <div class="p-1"><p class="text-justify"></p></div>
                                <div class="share-post" title="share this opportunity with others"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    @endforeach
</div>


