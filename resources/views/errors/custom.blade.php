<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>{{ $title ?? 'خطا' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Vazirmatn', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #C2C7CA;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08);
            padding: 60px 40px;
            text-align: center;
            max-width: 480px;
            width: 90%;
            animation: slideIn 0.8s ease;
            position: relative;
            overflow: hidden;
        }

        .status-code {
            font-size: 72px;
            font-weight: 700;
            color: #e53e3e;
            margin-bottom: 20px;
            opacity: 0.8;
        }

        .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s ease-in-out infinite;
            position: relative;
            z-index: 2;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .error-401 .icon {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .error-404 .icon {
            background: linear-gradient(135deg, #4299e1, #63b3ed);
        }

        .error-403 .icon {
            background: linear-gradient(135deg, #ed8936, #f6ad55);
        }

        .error-422 .icon {
            background: linear-gradient(135deg, #f093fb, #f5576c);
        }

        .error-500 .icon {
            background: linear-gradient(135deg, #e53e3e, #fc8181);
        }

        .error-503 .icon {
            background: linear-gradient(135deg, #805ad5, #b794f6);
        }

        .error-429 .icon {
            background: linear-gradient(135deg, #d69e2e, #f6e05e);
        }

        .error-db .icon {
            background: linear-gradient(135deg, #38a169, #68d391);
        }

        .icon-symbol {
            font-size: 36px;
            color: white;
            font-weight: bold;
        }

        h1 {
            font-size: 28px;
            color: #2d3748;
            margin-bottom: 16px;
            font-weight: 600;
            position: relative;
            z-index: 2;
        }

        p {
            color: #718096;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 40px;
            position: relative;
            z-index: 2;
        }

        .actions {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
            z-index: 2;
        }

        .btn {
            padding: 14px 28px;
            border-radius: 12px;
            border: none;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4299e1, #63b3ed);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(66, 153, 225, 0.4);
        }

        .btn-secondary {
            background: rgba(113, 128, 150, 0.1);
            color: #4a5568;
            border: 1px solid rgba(113, 128, 150, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(113, 128, 150, 0.2);
            transform: translateY(-1px);
        }

        .loading {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .error-info {
            background: rgba(66, 153, 225, 0.1);
            border-right: 4px solid #4299e1;
            padding: 16px 20px;
            margin: 20px 0;
            border-radius: 8px;
            text-align: right;
            font-size: 14px;
            color: #2d3748;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 40px 24px;
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .status-code {
                font-size: 48px;
            }
        }
    </style>
</head>
<body>
@php
    $statusCode = $status ?? 500;

    $classes = [
        404 => 'error-404',
        403 => 'error-403',
        422 => 'error-422',
        500 => 'error-500',
        503 => 'error-503',
        429 => 'error-429',
    ];
    $errorClass = $classes[$statusCode] ?? 'error-db';

    $messages = [
        404 => ['title' => 'صفحه یافت نشد', 'message' => 'صفحه‌ای که به دنبال آن هستید ممکن است حذف شده یا به طور موقت در دسترس نباشد.', 'symbol' => '!'],
        403 => ['title' => 'دسترسی ممنوع', 'message' => 'شما اجازه دسترسی به این منبع را ندارید.', 'symbol' => '🚫'],
        422 => ['title' => 'خطای اعتبارسنجی', 'message' => 'داده‌های ارسالی نامعتبر است. لطفاً مقادیر را بررسی کنید.', 'symbol' => '📝'],
        500 => ['title' => 'خطای سرور', 'message' => 'یک خطای داخلی در سرور رخ داد. لطفاً بعداً دوباره تلاش کنید.', 'symbol' => '⚠'],
        503 => ['title' => 'سرویس در دسترس نیست', 'message' => 'سرویس به طور موقت در دسترس نیست. لطفاً بعداً دوباره تلاش کنید.', 'symbol' => '🔧'],
        429 => ['title' => 'درخواست‌های بیش از حد', 'message' => 'شما درخواست‌های زیادی ارسال کرده‌اید. لطفاً سرعت خود را کاهش دهید.', 'symbol' => '⏱'],
        'default' => ['title' => 'پایگاه داده مشغول است', 'message' => 'پایگاه داده ما با ترافیک بالایی روبرو است. لطفاً لحظاتی دیگر دوباره تلاش کنید.', 'symbol' => '💾'],
    ];

    $error = $messages[$statusCode] ?? $messages['default'];
@endphp


<div class="container {{ $errorClass }}">
    <div class="status-code">{{ $status ?? '503' }}</div>
    <div class="icon">
        <div class="icon-symbol">{{ $error['symbol'] }}</div>
    </div>

    <h1>{{ $title ?? $error['title'] }}</h1>
    <p>{{ $error['message'] }}</p>

    @if(isset($errors) && count($errors) > 0)
        <div class="error-info">
            <strong>خطاهای فرم:</strong><br>
            @foreach($errors as $field => $fieldErrors)
                @foreach($fieldErrors as $error)
                    {{ $error }}<br>
                @endforeach
            @endforeach
        </div>
    @endif

    @if(in_array($status ?? 500, [500, 503]) && !isset($errors))
        <div class="error-info">
            <strong>چه اتفاقی افتاده است؟</strong><br>
            سرورهای ما با مشکل مواجه شده‌اند. تیم ما به طور خودکار مطلع شده و در حال رفع مشکل است.
        </div>
    @endif

    <div class="actions">
        @if(in_array($status ?? 500, [401, 403]))
            <a class="btn btn-primary" href="{{ route('login') ?? '/' }}">ورود</a>
        @elseif(in_array($status ?? 500, [503, 429]) || !isset($status))
            <button class="btn btn-primary" onclick="retryPage()">
                <div class="loading"></div>
                <span>تلاش مجدد</span>
            </button>
        @endif

        @if(in_array($status ?? 500, [404, 422]))
            <button class="btn btn-secondary" onclick="history.back()">بازگشت</button>
        @endif
    </div>
</div>

<script>
    function retryPage() {
        const btn = document.querySelector('.btn-primary');
        const loading = btn?.querySelector('.loading');
        const text = btn?.querySelector('span');

        if (btn && loading && text) {
            loading.style.display = 'block';
            text.textContent = 'در حال تلاش مجدد...';
            btn.disabled = true;

            setTimeout(() => location.reload(), 1500);
        }
    }

    @if(in_array($status ?? 500, [503, 429]) || !isset($status))
    setTimeout(() => {
        console.log('Auto-retrying...');
        setTimeout(() => location.reload(), 2000);
    }, 30000);
    @endif
</script>
</body>
</html>
