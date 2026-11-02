<?php

namespace App\Filament\Pages;

use App\Filament\Resources\Videos\VideoResource;
use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Inicio';

    public function getTitle(): string|Htmlable
    {
        return auth()->user()?->isAdmin() ? 'Resumen de la plataforma' : 'Tu espacio de viajes';
    }

    public function getSubheading(): ?string
    {
        return auth()->user()?->isAdmin()
            ? 'Supervisa los videos, el almacenamiento y la actividad de los usuarios.'
            : 'Conserva tus recorridos y vuelve a vivir cada historia desde aquí.';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('uploadVideo')
                ->label('Subir video')
                ->icon('heroicon-o-arrow-up-tray')
                ->url(fn (): string => VideoResource::getUrl('create'))
                ->visible(fn (): bool => VideoResource::canCreate()),
        ];
    }
}
