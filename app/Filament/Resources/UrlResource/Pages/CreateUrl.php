<?php

namespace App\Filament\Resources\UrlResource\Pages;

use App\Filament\Resources\UrlResource;
use App\Helpers\Shortener;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUrl extends CreateRecord
{
    protected static string $resource = UrlResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $short_code=Shortener::generateRandomString(3);
        $data['gen_code'] = $short_code;
        $data['gen_url']="http://127.0.0.1:8000/".$short_code;

        return $data;
    }
}
