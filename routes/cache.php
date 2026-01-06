<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {


    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');

        return response()->json([
            'message' => 'Caches cleared successfully!',
            'timestamp' => now()->toDateTimeString()
        ]);
    });


    Route::get('/set-cache', function () {
        Artisan::call('route:cache');
        Artisan::call('view:cache');

        return response()->json([
            'message' => 'Caches set successfully!',
            'timestamp' => now()->toDateTimeString()
        ]);
    });


    Route::get('/prune-cache', function () {
        $cachePath = storage_path('framework/cache/data');
        $files = File::allFiles($cachePath);
        $pruned = 0;
        $kept = 0;
        $errors = [];

        foreach ($files as $file) {
            try {
                $contents = file_get_contents($file->getPathname());
                $expiration = (int)substr($contents, 0, 10);

                if ($expiration < time()) {
                    File::delete($file->getPathname());
                    $pruned++;
                } else {
                    $kept++;
                }
            } catch (\Exception $e) {
                $errors[] = $file->getFilename() . ': ' . $e->getMessage();
            }
        }

        return response()->json([
            'message' => 'Cache pruning completed',
            'pruned' => $pruned,
            'kept' => $kept,
            'errors' => count($errors),
            'error_details' => $errors,
            'total_checked' => count($files),
            'timestamp' => now()->toDateTimeString()
        ]);
    });

});
