<?php

namespace App\Observers;

use App\Models\Job;
use Illuminate\Support\Facades\Cache;

class JobObserver
{
//    protected $cacheCleaner;
//
//    public function __construct()
//    {
//        $this->cacheCleaner = new CacheCleanerService('jobs');
//    }

    public function created(Job $job)
    {
        Cache::forget('jobs');
    }

    public function updated(Job $job)
    {
        Cache::forget('jobs');
    }

    public function deleted(Job $job)
    {
        Cache::forget('jobs');
    }
}
