<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nombre'),
                TextEntry::make('email')
                    ->label('Correo'),
                TextEntry::make('role')
                    ->label('Rol')
                    ->badge()
                    ->formatStateUsing(fn (?UserRole $state): string => $state?->label() ?? '-'),
                TextEntry::make('videos_count')
                    ->label('Videos')
                    ->state(fn ($record): int => $record->videos()->count()),
                TextEntry::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-'),
            ]);
    }
}
