<?php

namespace App\Filament\Resources\JobResource\Pages;

use App\Filament\Resources\JobResource;
use App\Models\User;
use App\Notifications\NotifyUsersJob;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Notification;

class CreateJob extends CreateRecord
{
    protected static string $resource = JobResource::class;

    protected function beforeCreate(): void
    {
        if ($this->data['active']) {
//            $emails = User::where('email', 'arashrostami@time-gr.com')->pluck('email')->toArray();
            $emails = User::getPresentUsers();


            Notification::route('mail', 'support@team.persolco.com')
                ->notify(new NotifyUsersJob($emails, $this->data));
        }
    }
}
