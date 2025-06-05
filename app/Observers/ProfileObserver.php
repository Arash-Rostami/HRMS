<?php

namespace App\Observers;

use App\Models\Profile;
use Illuminate\Support\Arr;

class ProfileObserver
{

    /**
     * Handle the Profile "updated" event.
     *
     * @param \App\Models\Profile $profile
     * @return void
     */
    public function updated(Profile $profile)
    {
        // Handle image update
        if ($profile->isDirty('image')) {

            $oldImagePath = $profile->getOriginal('image');
            $newImagePath = $profile->image;

            // Delete old image
            if ($oldImagePath && $oldImagePath !== $newImagePath) {
                $fullPath = public_path($oldImagePath);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
        }

        $this->deleteRemovedAttachments($profile);
    }

    /**
     * Handle the Profile "deleted" event.
     *
     * @param \App\Models\Profile $profile
     * @return void
     */
    public function deleted(Profile $profile)
    {
        // Delete the image
        if ($profile->image) {
            $fullPath = public_path($profile->getOriginal('image'));
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        $this->deleteRemovedAttachments($profile);
    }

    protected function deleteRemovedAttachments(Profile $profile)
    {
        $originalAttachments = $profile->getOriginal('attachments');
        $currentAttachments = $profile->attachments ?? [];

        $attachmentsToDelete = array_diff($originalAttachments, $currentAttachments);

        foreach ($attachmentsToDelete as $attachment) {
            $fullPath = public_path($attachment);
            // Delete the attachment file from storage
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}
