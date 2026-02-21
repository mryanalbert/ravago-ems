<?php

namespace App\Filament\Resources\UserRoles\Pages;

use App\Filament\Resources\UserRoles\UserRoleResource;
use App\Models\UserRole;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUserRoles extends ListRecords
{
    protected static string $resource = UserRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All')
                // Count all records for the 'All' tab
                ->badge(UserRole::count()),

            'super-admin' => Tab::make('Super Admin')
                ->modifyQueryUsing(function (Builder $query) {
                    $query->whereHas('roles', function ($q) {
                        $q->where('role_code', 'sa');
                    });
                })
                // Add the badge method using the same query conditions
                ->badge(UserRole::whereHas('roles', function ($q) {
                    $q->where('role_code', 'sa');
                })->count()),

            'admin' => Tab::make('Admin')
                ->modifyQueryUsing(function (Builder $query) {
                    $query->whereHas('roles', function ($q) {
                        $q->where('role_code', 'ad');
                    });
                })
                ->badge(UserRole::whereHas('roles', function ($q) {
                    $q->where('role_code', 'ad');
                })->count()),

            'manager' => Tab::make('Manager')
                ->modifyQueryUsing(function (Builder $query) {
                    $query->whereHas('roles', function ($q) {
                        $q->where('role_code', 'mngr');
                    });
                })
                ->badge(UserRole::whereHas('roles', function ($q) {
                    $q->where('role_code', 'mngr');
                })->count()),

            'user' => Tab::make('User')
                ->modifyQueryUsing(function (Builder $query) {
                    $query->whereHas('roles', function ($q) {
                        $q->where('role_code', 'mcn');
                    });
                })
                ->badge(UserRole::whereHas('roles', function ($q) {
                    $q->where('role_code', 'mcn');
                })->count()),
        ];
    }
}
