<?php

namespace App\Filament\Resources\FeedResource\Pages;

use App\Filament\Resources\FeedResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeed extends EditRecord
{
    protected static string $resource = FeedResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
