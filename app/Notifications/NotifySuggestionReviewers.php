<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class NotifySuggestionReviewers extends Notification
{

    protected string $message;
    protected ?string $bccRecipient;

    public function __construct(string $message, ?string $bccRecipient = null)
    {
        $this->message = $message;
        $this->bccRecipient = $bccRecipient;
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

    public function toMail($notifiable)
    {
        $mailMessage = (new MailMessage)
            ->subject('🔔 Suggestion Requires Your Review')
            ->line($this->message)
            ->action('View Suggestion', env('APP_URL') . '/main')
            ->line('Thank you.');

        // Add CC recipient if provided
//        if ($this->bccRecipient) {
//            $mailMessage->bcc($this->bccRecipient);
//        }


        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }
}
