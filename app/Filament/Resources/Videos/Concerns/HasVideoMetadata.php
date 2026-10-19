<?php

namespace App\Filament\Resources\Videos\Concerns;

use App\Services\VideoMetadata;
use Illuminate\Support\Facades\Storage;

trait HasVideoMetadata
{
    /**
     * Fill the video metadata (size, mime type and duration) from the stored file.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function fillVideoMetadata(array $data): array
    {
        $path = $data['path'] ?? null;

        if (blank($path) || ! is_string($path)) {
            return $data;
        }

        $storage = Storage::disk('local');

        $data['size_bytes'] = $storage->size($path);
        $data['mime_type'] = $storage->mimeType($path) ?: 'video/mp4';
        $data['duration_seconds'] = (int) round(
            app(VideoMetadata::class)->durationInSeconds($storage->path($path)),
        );

        return $data;
    }
}
