<?php

namespace App\Filament\Resources\DbUserUsrs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DbUserUsrInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->placeholder('-'),
                TextEntry::make('email')
                    ->label('Email address')
                    ->placeholder('-'),
                TextEntry::make('roles.role_name')
                    ->label('Roles')
                    ->badge()
            ]);
    }
}
