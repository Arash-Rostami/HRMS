<?php

namespace App\Filament\Resources\SeatResource\Pages;

use App\Filament\Resources\SeatResource;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions;
use Filament\Resources\Form;
use Filament\Resources\Pages\ManageRecords;

class ManageSeats extends ManageRecords
{
    protected static string $resource = SeatResource::class;

    protected function getActions(): array
    {
        return [];
    }



}
