<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\FormatsVideoMetrics;
use App\Models\User;
use App\Models\Video;
use Filament\Forms\Components\Select;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;

class AdminUserVideosStats extends Widget implements HasSchemas
{
    use FormatsVideoMetrics;
    use InteractsWithSchemas;

    public ?int $userId = null;

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.widgets.admin-user-videos-stats';

    public function mount(): void
    {
        $this->userId ??= User::query()->value('id');

        $this->form->fill(['userId' => $this->userId]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('userId')
                    ->label('Elegir usuario')
                    ->options(fn (): array => User::query()->orderBy('name')->pluck('name', 'id')->all())
                    ->searchable()
                    ->live(),
            ])
            ->statePath('');
    }

    public static function canView(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    /**
     * @return array<int, array{label: string, value: string}>
     */
    public function metrics(): array
    {
        $query = Video::query()->where('user_id', $this->userId);

        return [
            ['label' => 'Videos', 'value' => (string) $query->count()],
            ['label' => 'Duración total', 'value' => $this->formatDuration((int) (clone $query)->sum('duration_seconds'))],
            ['label' => 'Tamaño total', 'value' => $this->formatSize((int) (clone $query)->sum('size_bytes'))],
        ];
    }
}
