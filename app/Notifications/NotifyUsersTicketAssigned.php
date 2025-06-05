<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyUsersTicketAssigned extends Notification
{
    use Queueable;

    protected $ticket;
    protected $requesterEmail;

    /**
     * Create a new notification instance.
     *
     * @param Ticket $ticket
     * @param string $requesterEmail
     */
    public function __construct(Ticket $ticket, string $requesterEmail)
    {
        $this->ticket = $ticket;
        $this->requesterEmail = $requesterEmail;
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
            ->subject('Ticket Update: Assignment and Status Notification')
            ->greeting('Hello,')
            ->line('The submitted ticket is now in progress and is assigned to ' .$this->ticket->assignee->fullName .'.')
            ->line('**Ticket Subject**: ' . $this->ticket->request_subject)
            ->line('**Priority**: ' . ucfirst($this->ticket->priority))
            ->line('To review the other details, please log in to HRMS.')
            ->line('Thank you for your cooperation and patience.')
            ->line('The PS Team')
            ->cc($this->requesterEmail);
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
