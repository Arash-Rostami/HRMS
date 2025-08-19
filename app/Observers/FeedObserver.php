<?php

namespace App\Observers;

use App\Models\Feed;

class FeedObserver
{
    public function deleted(Feed $feed)
    {
        if (is_array($feed->media_paths)) {
            foreach ($feed->media_paths as $mediaPath) {
                $fullPath = public_path($mediaPath);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
        }
    }

    public function updated(Feed $feed)
    {
        $this->deleteRemovedMedia($feed);
    }

    protected function deleteRemovedMedia(Feed $feed)
    {
        $originalMedia = $feed->getOriginal('media_paths') ?? [];
        $currentMedia = $feed->media_paths ?? [];

        if (!is_array($originalMedia) || !is_array($currentMedia)) return;

        $mediaToDelete = array_diff($originalMedia, $currentMedia);

        foreach ($mediaToDelete as $mediaPath) {
            $fullPath = public_path($mediaPath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}
