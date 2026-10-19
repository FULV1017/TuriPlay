<?php

namespace App\Filament\Resources\Videos\Pages;

use App\Filament\Resources\Videos\Concerns\HasVideoMetadata;
use App\Filament\Resources\Videos\VideoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVideo extends CreateRecord
{
    use HasVideoMetadata;

    protected static string $resource = VideoResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $this->fillVideoMetadata($data);
    }
}
