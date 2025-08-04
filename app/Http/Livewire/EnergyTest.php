<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Energy\Test;
use App\Models\EnergyTest as EnergyModel;
use Livewire\Component;

class EnergyTest extends Component
{
    public int $step = 1, $totalSteps;
    public bool $canProceed = false, $canSubmit = false, $showSurvey = true;
    public float $progress = 0;
    public array $questions = [], $prompts = [], $sections = [], $answers = [];

    public function mount()
    {
        $hasRecent = EnergyModel::where('user_id', auth()->user()->id)
            ->where('completed_at', '>=', now()->subDays(25))
            ->exists();

        $this->showSurvey = !$hasRecent;

        if ($this->showSurvey) {
            ['questions' => $this->questions, 'prompts' => $this->prompts, 'sections' => $this->sections]
                = app(Test::class)->getQuestions();

            $this->totalSteps = count($this->questions);
            $this->answers = collect($this->questions)
                ->mapWithKeys(fn($qs, $cat) => [$cat => array_fill(0, count($qs), false)])
                ->toArray();

            $this->updateState();
        }
    }

    private function updateState(): void
    {
        $categories = array_keys($this->questions);
        $currentCategory = $categories[$this->step - 1];

        $this->canProceed = in_array(true, $this->answers[$currentCategory] ?? []);
        $this->canSubmit = $this->step === $this->totalSteps && collect($categories)->every(fn($cat) => in_array(true, $this->answers[$cat] ?? []));
        $this->progress = (($this->step - 1) / $this->totalSteps) * 100;
    }


    public function updatedAnswers($value, $name)
    {
        [$category, $index] = explode('.', $name);
        $index = (int)$index;
        $lastIndex = count($this->questions[$category]) - 1;

        if ($value) {
            $targetIndex = $index === $lastIndex ? range(0, $lastIndex - 1) : [$lastIndex];
            foreach ($targetIndex as $i) {
                $this->answers[$category][$i] = false;
            }
        }

        $this->updateState();
    }

    public function nextStep(): void
    {
        if ($this->step < $this->totalSteps) {
            $this->step++;
            $this->updateState();
        }
    }

    public function previousStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
            $this->updateState();
        }
    }

    public function submitTest(): void
    {
        $scores = $this->calculateScores();


        EnergyModel::create([
            'user_id' => auth()->id(),
            'answers' => $this->answers,
            'mind_score' => $scores['mind'],
            'emotion_score' => $scores['emotion'],
            'physique_score' => $scores['physique'],
            'soul_score' => $scores['soul'],
            'overall_score' => $scores['overall'],
            'completed_at' => now(),
        ]);

        session()->forget('show_energy_test');
        $this->emit('testCompleted');
    }

    private function calculateScores(): array
    {
        $scores =
            collect($this->questions)
                ->mapWithKeys(function ($qs, $category) {
                    $count = 0;
                    for ($i = 0; $i < count($qs) - 1; $i++) {
                        if ($this->answers[$category][$i] ?? false) $count++;
                    }
                    return [$category => $count];
                })
                ->toArray();

        $scores['overall'] = array_sum($scores);
        return $scores;
    }

    public function render()
    {
        return view('components.user.energy.wizard', ['categoryKeys' => array_keys($this->questions)]);
    }
}
