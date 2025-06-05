<?php

namespace App\Services;


use Illuminate\Support\Facades\{File, Log};

class CacheCleanerService
{
    protected string $keySegment;

    /**
     * Construct the service with a key segment.
     *
     * @param string $keySegment The segment of the cache key to look for when clearing cache.
     */
    public function __construct(string $keySegment)
    {
        $this->keySegment = $keySegment;
    }

    /**
     * Clear the entire cache directory based on the key segment.
     */
    public function clearCache()
    {
        $cacheBasePath = storage_path('framework/cache/data/' . $this->keySegment);

        if (!File::isDirectory($cacheBasePath)) {
            Log::channel('cache_operations')->warning("No cache directory found for: " . $this->keySegment);
            return false;
        }

        if (!File::deleteDirectory($cacheBasePath)) {
            Log::channel('cache_operations')->error("Failed to delete cache directory for: " . $this->keySegment);
            return false;
        }

        Log::channel('cache_operations')->info("Cache directory cleared for: " . $this->keySegment);
        return true;
    }
}

