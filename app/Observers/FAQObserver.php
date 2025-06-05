<?php

namespace App\Observers;

use App\Models\FAQ;
use Illuminate\Support\Facades\Cache;

class FAQObserver
{
//    protected $cacheCleaner;
//
//    public function __construct()
//    {
//        $this->cacheCleaner = new CacheCleanerService('faqs');
//    }

    public function created(FAQ $faq)
    {
        Cache::forget('faqs');
    }

    public function updated(FAQ $faq)
    {
        Cache::forget('faqs');
    }

    public function deleted(FAQ $faq)
    {
        Cache::forget('faqs');
    }
}
