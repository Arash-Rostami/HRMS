<?php

namespace App\Http\Livewire;

use App\Models\InstantMessage;
use App\Models\User;
use App\Notifications\NotifyUserByIM;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use LanguageDetection\Language;


class UserEmails extends Component
{
    public $content;
    public $users;
    public $user;
    public $topic;
    public $errors;


    protected $rules = [
        'user' => 'required',
        'topic' => 'required',
        'content' => 'required|min:2',
    ];

    protected $messages = [
        'user.required' => '* The recipient is required.',
        'topic.required' => '* The message topic is required.',
        'content.required' => '* The message should have some content.',
        'content.min' => '* It cannot be less than 2 letters.',
    ];


    public function mount()
    {
        $this->topic = '';
        $this->content = '';
        $this->users = User::whereNotIn('forename', ['Guest', 'guest'])->get();
        $this->user = '';
        $this->errors = [];
    }

    /**
     * @param mixed $recipient
     * @param mixed $topic
     * @param mixed $content
     * @return void
     */
    public function persistData(mixed $recipient, mixed $topic, mixed $content): void
    {
        $im = new InstantMessage();
        $im->sender_id = auth()->user()->id;
        $im->recipient_id = $recipient->id;
        $im->topic = $topic;
        $im->content = $content;
        $im->save();
    }

    /**
     * @return array
     */
    public function prepareData(): array
    {
        $topic = $this->topic;
        $content = $this->content;
        $recipient = User::where('email', $this->user)->firstOrFail();

        return array($topic, $content, $recipient);
    }

    /**
     * @return void
     */
    public function resetData(): void
    {
        if(session()->has('fa')) session()->forget('fa');

        $this->resetErrorBag();
        $this->resetExcept('users');
    }

    public function sendMessage()
    {
        return session()->flash('error', 'This module is temporarily suspended!');
//        $this->validate();
//        try {
//            list($topic, $content, $recipient) = $this->prepareData();
//
//            // prepare a session to reverse direction of message in view file
//            if(isFarsi($this->content)) session(['fa' => true]);
//            // Save the message in the InstantMessage model
//            $this->persistData($recipient, $topic, $content);
//
//            Notification::send($recipient,
//                (new NotifyUserByIM(compact('topic', 'content', 'recipient'))));
//            //this is to prepare the page for another notification
//            $this->resetData();
//            //trigger notification
//            session()->flash('message', 'Your quick message was sent successfully!');
//        } catch (\Exception $e) {
//            session()->flash("error", "Your quick message could NOT be sent!");
//        }
    }

    public function render()
    {
        return view('livewire.user-emails');
    }


    public function updateContent($content)
    {
        $this->content = $content;
    }
}
