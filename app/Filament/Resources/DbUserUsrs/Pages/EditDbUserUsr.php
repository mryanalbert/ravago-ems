<?php

namespace App\Filament\Resources\DbUserUsrs\Pages;

use App\Filament\Resources\DbUserUsrs\DbUserUsrResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDbUserUsr extends EditRecord
{
    protected static string $resource = DbUserUsrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
