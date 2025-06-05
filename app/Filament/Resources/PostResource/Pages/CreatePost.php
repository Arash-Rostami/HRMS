<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\User;
use App\Notifications\NotifyUsersPost;
use App\Services\Lingo;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Notification;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['title'] = Lingo::changeDirection($data['title']);
        $data['body'] = Lingo::changeDirection($data['body']);

        return $data;
    }

    protected function afterCreate(): void
    {
//        $emails = User::where('email', 'arashrostami@time-gr.com')->pluck('email')->toArray();
        $emails = User::getPresentUsers();

        Notification::route('mail', 'support@team.persolco.com')
            ->notify(new NotifyUsersPost($emails, $this->data));
    }

}
