<?php

namespace App\Filament\Resources\Roles\Tables;

use App\Filament\Resources\Roles\Pages\ViewRole;
use App\Filament\Resources\Roles\RoleResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RolesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('role_code')
                    ->searchable(),
                TextColumn::make('role_name')
                    ->searchable(),
            ])
            // ->recordUrl(fn($record) => RoleResource::getUrl('view', ['record' => $record]))
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->slideOver(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
