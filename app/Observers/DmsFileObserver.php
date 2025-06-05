<?php

namespace App\Observers;

use App\Models\DMS;
use Illuminate\Support\Facades\File;

class DmsFileObserver
{
    public function updating(DMS $model)
    {
        if ($model->isDirty('file')) {
            $currentFile = $model->getOriginal('file');

            if ($currentFile && File::exists(public_path($currentFile))) {
                File::delete($currentFile);
            }
        }
    }

    public function deleting(DMS $model)
    {
        $currentFile = $model->getOriginal('file');

        if ($currentFile && File::exists(public_path($currentFile))) {
            File::delete($currentFile);
        }
    }
}
