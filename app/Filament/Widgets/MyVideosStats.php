<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\FormatsVideoMetrics;
use App\Models\Video;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MyVideosStats extends StatsOverviewWidget
{
    use FormatsVideoMetrics;

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return ! (auth()->user()?->isAdmin() ?? false);
    }

    protected function getStats(): array
    {
        $query = Video::query()->where('user_id', auth()->id());

        return [
            Stat::make('Mis videos', (string) $query->count()),
            Stat::make('Duración total', $this->formatDuration((int) (clone $query)->sum('duration_seconds'))),
            Stat::make('Tamaño total', $this->formatSize((int) (clone $query)->sum('size_bytes'))),
        ];
    }
}
