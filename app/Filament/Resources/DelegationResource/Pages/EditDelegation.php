<?php

namespace App\Filament\Resources\DelegationResource\Pages;

use App\Filament\Resources\DelegationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDelegation extends EditRecord
{
    protected static string $resource = DelegationResource::class;

    protected static ?string $title = 'Authorities';


    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
