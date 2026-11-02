<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos del usuario')
                    ->description('Identifica la cuenta y su correo de acceso.')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->placeholder('Ej.: María Quispe')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Correo')
                            ->placeholder('nombre@ejemplo.com')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),
                    ]),
                Section::make('Acceso y permisos')
                    ->description('Configura la contraseña y el rol de la cuenta.')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('password')
                            ->label('Contraseña')
                            ->placeholder('Introduce una contraseña')
                            ->password()
                            ->revealable()
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->helperText('Déjala vacía para no cambiarla.'),
                        Select::make('role')
                            ->label('Rol')
                            ->options(collect(UserRole::cases())->mapWithKeys(
                                fn (UserRole $role): array => [$role->value => $role->label()],
                            )->all())
                            ->default(UserRole::User->value)
                            ->required(),
                    ]),
            ]);
    }
}
