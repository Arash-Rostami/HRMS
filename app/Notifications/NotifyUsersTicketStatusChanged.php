<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyUsersTicketStatusChanged extends Notification
{
    use Queueable;

    protected $ticket;

    /**
     * Create a new notification instance.
     *
     * @param Ticket $ticket
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
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
        $mailMessage = new MailMessage();
        $mailMessage->subject('Your Ticket Status Has Been Updated')
            ->greeting('Hello ' . $notifiable->forename . ',');

        if ($this->ticket->status === 'in-progress') {
            $mailMessage->line('Your ticket is in our queue and will be addressed as soon as possible by our team.')
                ->line('We will keep you updated on any significant progress.')
                ->line('**Ticket Subject**: ' . $this->ticket->request_subject)
                ->line('**Status**: In Progress')
                ->line('**Priority**: ' . ucfirst($this->ticket->priority))
                ->line('You may review the details of your ticket by clicking below.')
                ->action('View Ticket', route('user.panel.ths'))
                ->line('Thank you for your patience as we address your request.');
        } elseif ($this->ticket->status === 'closed') {
            $mailMessage->line('We are pleased to inform you that your ticket has been resolved and is now closed.')
                ->line('If you have any further questions or require additional support, please don’t hesitate to reach out.')
                ->line('**Ticket Subject**: ' . $this->ticket->request_subject)
                ->line('**Status**: Closed')
                ->line('**Priority**: ' . ucfirst($this->ticket->priority))
                ->line('For more information, please click below to view your ticket.')
                ->action('View Ticket', route('user.panel.ths'))
                ->line('Thank you for using our service.');
        } else {
            $mailMessage->line('The status of your ticket has been updated.')
                ->line('**Ticket Subject**: ' . $this->ticket->request_subject)
                ->line('**New Status**: ' . ucfirst($this->ticket->status))
                ->line('**Priority**: ' . ucfirst($this->ticket->priority))
                ->line('For more details, please view the ticket by clicking below.')
                ->action('View Ticket', route('user.panel.ths'))
                ->line('Thank you for staying with us.');
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
