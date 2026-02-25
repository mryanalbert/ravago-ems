<?php

namespace App\Filament\Resources\DbUserUsrs;

use App\Filament\Resources\DbUserUsrs\Pages\CreateDbUserUsr;
use App\Filament\Resources\DbUserUsrs\Pages\EditDbUserUsr;
use App\Filament\Resources\DbUserUsrs\Pages\ListDbUserUsrs;
use App\Filament\Resources\DbUserUsrs\Pages\ViewDbUserUsr;
use App\Filament\Resources\DbUserUsrs\Schemas\DbUserUsrForm;
use App\Filament\Resources\DbUserUsrs\Schemas\DbUserUsrInfolist;
use App\Filament\Resources\DbUserUsrs\Tables\DbUserUsrsTable;
use App\Models\DbUserUsr;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class DbUserUsrResource extends Resource
{
    protected static ?string $model = DbUserUsr::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | UnitEnum | null $navigationGroup = 'User Management';

    protected static ?string $navigationLabel = 'Users';

    protected static ?string $modelLabel = 'Users';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->activeWithRoles();
    }

    public static function form(Schema $schema): Schema
    {
        return DbUserUsrForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DbUserUsrInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DbUserUsrsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDbUserUsrs::route('/'),
            'create' => CreateDbUserUsr::route('/create'),
            'view' => ViewDbUserUsr::route('/{record}'),
            'edit' => EditDbUserUsr::route('/{record}/edit'),
        ];
    }
}
