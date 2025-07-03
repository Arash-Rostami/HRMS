@inject('deskModel', 'App\Models\Desk')
@php($seat = $deskModel->showCurrentDeskNumbers(auth()->id())->first() ?? 0)
<div
    class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block p-2 pr-4 persol-farsi-font animate-[fade-in_1s_ease-in-out]"
    dir="rtl"
    id="pills-office"
    role="tabpanel"
    aria-labelledby="pills-office"
>
    <div class="info-bg">
        <div class="mb-6 md:mb-10">
            <h2 class="text-main font-bold mb-4 md:mb-6">موقعیت مکانی</h2>
            <p class="text-main mb-6 leading-relaxed">
                فضای کاری و شماره داخلی خود را در تصویر زیر مشاهده کنید:
            </p>
            <div @class([
                    'flex justify-center items-center p-4 rounded-lg border border-gray-100 shadow-sm',
                    'bg-white'               => ! isDarkMode(),
                    'text-gray-200 bg-gray-700' => isDarkMode(),
                ])>

                <img alt="فضای کار"
                     title="فضای کار شما"
                     class="rounded-lg w-full h-auto max-w-full cursor-help"
                     src="{{ asset('img/desk-seats/seat-' .$seat . '.jpg') }}"
                     onerror="this.onerror=null;
                             this.src='https://placehold.co/800x450/{{ isDarkMode() ? '909EB1' : 'BCD3ED' }}/FFFFFF?text=Not+Set';"
                >
            </div>
        </div>
    </div>
</div>
