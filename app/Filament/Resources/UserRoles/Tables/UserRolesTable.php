<?php

namespace App\Filament\Resources\UserRoles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserRolesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('users.name')
                    ->label('User')
                    ->searchable(),
                TextColumn::make('roles.role_name')
                    ->label('Role')
                    ->numeric()
                    ->sortable(),
                // IconColumn::make('ur_is_active')
                //     ->label('Active')
                //     ->boolean(),
                ToggleColumn::make('ur_is_active')
                    ->label('Active'),
                TextColumn::make('ur_created_ts')
                    ->label('Created at')
                    ->dateTime('M d, Y \@ h:ia')
                    ->sortable(),
                TextColumn::make('ur_updated_ts')
                    ->label('Updated at')
                    ->dateTime('M d, Y \@ h:ia')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('Active')
                    ->label('Is Active')
                    ->placeholder('All Users')
                    ->trueLabel('Active Users')
                    ->falseLabel('Inactive Users')
                    ->queries(
                        true: fn(Builder $query) => $query->where('ur_is_active', true),
                        false: fn(Builder $query) => $query->where('ur_is_active', false),
                    )
                    ->native(false),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
