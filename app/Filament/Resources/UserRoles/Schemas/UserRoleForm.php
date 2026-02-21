<?php

namespace App\Filament\Resources\UserRoles\Schemas;

use App\Models\DbUserUsr;
use App\Models\Role;
use App\Models\UserRole;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class UserRoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('ur_role_id')
                    ->label('Role')
                    ->required()
                    ->options(function () {
                        return Role::orderBy('role_name')
                            ->pluck('role_name', 'role_id');
                    })
                    ->preload()
                    ->default(fn() => request()->query('role_id'))
                    // Lock it so they can't change it, but keep it 'dehydrated' so it saves
                    ->disabled(fn() => request()->has('role_id'))
                    ->dehydrated()
                    ->searchable(false)
                    ->native(false)
                    ->live(),
                Select::make('ur_user_id')
                    ->label('User')
                    ->required()
                    ->searchable()
                    // 1. Disable if role is not selected
                    ->disabled(fn(Get $get): bool => !$get('ur_role_id'))
                    ->getOptionLabelUsing(fn($value): ?string => DbUserUsr::find($value)?->name)
                    ->getSearchResultsUsing(function (string $search, Get $get) {
                        $roleId = $get('ur_role_id');

                        return DbUserUsr::query()
                            ->where('name', 'like', "%{$search}%")
                            ->whereDoesntHave('userRoles', function ($query) use ($roleId) {
                                $query->where('ur_role_id', $roleId);
                            })
                            ->limit(20)
                            ->pluck('name', 'userId');
                    })
                    ->options(function (Get $get) {
                        $roleId = $get('ur_role_id');
                        if (!$roleId) return [];

                        return DbUserUsr::query()
                            ->whereDoesntHave('userRoles', function ($query) use ($roleId) {
                                $query->where('ur_role_id', $roleId);
                            })
                            ->limit(10)
                            ->pluck('name', 'userId');
                    })
                    ->rules([
                        fn(Get $get, $record): Unique => Rule::unique('ems.user_roles', 'ur_user_id')
                            ->where('ur_role_id', $get('ur_role_id'))
                            ->ignore($record?->ur_id, 'ur_id'), // Ignores the current record if you are editing
                    ])
                    ->validationMessages([
                        'unique' => 'This user already has this role assigned.',
                    ]),
                Toggle::make('ur_is_active')
                    ->label('Active')
                    ->default(true)
                    ->required(),
                Textarea::make('ur_update_note')
                    ->label('Note')
                    ->required()
                    ->columnSpanFull()
            ]);
    }
}
