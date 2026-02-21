<?php

namespace App\Filament\Resources\UserRoles\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserRoleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextEntry::make('users.name')
                            ->label('User'),
                        TextEntry::make('roles.role_name')
                            ->label('Role'),
                        IconEntry::make('ur_is_active')
                            ->label('Active')
                            ->boolean(),
                        TextEntry::make('ur_update_note')
                            ->label('Note')
                            ->columnSpanFull(),
                        TextEntry::make('createdBy.name')
                            ->label('Created by'),
                        TextEntry::make('ur_created_ts')
                            ->label('Created at')
                            ->dateTime(),
                        TextEntry::make('ur_updated_ts')
                            ->label('Updated at')
                            ->dateTime(),
                    ])
            ]);
    }
}
