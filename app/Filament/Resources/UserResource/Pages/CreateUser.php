<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Services\Lingo;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;


class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['open_password'] = Crypt::encryptString($data['password']);
        $data['password'] = Hash::make($data['password']);


        $data['details'] = Lingo::changeDirection($data['details']);

        return $data;
    }

}
