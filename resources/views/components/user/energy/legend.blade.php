@php
    $interpretations = [
        [
            'title' => 'شاخص هر بُعد (احساس، ذهن، جسم، روح)',
            'title_color' => 'text-blue-700',
            'scores' => [
                ['range' => '۰ – عالی 😍', 'description' => 'پرانرژی و آماده برای ادامه مسیر. همین روند رو حفظ کن و از خودت مراقبت کن.', 'color' => 'text-green-600'],
                ['range' => '۱ – خوب 🙂', 'description' => 'شرایط خوبه، فقط گاهی کمی به خودت استراحت بده تا همین انرژی رو نگه داری.', 'color' => 'text-blue-600'],
                ['range' => '۲ – متوسط 😌', 'description' => 'نیاز داری کمی به روتین استراحت و بازسازی انرژی توجه بیشتری کنی.', 'color' => 'text-yellow-600'],
                ['range' => '۳ – نیاز به بهبود 😕', 'description' => 'وقتشه تغییرات کوچیک و مثبت توی سبک زندگی یا کار ایجاد کنی.', 'color' => 'text-orange-600'],
                ['range' => '۴ – نیاز جدی به توجه 😔', 'description' => 'نشونه‌ها میگن باید سریع‌تر به جسم و ذهنت رسیدگی کنی، از حمایت و همراهی اطرافیان هم کمک بگیر.', 'color' => 'text-red-600'],
            ],
        ],
        [
            'title' => 'مجموع شاخص کل (تصویر کلی وضعیت انرژی)',
            'title_color' => 'text-purple-700',
            'scores' => [
                ['range' => '۰ تا ۲ – عالی 😍', 'description' => 'تعادل کامل بین کار و استراحت، الگوی عالی برای بقیه.', 'color' => 'text-green-600'],
                ['range' => '۳ تا ۵ – خوب 🙂', 'description' => 'وضعیت خوبه، با کمی تغییر مثبت می‌تونی به بهترین حالت برسی.', 'color' => 'text-blue-600'],
                ['range' => '۶ تا ۹ – متوسط 😌', 'description' => 'فرصت خوبی برای بازبینی کارها و اضافه کردن لحظه‌های استراحت.', 'color' => 'text-yellow-600'],
                ['range' => '۱۰ تا ۱۳ – نیاز به توجه 😕', 'description' => 'چند نشونه از افت انرژی وجود داره، بهتره زودتر براش برنامه‌ریزی کنی.', 'color' => 'text-orange-600'],
                ['range' => '۱۴ تا ۱۶ – نیاز فوری به رسیدگی 😔', 'description' => 'الان زمانشه اولویت رو به سلامت جسم و ذهن بدی. کمک گرفتن از دیگران نشونه ضعف نیست، نشونه هوشمندیه.', 'color' => 'text-red-600'],
            ],
        ],
    ];
@endphp
<div class="w-full md:w-2/3 mx-auto p-4 md:p-16 pt-8 pb-0 md:pb-0 rounded-lg mt-6 cursor-help"
     title="نکته: شاخص بالاتر نشان‌دهنده وضعیت نامطلوب‌تر است. مقدار مطلوب برای هر معیار، کمترین شاخص ممکن است">
    <header class="text-center mb-2">
        <h3 class="text-xl font-bold">💡 راهنمای تفسیر نتایج پرسشنامه انرژی</h3>
    </header>
    <div class="grid grid-cols-1 md:grid-cols-2">
        @foreach ($interpretations as $interpretation)
            <div class="p-5 rounded-xl border border-slate-200 links-thumbnails-color scale-90 bg-weekend">
                <h4 class="text-base font-bold mb-4 pb-3 border-b border-slate-200 {{ $interpretation['title_color'] }}">
                    {{ $interpretation['title'] }}
                </h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <tbody>
                        @foreach ($interpretation['scores'] as $score)
                            <tr class="border-b border-slate-200/60 last:border-none">
                                <td class="py-3 pr-2 font-semibold whitespace-nowrap align-top {{ $score['color'] }}">
                                    {{ $score['range'] }}
                                </td>
                                <td class="py-3 pl-4 text-slate-600 align-top">
                                    {{ $score['description'] }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</div>
