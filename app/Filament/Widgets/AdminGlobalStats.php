<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\FormatsVideoMetrics;
use App\Models\User;
use App\Models\Video;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminGlobalStats extends StatsOverviewWidget
{
    use FormatsVideoMetrics;

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Videos', (string) Video::query()->count()),
            Stat::make('Usuarios', (string) User::query()->count()),
            Stat::make('Duración total', $this->formatDuration((int) Video::query()->sum('duration_seconds'))),
            Stat::make('Tamaño total', $this->formatSize((int) Video::query()->sum('size_bytes'))),
        ];
    }
}
