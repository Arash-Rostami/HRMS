<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyUsersTicketCreated extends Notification
{
    use Queueable;

    protected $ticket;
    protected $ccRecipients;


    /**
     * Create a new notification instance.
     *
     * @param Ticket $ticket
     * @param array $ccRecipients
     */
    public function __construct(Ticket $ticket, array $ccRecipients = [])
    {
        $this->ticket = $ticket;
        $this->ccRecipients = $ccRecipients;
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
        $mailMessage = (new MailMessage)
            ->subject('New Ticket Created: ' . $this->ticket->request_subject)
            ->greeting('Hello ' . $notifiable->forename . ',')
            ->line('Through THS, a new ticket has been created by ' . $this->ticket->requester->fullName . '.')
            ->line('**Ticket Subject**: ' . $this->ticket->request_subject)
            ->line('**Priority**: ' . ucfirst($this->ticket->priority))
            ->action('View Ticket', route('filament.resources.tickets.edit', ['record' => $this->ticket->id]))
            ->line('Thank you for your attention.');

        if (!empty($this->ccRecipients)) {
            foreach ($this->ccRecipients as $ccEmail) {
                $mailMessage->cc($ccEmail);
            }
        }

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
