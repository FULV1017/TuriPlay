<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Perfil del usuario')
                    ->description('Datos de identificación y rol de la cuenta.')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nombre'),
                        TextEntry::make('email')
                            ->label('Correo'),
                        TextEntry::make('role')
                            ->label('Rol')
                            ->badge()
                            ->formatStateUsing(fn (?UserRole $state): string => $state?->label() ?? '-'),
                    ]),
                Section::make('Actividad de la cuenta')
                    ->description('Videos registrados y fecha de creación.')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('videos_count')
                            ->label('Videos')
                            ->state(fn ($record): int => $record->videos()->count()),
                        TextEntry::make('created_at')
                            ->label('Creado')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
