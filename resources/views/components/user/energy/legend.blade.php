@php
    $interpretations = [
        [
            'title' => 'شاخص در هر بُعد (بدن، احساس، ذهن، روح)',
            'title_color' => 'text-blue-700',
            'scores' => [
                ['range' => '۰ - عالی', 'description' => 'بدون نشانه خستگی', 'color' => 'text-green-600'],
                ['range' => '۱ - خوب', 'description' => 'فقط یک نشانه منفی', 'color' => 'text-blue-600'],
                ['range' => '۲ - متوسط', 'description' => 'نیاز به مراقبت', 'color' => 'text-yellow-600'],
                ['range' => '۳ - ضعیف', 'description' => 'باید بهبود پیدا کند', 'color' => 'text-orange-600'],
                ['range' => '۴ - خیلی ضعیف', 'description' => 'نشانه جدی فرسودگی', 'color' => 'text-red-600'],
            ],
        ],
        [
            'title' => 'مجموع شاخص کل (وضعیت کلی انرژی)',
            'title_color' => 'text-purple-700',
            'scores' => [
                ['range' => '۰-۲ - عالی', 'description' => 'تعادل کامل', 'color' => 'text-green-600'],
                ['range' => '۳-۵ - خوب', 'description' => 'قابل قبول ولی قابل بهبود', 'color' => 'text-blue-600'],
                ['range' => '۶-۹ - متوسط', 'description' => 'نیاز به رسیدگی', 'color' => 'text-yellow-600'],
                ['range' => '۱۰-۱۳ - ضعیف', 'description' => 'خطر فرسودگی بالا', 'color' => 'text-orange-600'],
                ['range' => '۱۴-۱۶ - بحرانی', 'description' => 'نیاز به اقدام فوری', 'color' => 'text-red-600'],
            ],
        ],
    ];
@endphp

<div class="w-full md:w-2/3 mx-auto p-4 md:p-16 pt-8 pb-4 md:pb-0 rounded-lg mt-6 cursor-help"
     title="نکته: شاخص بالاتر نشان‌دهنده وضعیت نامطلوب‌تر است. مقدار مطلوب برای هر معیار، کمترین شاخص ممکن است">
    <h3 class="text-lg font-bold mb-4 text-center"> 💡راهنمای تفسیر نتایج پرسشنامه انرژی</h3>
    <div class="grid md:grid-cols-2 gap-6">
        @foreach ($interpretations as $interpretation)
            <div class="p-4 rounded-lg shadow-md">
                <h4 class="font-semibold mb-3 {{ $interpretation['title_color'] }}">{{ $interpretation['title'] }}</h4>
                <div class="space-y-2 text-sm">
                    @foreach ($interpretation['scores'] as $score)
                        <div class="flex justify-between">
                            <span class="font-medium {{ $score['color'] }}">{{ $score['range'] }}</span>
                            <span>{{ $score['description'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
