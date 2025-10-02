<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    private const ERROR_MAP = [
        'Too many connections' => ['db-busy', 503, 'پایگاه داده مشغول است'],
        'Connection refused' => ['db-connection', 503, 'خطای اتصال به پایگاه داده'],
        'server has gone away' => ['db-connection', 503, 'خطای اتصال به پایگاه داده'],
        'Deadlock found' => ['db-deadlock', 500, 'تضاد در پایگاه داده'],
        'Lock wait timeout' => ['db-timeout', 500, 'انتظار قفل زیاد شده'],
        'Access denied' => ['db-auth', 500, 'خطای احراز هویت پایگاه داده'],
    ];

    private const API_MESSAGES = [
        'db-busy' => 'پایگاه داده با ترافیک بالایی روبرو است. لطفاً دوباره تلاش کنید.',
        'db-connection' => 'اتصال به پایگاه داده ناموفق بود. لطفاً بعداً دوباره تلاش کنید.',
        'db-deadlock' => 'تضاد در پایگاه داده رخ داد. درخواست خودکار تکرار شد.',
        'db-timeout' => 'زمان انتظار پایگاه داده به پایان رسید.',
        'db-auth' => 'خطا در احراز هویت پایگاه داده.',
        '404' => 'منبع درخواستی یافت نشد.',
//        '401' => 'احراز هویت مورد نیاز است.',
        '403' => 'شما اجازه دسترسی به این منبع را ندارید.',
        '405' => 'متد درخواست برای این منبع پشتیبانی نمی‌شود.',
        '422' => 'داده‌های ورودی نامعتبر است.',
        'rate-limit' => 'تعداد درخواست‌ها بیش از حد مجاز است. لطفاً سرعت خود را کاهش دهید.',
        '500' => 'یک خطای داخلی در سرور رخ داد.',
        '503' => 'سرویس به طور موقت در دسترس نیست.',
        'general' => 'یک خطای غیرمنتظره رخ داد.',
    ];

    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof QueryException || $exception instanceof \PDOException) {
            $errorMessage = $exception->getMessage() . ' ' . $exception->getPrevious()?->getMessage();

            foreach (self::ERROR_MAP as $pattern => $config) {
                if (str_contains($errorMessage, $pattern)) {
                    return $this->renderError($request, ...$config);
                }
            }
            return $this->renderError($request, 'general', 500, 'خطای پایگاه داده');
        }

        return match (true) {
//            $exception instanceof AuthenticationException => $this->renderError($request, '401', 401, 'احراز هویت لازم است'),
            $exception instanceof ValidationException => $this->renderValidationError($request, $exception),
            $exception instanceof NotFoundHttpException => $this->renderError($request, '404', 404, 'صفحه یافت نشد'),
            $exception instanceof MethodNotAllowedHttpException => $this->renderError($request, '405', 405, 'متد غیر مجاز'),
            $exception instanceof TooManyRequestsHttpException => $this->renderError($request, 'rate-limit', 429, 'درخواست‌های بیش از حد'),
            $exception instanceof HttpException => $this->handleHttpException($request, $exception),
            default => parent::render($request, $exception)
        };
    }

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    private function handleHttpException($request, HttpException $exception)
    {
        return match ($exception->getStatusCode()) {
            401 => $this->renderError($request, '401', 401, 'احراز هویت لازم است'),
            403 => $this->renderError($request, '403', 403, 'دسترسی ممنوع'),
            500 => $this->renderError($request, '500', 500, 'خطای سرور'),
            503 => $this->renderError($request, '503', 503, 'سرویس در دسترس نیست'),
            default => $this->renderError($request, 'general', $exception->getStatusCode(), 'مشکلی پیش آمده است'),
        };
    }

    private function renderValidationError($request, ValidationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => self::API_MESSAGES['422'],
                'code' => 422,
                'error' => 'خطای اعتبارسنجی',
                'errors' => $exception->errors(),
            ], 422);
        }

        return response()->view("errors.custom", [
            'title' => 'خطای اعتبارسنجی',
            'status' => 422,
            'errors' => $exception->errors()
        ], 422);
    }

    private function renderError($request, $view, $status, $title)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => self::API_MESSAGES[$view] ?? self::API_MESSAGES['general'],
                'code' => $status,
                'error' => $title,
            ], $status);
        }

        return response()->view("errors.custom", compact('title', 'status'), $status);
    }
}
