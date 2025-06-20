<?php

namespace App\Filament\Resources\FAQResource\Pages;

use App\Filament\Resources\FAQResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFAQ extends CreateRecord
{
    protected static string $resource = FAQResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['category'] = $data['category'] ?? $data['newCategory'];
        return $data;
    }
}
