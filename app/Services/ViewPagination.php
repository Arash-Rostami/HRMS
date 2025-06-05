<?php

namespace App\Services;

class ViewPagination
{
    public static function create($table, $data)
    {
        return match ($table) {
            'post-table' => view('components.user.post-list', ['posts' => $data['posts']]),
            'report-table' => view('components.user.report-table', ['reports' => $data['reports']]),
            default => throw new \InvalidArgumentException("Invalid table: $table"),
        };
    }
}
