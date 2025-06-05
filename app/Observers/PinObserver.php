<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PinObserver
{
//    protected $cacheCleaner;
//
//    public function __construct()
//    {
//        $this->cacheCleaner = new CacheCleanerService('pins');
//    }
    public function created(Post $post)
    {
        if ($post->pinned) {
            $this->invalidatePinCache();
        }
    }

    public function updated(Post $post)
    {
        if ($post->pinned) {
            $this->invalidatePinCache();
        }
    }

    public function deleted(Post $post)
    {
        if ($post->pinned) {
            $this->invalidatePinCache();
        }
    }

    private function invalidatePinCache()
    {
        for ($page = 1; $page <= 10; $page++) {
            $cacheKey = "pins_" . $page;
            if (Cache::has($cacheKey)) {
                Cache::forget($cacheKey);
            }
        }
    }
}
