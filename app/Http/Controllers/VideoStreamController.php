<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VideoStreamController extends Controller
{
    public function stream(Video $video): BinaryFileResponse
    {
        abort_unless(auth()->check(), 403);

        Gate::authorize('view', $video);

        $path = Storage::disk('local')->path($video->path);

        abort_unless(is_file($path), 404);

        return response()->file($path);
    }

    public function download(Video $video): BinaryFileResponse
    {
        abort_unless(auth()->check(), 403);

        Gate::authorize('view', $video);

        $path = Storage::disk('local')->path($video->path);

        abort_unless(is_file($path), 404);

        $extension = pathinfo($video->path, PATHINFO_EXTENSION) ?: 'mp4';
        $filename = str($video->title)->slug()->append('.'.$extension)->toString();

        return response()->download($path, $filename);
    }
}
