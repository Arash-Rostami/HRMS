<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
//    protected $cacheCleaner;
//
//    public function __construct()
//    {
//        $this->cacheCleaner = new CacheCleanerService('posts');
//    }

    public function created(Post $post)
    {
        $this->invalidatePostCache();
    }

    public function updated(Post $post)
    {
        $this->invalidatePostCache();
    }

    public function deleted(Post $post)
    {
        $this->invalidatePostCache();
    }

    private function invalidatePostCache()
    {
        for ($page = 1; $page <= 10; $page++) {
            $cacheKey = 'posts_' .$page;
            if (Cache::has($cacheKey)) {
                Cache::forget($cacheKey);
            }
        }
    }
}
