<?php

namespace App\Filament\Resources\DMSResource\Pages;

use App\Filament\Resources\DMSResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDMS extends CreateRecord
{
    protected static string $resource = DMSResource::class;

    protected static ?string $label = 'DMS';

}
