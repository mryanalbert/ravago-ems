<?php

namespace App\Filament\Resources\DbUserUsrs\Pages;

use App\Filament\Resources\DbUserUsrs\DbUserUsrResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDbUserUsr extends ViewRecord
{
    protected static string $resource = DbUserUsrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
