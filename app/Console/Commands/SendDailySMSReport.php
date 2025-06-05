<?php

namespace App\Console\Commands;

use App\Services\api\SmsOperator;
use Illuminate\Console\Command;
use Morilog\Jalali\Jalalian;

class SendDailySMSReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:report';
    protected $description = 'Send a daily SMS of reports';
    protected array $receptors;
    protected string $message;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->receptors = ['09124337839', '09134214234']; // Mina & Fariba Phone numbers
        $persianDate = Jalalian::now()->format('%A %d %B %Y');
        $this->message = "PERSOL HRMS\n\nسلام، برای مشاهده لیست رزروهای پرسـال در تاریخ $persianDate لطفاً به لینک ارسال شده مراجعه فرمایید.\n\nلغو 11";
    }


    public function handle()
    {
        try {
            $smsService = new SmsOperator();
            $smsService->send($this->receptors, $this->message);

            $this->info('Reminder sent successfully.');
        } catch (\Exception $e) {
            $this->error('An error occurred while sending SMS: ' . $e->getMessage());
        }
    }
}
