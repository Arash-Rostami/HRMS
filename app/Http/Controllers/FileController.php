<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController
{
    public function serveFile($file)
    {
        if (!Auth::check()) {
            session(['url.intended' => url()->current()]);
            return redirect()->route('login');
        }

        $baseDir = public_path('');
        $filePath = realpath($baseDir . DIRECTORY_SEPARATOR . $file);

        if (!$filePath || !str_starts_with($filePath, $baseDir) || !File::exists($filePath)) {
            abort(404, 'File not found or unauthorized access.');
        }

        // Return the file response with appropriate headers
        return Response::file($filePath);
    }

    public function serveDocument($file = 'index.html')
    {
        if (!Auth::check()) {
            session(['url.intended' => url()->current()]);
            return redirect()->route('login');
        }

        $filePath = $file;

        if (!Storage::disk('protected_docs')->exists($filePath)) {
            abort(404, 'File not found.');
        }

        $mimeTypes = [
            'html' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
        ];

        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $mimeType = $mimeTypes[$extension] ?? 'application/octet-stream';

        return new StreamedResponse(function () use ($filePath) {
            echo Storage::disk('protected_docs')->get($filePath);
        }, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"',
        ]);
    }
}
