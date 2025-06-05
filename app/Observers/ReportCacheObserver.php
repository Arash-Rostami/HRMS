<?php

namespace App\Observers;

use App\Models\Report;
use Illuminate\Support\Facades\Cache;

class ReportCacheObserver
{
//    protected $cacheCleaner;
//
//    public function __construct()
//    {
//        $this->cacheCleaner = new CacheCleanerService('reports');
//    }

    public function created(Report $report)
    {
        $this->invalidateReportCache();
    }

    public function updated(Report $report)
    {
        $this->invalidateReportCache();
    }

    public function deleted(Report $report)
    {
        $this->invalidateReportCache();
    }

    private function invalidateReportCache()
    {
        for ($page = 1; $page <= 10; $page++) {
            $cacheKey = "reports_" . $page;
            if (Cache::has($cacheKey)) {
                Cache::forget($cacheKey);
            }
        }
    }
}
