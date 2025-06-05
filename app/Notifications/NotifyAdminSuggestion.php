<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class NotifyAdminSuggestion extends Notification
{
    use Queueable;

    public $suggestion;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($suggestion)
    {
        $this->suggestion = $suggestion;
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
            ->from(env('MAIL_USERNAME'))
            ->subject('suggestion made by ' . $this->suggestion['name'])
            ->greeting('Hi, you have one suggestion to review:')
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Presented by: </i></b>"))
            ->line(($this->suggestion['presenter'] == 1 ? 'One person' : 'One team | group'))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Scope of suggestion: </i></b>"))
            ->line(($this->suggestion['scope'] == 1 ? 'For one or some' : 'For everyone'))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Title of suggestion: </i></b>"))
            ->line($this->suggestion['title'])
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Suggestion: </i></b>"))
            ->line($this->suggestion['suggestion'])
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Advantages to suggestion: </i></b>"))
            ->line($this->suggestion['advantage'])
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Method of implementation: </i></b>"))
            ->line($this->suggestion['method'])
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Financial estimate: </i></b>"))
            ->line($this->suggestion['estimate'])
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Stage of suggestion: </i></b>"))
            ->line('under inspection')
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Response: </i></b>"))
            ->line('N/A');

        $this->attachPhoto($mailMessage);

        $mailMessage->line('Hope you have a good day. :)');

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
        return [
            //
        ];
    }

    /**
     * @param MailMessage $mailMessage
     * @return void
     */
    public function attachPhoto(MailMessage $mailMessage): void
    {
        $photoPath = public_path() . $this->suggestion['photo'];

        if (strlen($this->suggestion['photo']) > strlen('/img/suggestions/')) {
            // Attach the photo to the email
            $mailMessage->attach($photoPath);
            $mailMessage->action('View Picture', $photoPath);
        }
    }
}
