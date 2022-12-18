<?php

namespace App\Filament\Resources\UrlProjectResource\Pages;

use App\Filament\Resources\UrlProjectResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUrlProject extends EditRecord
{
    protected static string $resource = UrlProjectResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
