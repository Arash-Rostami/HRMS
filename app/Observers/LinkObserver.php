<?php

namespace App\Observers;

use App\Models\Link;
use Illuminate\Support\Facades\Cache;

class LinkObserver
{
//    protected $cacheCleaner;
//
//    public function __construct()
//    {
//        $this->cacheCleaner = new CacheCleanerService('links');
//    }

    public function created(Link $link)
    {
        Cache::forget('links');
    }

    public function updated(Link $link)
    {
        Cache::forget('links');
    }

    public function deleted(Link $link)
    {
        Cache::forget('links');
    }
}
