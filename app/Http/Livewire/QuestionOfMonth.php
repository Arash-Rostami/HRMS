<?php

namespace App\Http\Livewire;

use App\Models\Question;
use App\Models\Response;
use App\Models\User;
use App\Notifications\NotifyCEOResponse;
use Livewire\Component;

class QuestionOfMonth extends Component
{

    public $questions;
    public string $response = '';


    public function mount()
    {
        $this->questions = data_get(Question::getUnansweredQuestions(), 'questions', collect());;
    }

    public function submitResponse($questionId)
    {
        $this->validate(['response' => 'required|string']);

        $question = Question::find($questionId);

        if ($question) {
            $response = new Response(['content' => $this->response, 'user_id' => auth()->id()]);

            $question->responses()->save($response);

            $ceo = User::where('forename', 'Pedram')->where('surname', 'Soltani')->first();
//            $ceo = User::where('forename', 'Arash')->where('surname', 'Rostami')->first();

            if ($ceo) {
                $ceo->notify(new NotifyCEOResponse($question));
            }
            session()->flash('success', 'Response submitted successfully!');

            return redirect()->route('user.panel');
        }
    }

    public function render()
    {
        return view('livewire.question-of-month');
    }
}
