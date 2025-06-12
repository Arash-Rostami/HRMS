@php
    $presences = [
        'onsite' => ['icon' => 'fa-building', 'color' => 'text-success-400', 'count' => countOnSiteUsers(), 'fade' => 'fade-in-two' , 'border' => 'avatar-image-onsite'],
        'off-site' => ['icon' => 'fa-laptop', 'color' => 'text-warning-500', 'count' => countOffSiteUsers(), 'fade' => 'fade-in-three' , 'border' => 'avatar-image-off-site'],
        'on-leave' => ['icon' => 'fa-bed', 'color' => 'text-gray-500', 'count' => countOnLeaveUsers(), 'fade' => 'fade-in-four' , 'border' => 'avatar-image-on-leave']
    ];
@endphp

<div class="mb-4 md:ml-4 float-left text-sm md:text-base">
    Click on names to send an SMS or images to view the extension.
</div>
{{-- Filter the result --}}
<div class="mb-4 float-right md:w-1/5 w-1/2">
    <div class="relative" data-te-input-wrapper-init>
        <input type="search"
               class="peer block min-h-[auto] w-full rounded bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:links-thumbnails data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:links-thumbnails [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0 links-thumbnails remove-border"
               id="filter-input"/>
        <label for="exampleSearch2"
               class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-gray-600 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:links-thumbnails peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none {{ isDarkMode() ? 'text-gray-200' : '' }}">Find</label>
    </div>
</div>
<div class="clear-both"
     x-data="{
            openSMSModal: false,
            openSMSToast: false,
            toastMessage: '',
            receptor: '',
            message: '',
            sendSMS() {
                 axios.post('{{ route("send-sms") }}', {
                        message: document.getElementById('smsMessage').value,
                        receptor: this.receptor
                    }, {
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                    })
                    .then(res => {
                        this.toastMessage = 'SMS sent successfully :)';
                        this.openSMSToast = true;
                        setTimeout(() => this.openSMSToast = false, 5000);
                    })
                    .catch(err => {
                        this.toastMessage = 'SMS NOT sent :(';
                        this.openSMSToast = true;
                        setTimeout(() => this.openSMSToast = false, 5000);
                    });
                this.openSMSModal = false;}
        }">
    @foreach($presences as $presenceType => $details)
        <div class="w-full card-job links-thumbnails my-1 {{ $presenceType == 'onsite' ? 'bg-weekend' : '' }}">
            <div class="flex clear-both cursor-help" title="working {{ $presenceType }}: {{ $details['count'] }}">
                <i class="fa {{ $details['icon'] }} {{ $details['color'] }} m-2"></i>
            </div>
            <div class="flex py-1 flex-wrap justify-content-evenly">
                @foreach($users as $user)
                    @php $idle = Cache::has("idle_{$user->id}"); @endphp
                    @if($user->presence == $presenceType && !Str::startsWith($user->forename, 'Guest'))
                        <div
                            class="text-center items-center justify-center mx-1 avatar-container {{ $details['fade'] }} relative group">
                            <img src="{{ showUserProfile($user) }}"
                                 class="{{ $idle ? 'avatar-image-idle' : $details['border']  }} mx-auto w-12 md:w-24 aspect-square object-cover rounded-full"
                                 alt="Avatar"/>
                            <p class="text-neutral-500 dark:text-neutral-400 cursor-pointer" title="send SMS 📲"
                               @click="
                                openSMSModal = true;
                                receptor= '{{ $user->profile->cellphone ?? '' }}';
                                message= 'send SMS to {{ $user->fullName }}'">
                                {{ $user->initials }}
                                <span class="hidden">{{$user->fullName}}</span>
                            </p>
                            {{-- Tooltip text --}}
                            <div
                                class="tooltiptext absolute invisible bg-main-mode text-main-theme text-center mx-auto my-auto rounded-full bottom-10 left-1/2 transform -translate-x-1/2 opacity-0 text-xs md:text-sm w-16 h-16 md:w-20 md:h-20 font-bold cursor-pointer transition-opacity duration-500 group-hover:visible group-hover:opacity-100 break-words flex items-center"
                                @if($presenceType != 'on-leave')
                                    title="{{ $idle ? "🛇 busy from {$user->last_seen->diffForHumans()}" : (!is_null($user->last_seen) ? "ago {$user->last_seen->diffForHumans()}" : '...') }}"
                                @else
                                    title="{{ !is_null($user->last_seen) ? $user->last_seen->diffForHumans() : '' }}"
                                @endif
                            >
                                <span class="mx-auto">
                                    @if($presenceType == 'onsite' && !$idle)
                                        {{ $user->getTodaysDeskExtension() ?? '' }}
                                    @else
                                        {{$user->profile && $user->profile->cellphone ? tel($user->profile->cellphone) : '' }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endforeach

    {{-- SMS modal --}}
    <div class="absolute bottom-0 left-0 right-0 top-0 bg-opacity-75 flex justify-center items-center"
         title="enter your message in this SMS dialog box"
         x-transition
         x-show="openSMSModal"
         @click.outside="openSMSModal = false">
        <div class="bg-white  @if ( isDarkMode()) bg-[#1F2937] @endif shadow-2xl w-3/4 md:w-1/2 rounded-lg p-4">
            <div class="text-center">
                    <textarea
                        class="mx-auto mt-12 w-full md:w-2/3 h-48 rounded-lg p-4 border-main text-center text-main"
                        id="smsMessage" name="message" rows="10" x-bind:placeholder="message"></textarea>
            </div>
            <div class="mt-4 flex justify-center space-x-4">
                @csrf
                <input type="hidden" name="receptor" x-model="receptor" x-ref="receptor">
                <button class="bg-red-500 text-white px-2 py-1 rounded-md" @click="openSMSModal = false">cancel
                </button>
                <button class="bg-green-500 text-white px-2 py-1 rounded-md" @click="sendSMS()">send
                </button>
            </div>
        </div>
    </div>

    {{--    Success message toast--}}
    <div class="absolute ignore-elements top-1 right-2 rounded" x-show="openSMSToast">
        <div class="bg-main-mode max-w-xs text-gray-800 rounded-lg px-4 py-2 slide-in-top">
            <div class="cursor-pointer z-50 float-right ">
                <i class="fas fa-window-close text-gray-900" title="Close"></i>
            </div>
            <br>
            <span x-text="toastMessage"></span>
        </div>
    </div>
</div>

