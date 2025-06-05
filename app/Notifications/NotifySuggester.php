<?php

namespace App\Notifications;

use App\Http\Livewire\suggestion\SuggestionNotifier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifySuggester extends Notification
{
    use Queueable;


    public $suggestion;
    public $message;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($person, $inputs)
    {
        $this->suggestion = $inputs;
        $this->message = SuggestionNotifier::constructMessage($person, $inputs, auth()->user()->forename);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from(env('MAIL_USERNAME'))
            ->subject($this->message['subject'])
            ->greeting($this->message['greeting'])
            ->line($this->message['openingLine'])
            ->line($this->message['closingLine'])
            ->action('View Suggestion', env('APP_URL') . '/main');

    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

}
