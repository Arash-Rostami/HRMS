<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class NotifyAdminFeedback extends Notification
{
    use Queueable;

    public $feedback;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($feedback)
    {
        $this->feedback = $feedback;
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
//        dd( $this->feedback);
        return (new MailMessage)
            ->from(env('MAIL_USERNAME'))
            ->subject('First-day feedback provided by ' . $this->feedback['name'])
            ->greeting('Hi, here is the feedback of the meeting:')
            ->line(new HtmlString("<b><i>Name: </i></b>"))
            ->line($this->feedback['name'])
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Level of usefulness: </i></b>"))
            ->line(str_repeat("★", $this->feedback['usefulness']) . str_repeat("☆", 5 - $this->feedback['usefulness']))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Efficacy of meeting(length): </i></b>"))
            ->line(str_repeat("★", $this->feedback['length']) . str_repeat("☆", 5 - $this->feedback['length']))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Familiarity with PERSOL and team: </i></b>"))
            ->line(str_repeat("★", $this->feedback['staff_insight']) . str_repeat("☆", 5 - $this->feedback['staff_insight']))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Familiarity with PERSOL's products or services: </i></b>"))
            ->line(str_repeat("★", $this->feedback['product_insight']) . str_repeat("☆", 5 - $this->feedback['product_insight']))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Familiarity with PERSOL's payroll: </i></b>"))
            ->line(str_repeat("★", $this->feedback['info_insight']) . str_repeat("☆", 5 - $this->feedback['info_insight']))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Familiarity with IT support desk: </i></b>"))
            ->line(str_repeat("★", $this->feedback['it_insight']) . str_repeat("☆", 5 - $this->feedback['it_insight']))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Familiarity with other PERSOL's members: </i></b>"))
            ->line(str_repeat("★", $this->feedback['interaction']) . str_repeat("☆", 5 - $this->feedback['interaction']))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Familiarity with PERSOL's culture: </i></b>"))
            ->line(str_repeat("★", $this->feedback['culture']) . str_repeat("☆", 5 - $this->feedback['culture']))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Level of experience: </i></b>"))
            ->line(str_repeat("★", $this->feedback['experience']) . str_repeat("☆", 5 - $this->feedback['experience']))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Likelihood of recommendation: </i></b>"))
            ->line(str_repeat("★", $this->feedback['recommendation']) . str_repeat("☆", 5 - $this->feedback['recommendation']))
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>The most fav part: </i></b>"))
            ->line($this->feedback['most_fav'])
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>The least fav part: </i></b>"))
            ->line($this->feedback['least_fav'])
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>Proposed addition: </i></b>"))
            ->line($this->feedback['addition'])
            ->line(new HtmlString("<hr style='border-top: 1px dotted grey;'>"))
            ->line(new HtmlString("<b><i>General recommendations:  </i></b>"))
            ->line($this->feedback['suggestion'])
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
