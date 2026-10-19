<?php

namespace App\Filament\Widgets\Concerns;

trait FormatsVideoMetrics
{
    protected function formatDuration(int $seconds): string
    {
        $hours = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);
        $remaining = $seconds % 60;

        return $hours > 0
            ? sprintf('%d:%02d:%02d', $hours, $minutes, $remaining)
            : sprintf('%d:%02d', $minutes, $remaining);
    }

    protected function formatSize(int $bytes): string
    {
        return number_format($bytes / 1048576, 2).' MB';
    }
}
