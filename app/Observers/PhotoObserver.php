<?php

namespace App\Observers;

use App\Models\Photo;

class PhotoObserver
{
    public function updated(Photo $photo)
    {
        $this->deleteRemovedPhotos($photo);
    }

    /**
     * Handle the Photo "deleted" event.
     *
     * @param \App\Models\Photo $photo
     * @return void
     */
    public function deleted(Photo $photo)
    {
        if ($photo->path && is_array($photo->path)) {
            foreach ($photo->path as $photoPath) {
                $fullPath = public_path($photoPath);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
        }
    }

    protected function deleteRemovedPhotos(Photo $photo)
    {
        $originalPhotos = $photo->getOriginal('path') ?? [];
        $currentPhotos = $photo->path ?? [];

        $photosToDelete = array_diff($originalPhotos, $currentPhotos);

        foreach ($photosToDelete as $photoPath) {
            $fullPath = public_path($photoPath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}
