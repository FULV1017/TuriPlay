<?php

namespace App\Filament\Resources\Videos\Pages;

use App\Filament\Resources\Videos\VideoResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewVideo extends ViewRecord
{
    protected static string $resource = VideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('download')
                ->label('Descargar')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn (): string => route('videos.download', $this->getRecord()))
                ->openUrlInNewTab(),
            EditAction::make(),
        ];
    }
}
