<?php

namespace App\Observers;

use App\Models\Report;

class ReportObserver
{

    /**
     * Handle the Report "updating" event.
     *
     * @param \App\Models\Report $report
     * @return void
     */
    public function updating(Report $report)
    {
        // Delete the original file if the file_path attribute is changed
        if ($report->isDirty('file_path')) {
            $originalFilePath = $report->getOriginal('file_path');
            if ($originalFilePath) {
                unlink($originalFilePath);
            }
        }
    }

    /**
     * Handle the Report "deleted" event.
     *
     * @param \App\Models\Report $report
     * @return void
     */
    public function deleted(Report $report)
    {
        if ($report->file_path) {
            unlink($report->getOriginal('file_path'));
        }
    }
}
