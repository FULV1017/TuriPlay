<?php

namespace App\Filament\Resources\Videos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Schema;

class VideoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('Subido por'),
                TextEntry::make('title')
                    ->label('Título'),
                TextEntry::make('location')
                    ->label('Lugar turístico'),
                TextEntry::make('description')
                    ->label('Descripción')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('duration_seconds')
                    ->label('Duración')
                    ->formatStateUsing(fn (?int $state): string => gmdate('i:s', (int) $state)),
                TextEntry::make('size_bytes')
                    ->label('Tamaño')
                    ->formatStateUsing(fn (?int $state): string => number_format(((int) $state) / 1048576, 2).' MB'),
                TextEntry::make('created_at')
                    ->label('Subido el')
                    ->dateTime('d/m/Y H:i'),
                ViewEntry::make('player')
                    ->label('Reproductor')
                    ->view('filament.infolists.video-player')
                    ->columnSpanFull(),
            ]);
    }
}
