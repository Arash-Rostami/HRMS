<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use App\Events\QuestionMade;
use App\Filament\Resources\QuestionResource;
use App\Models\User;
use App\Notifications\NotifyUsersQuestionOfMonth;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Notification;

class CreateQuestion extends CreateRecord
{
    protected static string $resource = QuestionResource::class;

    protected function beforeCreate(): void
    {
//        $emails = User::where('email', 'arashrostami@time-gr.com')->pluck('email')->toArray();
        $emails = User::getPresentUsers();
//        event(new QuestionMade($emails));

        Notification::route('mail', 'support@team.persolco.com')
            ->notify(new NotifyUsersQuestionOfMonth($emails));
    }
}
