<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class NotifyAdminSurvey extends Notification
{
    use Queueable;

    public $report;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($report)
    {
        $this->report = $report;
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
            ->subject($this->report['days'] . '-day survey done by ' . $this->report['name'])
            ->greeting('Hi, here is the report:')
            ->line(new HtmlString("<b><i>Name: </i></b>"))
            ->line($this->report['name'])
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Resources: </i></b>"))
            ->line(str_repeat("★", $this->report['resource']) . str_repeat("☆", 5 - $this->report['resource']))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Role of Team: </i></b>"))
            ->line(str_repeat("★", $this->report['team']) . str_repeat("☆", 5 - $this->report['team']))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Role of manager: </i></b>"))
            ->line(str_repeat("★", $this->report['manager']) . str_repeat("☆", 5 - $this->report['manager']))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>PERSOL's goals: </i></b>"))
            ->line(str_repeat("★", $this->report['company']) . str_repeat("☆", 5 - $this->report['company']))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Decision to cooperate: </i></b>"))
            ->line(str_repeat("★", $this->report['join']) . str_repeat("☆", 5 - $this->report['join']))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Usefulness of process: </i></b>"))
            ->line(str_repeat("★", $this->report['newcomer']) . str_repeat("☆", 5 - $this->report['newcomer']))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Usefulness of Buddy: </i></b>"))
            ->line(str_repeat("★", $this->report['buddy']) . str_repeat("☆", 5 - $this->report['buddy']))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Recommendation for Buddy: </i></b>"))
            ->line($this->report['roleOfBuddy'])
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Challenges & Achievements: </i></b>"))
            ->line($this->report['challenge'])
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>The most useful stage: </i></b>"))
            ->line($this->report['stage'])
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Suggestion for stages: </i></b>"))
            ->line($this->report['improvement'])
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>General recommendations:  </i></b>"))
            ->line($this->report['suggestion'])
            ->line('Hope you would have a good :) day.');
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
