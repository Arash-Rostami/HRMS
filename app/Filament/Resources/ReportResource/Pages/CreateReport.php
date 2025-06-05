<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use App\Models\User;
use App\Notifications\NotifyUsersReport;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Notification;

class CreateReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;

    protected function beforeCreate(): void
    {
//        $emails = User::where('email', 'arashrostami@time-gr.com')->pluck('email')->toArray();
        $emails = User::getPresentUsers();

        Notification::route('mail', 'support@team.persolco.com')
            ->notify(new NotifyUsersReport($emails, $this->data));
    }
}
