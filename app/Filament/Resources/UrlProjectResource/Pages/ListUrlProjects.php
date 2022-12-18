<?php

namespace App\Filament\Resources\UrlProjectResource\Pages;

use App\Filament\Resources\UrlProjectResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUrlProjects extends ListRecords
{
    protected static string $resource = UrlProjectResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
