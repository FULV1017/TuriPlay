<?php

namespace App\Filament\Resources\Videos\Schemas;

use App\Rules\MinVideoDuration;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),
                TextInput::make('location')
                    ->label('Lugar turístico')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Descripción')
                    ->columnSpanFull(),
                FileUpload::make('path')
                    ->label('Video')
                    ->disk('local')
                    ->directory('videos')
                    ->visibility('private')
                    ->acceptedFileTypes([
                        'video/mp4',
                        'video/quicktime',
                        'video/x-matroska',
                        'video/webm',
                    ])
                    ->maxSize(512000)
                    ->rules([new MinVideoDuration(60)])
                    ->helperText('Duración mínima: 1 minuto. Tamaño máximo: 500 MB. Formatos: MP4, MOV, MKV o WEBM.')
                    ->required(),
            ]);
    }
}
