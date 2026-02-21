<?php

namespace App\Filament\Resources\UserRoles\Pages;

use App\Filament\Resources\UserRoles\UserRoleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserRole extends CreateRecord
{
    protected static string $resource = UserRoleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $timestamp = now()->toDateTimeString();

        $data['ur_created_by'] = auth()->id();

        $data['ur_created_ts'] = $timestamp;
        $data['ur_updated_ts'] = $timestamp;

        return $data;
    }
}
