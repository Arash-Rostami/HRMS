<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Services\Lingo;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['details'] = Lingo::changeDirection($data['details']);

        return $data;
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()->action(function (Model $record) {
                $record->status = 'inactive';
                $record->save();
            })->requiresConfirmation(),
        ];
    }
}
