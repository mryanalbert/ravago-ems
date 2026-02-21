<?php

namespace App\Filament\Resources\Roles\RelationManagers;

use App\Filament\Resources\UserRoles\UserRoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class UserRolesRelationManager extends RelationManager
{
    protected static string $relationship = 'userRoles';

    protected static ?string $relatedResource = UserRoleResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
