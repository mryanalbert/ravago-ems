<?php

namespace App\Filament\Resources\DbUserUsrs\Pages;

use App\Filament\Resources\DbUserUsrs\DbUserUsrResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDbUserUsrs extends ListRecords
{
    protected static string $resource = DbUserUsrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
