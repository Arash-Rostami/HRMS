<?php

namespace App\Observers;

use App\Models\Delegation;
use Illuminate\Support\Facades\Cache;

class DelegationObserver
{
//    protected $cacheCleaner;

//    public function __construct()
//    {
//        $this->cacheCleaner = new CacheCleanerService('delegations');
//    }

    public function created(Delegation $delegation)
    {
        Cache::forget('delegations');
    }

    public function updated(Delegation $delegation)
    {
        Cache::forget('delegations');
    }

    public function deleted(Delegation $delegation)
    {
        Cache::forget('delegations');
    }
}
