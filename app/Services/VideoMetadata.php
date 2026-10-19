<?php

namespace App\Services;

use RuntimeException;
use Symfony\Component\Process\Process;

class VideoMetadata
{
    /**
     * Return the duration of a video file in seconds using ffprobe.
     */
    public function durationInSeconds(string $absolutePath): float
    {
        if (! is_file($absolutePath)) {
            throw new RuntimeException("No se encontró el archivo de video: {$absolutePath}");
        }

        $process = new Process([
            (string) config('services.ffprobe.path', 'ffprobe'),
            '-v', 'error',
            '-show_entries', 'format=duration',
            '-of', 'default=noprint_wrappers=1:nokey=1',
            $absolutePath,
        ]);

        $process->setTimeout(60);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new RuntimeException('ffprobe falló: '.trim($process->getErrorOutput()));
        }

        $duration = (float) trim($process->getOutput());

        if ($duration <= 0) {
            throw new RuntimeException('El archivo no parece ser un video válido.');
        }

        return $duration;
    }
}
