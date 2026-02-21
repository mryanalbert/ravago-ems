<?php

namespace App\Filament\Resources\Roles\RelationManagers;

use App\Filament\Resources\UserRoles\UserRoleResource;
use Filament\Actions\Action;
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
                // We use a generic Action so it doesn't try to open a "Create" modal
                Action::make('add_role_assignment')
                    ->button()
                    ->url(function (): string {
                        // 1. Get the ID directly from the RelationManager's ownerRecord property
                        $roleId = $this->getOwnerRecord()->getKey();

                        // 2. Generate the base URL and manually append the query string
                        // This bypasses any issues with the getUrl array parameter stripping
                        return UserRoleResource::getUrl('create') . "?role_id={$roleId}";
                    }),
            ]);
    }
}
