<?php

namespace App\Filament\Resources\Videos\Schemas;

use App\Rules\MinVideoDuration;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalles del destino')
                    ->description('Añade un título y la ubicación para identificar tu video.')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->placeholder('Ej.: Amanecer en Machu Picchu')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('location')
                            ->label('Lugar turístico')
                            ->placeholder('Ej.: Machu Picchu, Cusco, Perú')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('Descripción')
                            ->placeholder('Describe el recorrido y los detalles del lugar.')
                            ->rows(4)
                            ->columnSpanFull(),
                        Toggle::make('is_public')
                            ->label('Mostrar en Explorar')
                            ->helperText('Al activarlo, cualquier visitante podrá ver este video y sus comentarios. Puedes volver a hacerlo privado cuando quieras.')
                            ->default(false)
                            ->columnSpanFull(),
                    ]),
                Section::make('Archivo de video')
                    ->description('El archivo se guarda de forma privada; solo se mostrará al público si activas la opción anterior.')
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
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
                    ]),
            ]);
    }
}
