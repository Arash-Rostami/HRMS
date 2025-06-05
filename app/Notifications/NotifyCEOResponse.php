<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyCEOResponse extends Notification
{
    use Queueable;

    protected $question;

    protected array $subject = [
        "Your Question Has Received a Response",
        "Update: Response Received for Your Inquiry",
        "Alert: A Response is In for Your Monthly Question",
        "Attention Required: Response to Your Question is Ready",
        "Notification: Response Received for Your Query",
        "Critical Update: A Response to Your Monthly Question",
        "Your Question Update: Response is Now Available",
        "Response Alert: Someone Answered Your Monthly Question",
        "Important Notice: Response to Your Monthly Question",
        "Response Alert! Your Monthly Question Has Answers",
        "Breaking News: Monthly Question Received a Reply",
        "Inbox Update: Response to Monthly Question",
        "Response Notification: Monthly Question Answered",
        "Urgent: Someone Responded to Your Monthly Question",
        "Monthly  Question Update: A Response is In",
        "Response Received: Your Monthly Question Has Answers",
        "Alert: New Response for Your Question",
    ];

    protected array $line = [
        "A new response has been submitted for the question you posted.",
        "Your posted question has received a response. Check it out now.",
        "The question you raised has just received a response. Review it kindly.",
        "A response has been submitted for your monthly question. Time to take a look!",
        "An answer is now available for the question you recently asked. Check it out.",
        "Attention: a response to your latest question is now in. Don't miss it!",
        "A response has been posted regarding your recent question.",
        "Important news! A response has been received for the question you posed.",
        "The question you asked has been answered. View the response now.",
        "Good news! There's a new response for the question you put forward.",
        "Take note: A response has been submitted for your question.",
        "Notification: Your monthly question has garnered a response. Check it out.",
        "Breaking News: Your monthly question now has a response. See the details.",
        "Urgent: Someone has responded to your monthly question. Check your updates.",
        "Your inbox has an update! A response has been received for your question.",
        "Notification: A response has arrived for the monthly question you posted.",
        "Breaking News: Your question has been answered. Read the response now.",
        "Urgent: Someone has responded to your monthly question. Review it please.",
        "Your question has received a response. Log in to see the details.",
        "Alert: Your question has a new response. Check it out now.",
    ];


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($question)
    {
        $this->question = $question;
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
            ->subject($this->showRandomText('subject'))
            ->line($this->showRandomText('line'))
//            ->action('View Response', env('APP_URL') . '/main')
            ->action('View Response', route('filament.resources.questions.edit', ['record' => $this->question->id]) . '?tab=results')
            ->line('Thank you for your leadership.');
    }

    private function showRandomText($text)
    {
        return ($text == 'subject') ? $this->subject[array_rand($this->subject)] : $this->line[array_rand($this->line)];
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
