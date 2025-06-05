<?php

namespace App\Filament\Resources\DMSResource\Pages;

use App\Filament\Resources\DMSResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDMS extends EditRecord
{
    protected static string $resource = DMSResource::class;

    protected static ?string $label = 'Document Management Service';

    protected static ?string $slug = 'DMS';



    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
