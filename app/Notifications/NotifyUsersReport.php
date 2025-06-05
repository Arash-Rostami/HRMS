<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyUsersReport extends Notification
{
    use Queueable;

    protected $emails;
    protected $data;

    protected $subjectLines = [
        "Exciting News: New Persol Report Available!",
        "Hot Off the Press: Our Latest Persol Report is Here!",
        "Get Informed: Discover Our Newest Persol Report!",
        "Breaking News: Check Out Our Fresh Persol Report!",
        "Stay Updated: Explore Our Latest Persol Report!",
        "Attention Team: Don't Miss Our New Persol Report!",
        "Unlock Insights: Our Persol Report is Now Live!",
        "Ignite Your Insights: Dive into Our Latest Persol Report",
        "Level Up Your Knowledge: Get Inspired by Our Persol Report",
        "Your Monthly Update: Explore Our New Persol Report",
        "Empower Your Decision Making: Discover Our Latest Persol Report",
        "The Insight You Need: Your Guide to Our New Persol Report"
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
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->showRandomSubjectLine())
            ->line('🎉 Exciting News from the ' . strip_tags($this->data['department']) . ' Department! 🎉')
            ->line('Explore the new report "' . strip_tags($this->data['title']) . '" and stay informed!')
            ->action('Read Report', env('APP_URL') . '/main')
            ->line('Let\'s keep growing together and shaping the future of our company.')
            ->line('Thank you for being an engaged member of our HR community.')
            ->bcc($this->emails);
    }

    private function showRandomSubjectLine()
    {
        return $this->subjectLines[array_rand($this->subjectLines)];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
