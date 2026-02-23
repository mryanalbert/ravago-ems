<?php

namespace App\Filament\Resources\DbUserUsrs\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DbUserUsrForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                CheckboxList::make('roles')
                    ->relationship('roles', 'role_name') // 2nd param = column in roles table
                    ->columns(2)
                    ->bulkToggleable()
                    ->required()
                    ->searchable(),
            ]);
    }
}
