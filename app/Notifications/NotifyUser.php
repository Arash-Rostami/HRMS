<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyUser extends Notification
{
    use Queueable;

    protected $reservation;
    protected $user;


    /**
     * Create a new notification instance.
     *
     * @param $reservation
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
        $this->user = auth()->user();
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
        $link = (getDashboardType() == 'parking')
            ? (env('APP_URL') . "/sms/parking-map/{$this->reservation->getNumber()}")
            : (env('APP_URL') . "/sms/office-map/{$this->reservation->getNumber()}");
        return
            ((new MailMessage)->from(env('MAIL_USERNAME'))
                ->subject('successful reservation')
                ->greeting('Hi ' . $this->user->forename . ',')
                ->line('Thank you for reserving your ' . getDashboardType() . ' place.')
                ->line($this->reservation->sendText())
                ->action('view map', $link)
                ->line('Hope to see you soon :)'));
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
