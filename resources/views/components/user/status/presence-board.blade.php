@foreach($presences as $presenceType => $details)
    <div class="w-full card-job links-thumbnails my-1 transform transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg">
        <div class="flex clear-both cursor-help transition-transform duration-200 hover:scale-105" title="working {{ $presenceType }}: {{ $details['count'] }}">
            <i class="fa {{ $details['icon'] }} {{ $details['color'] }} m-2 transition-all duration-300 ease-in-out hover:rotate-12 hover:scale-110"></i>
        </div>
        <div class="flex py-1 flex-wrap justify-content-evenly">
            @foreach($users as $user)
                @php
                    $idle = Cache::has("idle_{$user->id}");
                    $isPresent = $user->presence == $presenceType;
                    $isNotGuest = !Str::startsWith($user->forename, 'Guest');
                    $isOnsiteAndActive = $presenceType === 'onsite' && !$idle;
                    $avatarClass = $idle ? 'avatar-image-idle' : $details['border'];
                    $title = $presenceType == 'on-leave'
                            ? ($user->last_seen?->diffForHumans() ?? '')
                            : ($idle
                                ? "🛇 busy from {$user->last_seen->diffForHumans()}"
                                : ($user->last_seen ? "ago {$user->last_seen->diffForHumans()}" : '...'));
                    $cellphone = $user->profile?->cellphone;
                    $contactInfo = $isOnsiteAndActive
                                ? ($user->getTodaysDeskExtension() ?? '')
                                : ($cellphone ? tel($cellphone) : '');
                @endphp
                @if($isPresent && $isNotGuest)
                    <div class="text-center items-center justify-center mx-1 avatar-container relative group {{ $details['fade'] }} transform transition-all duration-300 ease-out hover:scale-105 hover:-translate-y-1">
                        <img class="{{ $avatarClass }} mx-auto w-12 md:w-24 aspect-square object-cover rounded-full transition-all duration-500 ease-in-out hover:scale-110 hover:shadow-xl hover:brightness-110 group-hover:ring-2 group-hover:ring-opacity-60"
                             src="{{ showUserProfile($user) }}" alt="Avatar"/>
                        <p class="text-neutral-500 dark:text-neutral-400 cursor-pointer transition-all duration-200 ease-in-out hover:scale-105 hover:font-medium"
                           dir="ltr"
                           title="ارسال SMS 📲"
                           @click="openSMSModal = true; receptor= '{{ $user->profile->cellphone ?? '' }}'; message= 'ارسال پیامک به {{ $user->fullName }}'">
                            {{ $user->initials }} <span class="hidden">{{$user->fullName}}</span>
                        </p>
                        <div title="{{ $title }}"
                             class="tooltiptext absolute invisible bg-main-mode text-main-theme text-center mx-auto my-auto rounded-full bottom-10 left-1/2 transform -translate-x-1/2 opacity-0 text-xs md:text-sm w-16 h-16 md:w-20 md:h-20 font-bold cursor-pointer transition-all duration-300 ease-in-out group-hover:visible group-hover:opacity-100 group-hover:scale-110 break-words flex items-center backdrop-blur-sm shadow-2xl border border-opacity-20">
                            <span class="mx-auto animate-pulse"> {{ $contactInfo }}</span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endforeach
