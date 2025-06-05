<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyUsersQuestionOfMonth extends Notification
{
    use Queueable;


    protected array $emails;


    protected array $subjectLines = [
        "This Month's Must-See: CEO's Question Awaits Your Response!",
        "A Moment for Your Insight: Reply to the CEO's Monthly Query!",
        "Your Input Needed: Respond to the Monthly CEO Question!",
        "Speak Your Mind: CEO's Monthly Question Is Live!",
        "Join the Dialogue: CEO's Question of the Month is Here!",
        "Voice Your Views: The CEO Awaits Your Response!",
        "We Value Your Thoughts: Answer This Month's CEO Question!",
        "Engage with Leadership: Respond to Our CEO's Latest Question!",
        "Leadership Awaits Your Insight: Monthly CEO Question Ready for You!",
        "Your Perspective Matters: Chime in on the CEO's Question!",
        "Monthly Brief: Time to Answer the CEO's Question!",
        "Have Your Say: CEO's Monthly Prompt for You!",
        "Share Your Wisdom: CEO's Monthly Question Wants an Answer!",
        "Contribute Your Ideas: CEO's Question Ready for Discussion!",
        "Make Your Voice Heard: New Question from Our CEO!",
        "Your Feedback Requested: CEO's Monthly Conversation Starter!",
        "Lend Your Knowledge: New CEO Question Posted!",
        "A New Inquiry Awaits: CEO's Question of the Month!",
        "Insight Wanted: Reply to Our CEO's Latest Post!",
        "Curiosity Calls: Our CEO's Question Needs Your Thoughts!"
    ];


    protected array $lines = [
        'Dive into this month\'s conversation starter with our CEO\'s latest query.',
        'Got a minute? There\'s a new question from our CEO that needs your attention.',
        'Your insights are invaluable – let\'s hear them on this month\'s CEO question.',
        'Your response is key. Weigh in on the CEO\'s latest prompt!',
        'Calling all thought-leaders: What\'s your take on our CEO\'s latest question?',
        'Let\'s get interactive! The CEO\'s question of the month is waiting for you.',
        'Eager to hear your thoughts on this month\'s burning question from our CEO.',
        'What\'s your viewpoint? The CEO\'s monthly question is calling for answers.',
        'Here\'s a new opportunity to express your ideas – answer the CEO’s question.',
        'Shape our future with your reply to the CEO’s intriguing question this month.',
        'Add your perspective to the mix with our CEO’s current question.',
        'Take a few moments to respond to our CEO’s thought-provoking monthly question.',
        'Engage directly with the top – your response to our CEO’s question matters.',
        'Start a dialogue: What are your thoughts on the CEO’s latest ask?',
        'Jump into this month’s topic and share your insights with the CEO’s question.',
        'Can you answer our CEO’s question of the month? Log in now to contribute.',
        'Our CEO has asked, and now we’re anticipating your answer. Log in to reply.',
        'Your answers shape our vision. React to the CEO’s question now.',
        'Bring your unique perspective to our CEO’s monthly touchpoint – reply today.',
        'Your voice is impactful. Reflect and respond to our CEO’s monthly question.'
    ];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $emails)
    {
        $this->emails = $emails;
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
            ->action('View Question', env('APP_URL') . '/main')
            ->line('Thank you.')
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
