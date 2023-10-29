<?php

namespace App\Filament\Resources\SightingResource\Pages;

use App\Filament\Resources\SightingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSighting extends CreateRecord
{
    protected static string $resource = SightingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
    
        return $data;
    }
}
