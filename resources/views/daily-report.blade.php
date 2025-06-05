@php
    $isParking = ($report == 'parking');
    $prefix =  $isParking ? 'light' : 'cell';
    $image = $isParking ? ['green', 'red'] : ['on', 'off'];
    $alt = $isParking ? 'traffic-light' : 'cellphone';
    $top = $isParking ? '2' : '6';
    $width = $isParking ? '10' : '12';
    $mdWidth = $isParking ? '20' : '28';
    $mdHeight = $isParking ? '50' : '60';
@endphp

<x-app-layout>
    <x-dark-light-mode/>

    <div class="pt-10 rtl-direction persol-farsi-font mx-auto">

        {{--image--}}
        <img id="{{ $prefix }}-left" src="/img/{{ $image[0] }}.png" alt="{{ $alt }}"
             class="absolute lg:fixed left-8 top-{{ $top }} lg:left-12 lg:top-1/2 w-{{ $width }} h-30 lg:w-{{ $mdWidth }} lg:h-{{ $mdHeight }} object-cover {{ isDarkMode() ? 'opacity-50' : 'opacity-75' }}">

        {{--heading--}}
        <p class="text-center text-gray-500 font-extrabold text-5xl mb-12">
            <span class="hidden md:inline-block"> رزرواسیـون روز </span>
            پرسـال
        </p>

        {{--table--}}
        <div
            class="bg-gray-700 {{ isLightMode() ? 'bg-gray-300' : '' }} border border-gray-400 border-dotted mx-3 shadow-lg rounded-lg rtl p-2 md:p-6 md:mx-auto md:w-3/4">
            <div
                class="flex flex-col border-b border-gray-600 bg-gray-500 {{ isLightMode() ? 'bg-main' : '' }} py-2 px-4">
                <div class="flex justify-between rounded-lg">
                    <span class="text-right font-bold w-[15%]"><span
                            class="hidden md:inline-block">تاریخ</span> شروع
                    </span>
                    <span class="text-right font-bold w-[15%]"><span
                            class="hidden md:inline-block">تاریخ</span> پایان
                    </span>
                    <span class="text-right font-bold w-[10%]">مکان</span>
                    <span class="text-right font-bold w-[10%]">{{ $report == 'parking' ? 'کارت' : 'داخلی' }}</span>
                    <span class="text-right font-bold w-[10%]">طبقه</span>
                    <span class="text-center font-bold w-[20%]">{{ $report == 'parking' ? 'پلاک' : 'موبایل' }}</span>

                    <span class="text-center font-bold w-[20%]">رزرو کننده</span>
                </div>
            </div>
            @foreach($reservations as $reservation)
                <div
                    class="flex justify-between hover:shadow hover:font-extrabold hover:text-gray-800 text-gray-400 hover:bg-gray-500
                    {{ isLightMode() ? 'hover:bg-gray-100 text-gray-700' : '' }}
                    cursor-pointer py-2 px-4 @if(!$loop->last) border-b border-gray-600 @endif">
                    <span class="text-right w-[15%]">{{ $reservation->start }}</span>
                    <span class="text-right w-[15%]">{{ $reservation->end }}</span>
                    <span class="text-right w-[10%]">{{ $reservation->spot }}</span>
                    <span
                        class="text-right w-[10%]">{{ $reservation->{$report == 'parking' ? 'card' : 'extension'} }}</span>
                    <span class="text-right w-[10%] ltr-direction">{{ $reservation->floor }}</span>
                    <span class="text-center w-[20%]">{{ $report == 'parking' ? $reservation->plate : '***' }}</span>
                    <span class="text-left w-[20%]">{{ $reservation->reserver }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{--car animation--}}
    @if($isParking)
        <x-dashboard.car-animation/>
    @endif

    <x-dashboard.footer></x-dashboard.footer>


    <script>
        /*change the light of traffic light*/
        const report = @json($report);
        const element = document.getElementById(report === 'parking' ? 'light-left' : 'cell-left');
        const images = report === 'parking' ? ['/img/green.png', '/img/yellow.png', '/img/red.png'] : ['/img/on.png', '/img/off.png'];
        let currentIndex = 0;

        setInterval(() => {
            element.src = images[currentIndex];
            currentIndex = (currentIndex + 1) % images.length;
        }, report === 'parking' ? 2000 : 4000);
    </script>
</x-app-layout>
