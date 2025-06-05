<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyUsersJob extends Notification
{
    use Queueable;


    protected $emails;
    protected $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $emails, array $data)
    {
        $this->emails = $emails;
        $this->data = $data;
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
            ->subject($this->showRandomSubjectLines())
            ->line('We are pleased to announce a new job position of "' . strip_tags($this->data['position']) . '"  available at our company.')
            ->action('View Job Position', env('APP_URL') . '/main')
            ->line('We kindly request your support in spreading the word about this exciting job position with your friends or family. As a token of gratitude, we also offer a bonus for any hired person you introduce.')
            ->line('Your support in spreading the word is greatly appreciated!')
            ->cc($this->emails);
    }


    private function showRandomSubjectLines()
    {
        $subjectLines = [
            "Career Opportunity Knocking: Check Out Our Latest Job Position!",
            "Exciting New Job Position: Help Us Spread the Word!",
            "Join Our Team: Refer Your Friends to This Amazing Job Opportunity!",
            "We're Hiring! Share This Job Position with Your Network!",
            "Grow Our Team: Recommend the Perfect Candidates for This Job!",
            "Refer Your Friends: We Have an Incredible Job Opening!",
            "Introducing a New Job Position: Share the News with Your Connections!"
        ];

        $randomKey = array_rand($subjectLines);

        return $subjectLines[$randomKey];
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
