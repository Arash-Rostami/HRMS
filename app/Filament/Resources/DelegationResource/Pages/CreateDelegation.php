<?php

namespace App\Filament\Resources\DelegationResource\Pages;

use App\Filament\Resources\DelegationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDelegation extends CreateRecord
{
    protected static string $resource = DelegationResource::class;

    protected static ?string $title = 'Authorities';


}
