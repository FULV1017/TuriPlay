<?php

namespace App\Filament\Resources\Videos\Tables;

use App\Models\Video;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VideosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateHeading('No hay videos para mostrar')
            ->emptyStateDescription('Sube un video con la acción superior o ajusta la búsqueda para encontrar otro destino.')
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->weight(FontWeight::Medium)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('location')
                    ->label('Lugar turístico')
                    ->wrap()
                    ->placeholder('Sin ubicación registrada')
                    ->searchable(),
                TextColumn::make('is_public')
                    ->label('Visibilidad')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Público' : 'Privado')
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray'),
                TextColumn::make('duration_seconds')
                    ->label('Duración')
                    ->formatStateUsing(fn (?int $state): string => gmdate('i:s', (int) $state))
                    ->sortable(),
                TextColumn::make('size_bytes')
                    ->label('Tamaño')
                    ->formatStateUsing(fn (?int $state): string => number_format(((int) $state) / 1048576, 2).' MB')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Usuario')
                    ->searchable()
                    ->visible(fn (): bool => (bool) auth()->user()?->isAdmin()),
                TextColumn::make('created_at')
                    ->label('Subido')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('download')
                    ->label('Descargar')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Video $record): string => route('videos.download', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
