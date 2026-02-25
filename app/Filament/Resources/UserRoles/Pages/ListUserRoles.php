<?php

namespace App\Filament\Resources\UserRoles\Pages;

use App\Filament\Resources\UserRoles\UserRoleResource;
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
            'all' => Tab::make('All'),
            'super-admin' => Tab::make('Super Admin')
                ->modifyQueryUsing(function (Builder $query) {
                    $query->whereHas('role', function (Builder $q) {
                        $q->where('role_code', 'sa');
                    });
                }),
            'admin' => Tab::make('Admin')
                ->modifyQueryUsing(function (Builder $query) {
                    $query->whereHas('role', function (Builder $q) {
                        $q->where('role_code', 'ad');
                    });
                }),
            'manager' => Tab::make('Manager')
                ->modifyQueryUsing(function (Builder $query) {
                    $query->whereHas('role', function (Builder $q) {
                        $q->where('role_code', 'mngr');
                    });
                }),
        ];
    }
}
