<?php

namespace App\Filament\Resources\UserRoles\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserRoleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('ur_user_id'),
                TextEntry::make('ur_role_id')
                    ->numeric(),
            ]);
    }
}
