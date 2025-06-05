<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyUsersPost extends Notification
{
    use Queueable;


    protected array $emails;
    protected array $data;

    protected array $subjectLines = [
        "Exciting News: New HR Post Available!",
        "Hot Off the Press: Our Latest HR Post is Here!",
        "Get Informed: Discover Our Newest HR Post!",
        "Breaking News: Check Out Our Fresh HR Post!",
        "Stay Updated: Explore Our Latest HR Post!",
        "Attention HR Enthusiasts: Don't Miss Our New Post!",
        "Discover New Insights: Our HR Post is Now Live!"
    ];

    protected array $lines = [
        'We are thrilled to announce that a new HR post has just been published on the platform.',
        'We are excited to share that a new HR post is now available.',
        'We are delighted to announce that a new HR post has just gone live.',
        'We are pleased to announce that a new HR post has just been published.',
        'Explore the latest insights in our new HR post!',
        'Don\'t miss out on our newest HR post.',
        'Stay informed with our latest HR post.',
        'Get inspired with our fresh HR content.',
        'Stay ahead of the curve with our HR updates.',
        'Read the HR post everyone is talking about.',
        'Stay connected with our HR community through our post.',
    ];



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
            ->subject($this->showRandom('subject'))
            ->line($this->showRandom('line'))
            ->line('Make sure to check out "' . strip_tags($this->data['title']) . '" and stay ahead of the curve!')
            ->action('Read Post', env('APP_URL') . '/main')
            ->line('Thank you for being a part of our HR community.')
            ->bcc($this->emails);
    }

    private function showRandom($text)
    {
        return ($text == 'subject') ? $this->subjectLines[array_rand($this->subjectLines)] : $this->lines[array_rand($this->lines)];
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
