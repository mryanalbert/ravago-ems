<?php

namespace App\Filament\Resources\UserRoles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserRoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ur_user_id')
                    ->required(),
                TextInput::make('ur_role_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
