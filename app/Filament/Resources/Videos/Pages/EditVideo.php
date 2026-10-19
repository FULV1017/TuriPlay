<?php

namespace App\Filament\Resources\Videos\Pages;

use App\Filament\Resources\Videos\Concerns\HasVideoMetadata;
use App\Filament\Resources\Videos\VideoResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditVideo extends EditRecord
{
    use HasVideoMetadata;

    protected static string $resource = VideoResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->fillVideoMetadata($data);
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
