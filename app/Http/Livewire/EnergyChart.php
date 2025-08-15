<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Energy\Test;
use App\Models\EnergyTest;
use App\Models\User;
use Livewire\Component;

class EnergyChart extends Component
{
    /**
     * This is a computed property, caching the result for the lifecycle of the request.
     */
    public function getUserProperty()
    {
        return auth()->user();
    }

    /**
     * This is a computed property.
     */
    public function getIsManagerProperty(): bool
    {
        return $this->user?->profile?->position === 'manager';
    }

    /**
     * This is a computed property.
     */
    public function getHistoryProperty(): array
    {
        $cutoff = now()->subMonths(18);

        return EnergyTest::query()
            ->where('user_id', $this->user->id)
            ->where(fn($q) => $q->where('completed_at', '>=', $cutoff)->orWhere('created_at', '>=', $cutoff))
            ->orderBy('completed_at')
            ->selectRaw("
                DATE_FORMAT(completed_at, '%Y-%m-%d') as date,
                mind_score as mind,
                emotion_score as emotion,
                physique_score as physique,
                soul_score as soul,
                overall_score as overall
            ")
            ->get()
            ->toArray();
    }

    /**
     * This is a computed property.
     */
    public function getCompanyAveragesProperty(): array
    {
        $cutoff = now()->subMonths(18);

        return EnergyTest::query()
            ->where('user_id', '!=', $this->user->id)
            ->where(fn($q) => $q->where('completed_at', '>=', $cutoff)->orWhere('created_at', '>=', $cutoff))
            ->selectRaw('
                    COALESCE(AVG(mind_score), 0) as mind,
                    COALESCE(AVG(emotion_score), 0) as emotion,
                    COALESCE(AVG(physique_score), 0) as physique,
                    COALESCE(AVG(soul_score), 0) as soul,
                    COALESCE(AVG(overall_score), 0) as overall
                ')
            ->first()
            ->toArray();
    }

    /**
     * This is a computed property.
     */
    public function getTeamMembersDataProperty(): array
    {
        if (!$this->isManager || !$this->user->profile?->department) {
            return [];
        }

        return User::query()
            ->whereHas('profile', fn($q) => $q->where('department', $this->user->profile->department))
            ->where('id', '!=', $this->user->id)
            ->with(['profile:user_id,department', 'latestEnergyTest'])
            ->get()
            ->map(function (User $member) {
                if (!$member->latestEnergyTest) {
                    return null;
                }
                return [
                    'name' => $member->full_name,
                    'scores' => [
                        'physique' => $member->latestEnergyTest->physique_score,
                        'emotion' => $member->latestEnergyTest->emotion_score,
                        'mind' => $member->latestEnergyTest->mind_score,
                        'soul' => $member->latestEnergyTest->soul_score,
                        'overall' => $member->latestEnergyTest->overall_score,
                    ]
                ];
            })
            ->filter()
            ->values()
            ->toArray();
    }

    public function getSectionsProperty(): array
    {
        return app(Test::class)->getQuestions()['sections'];
    }

    public function render()
    {
        return view('components.user.energy.chart',
            [
                'isManager' => $this->isManager,
                'history' => $this->history,
                'companyAverages' => $this->companyAverages,
                'teamMembersData' => $this->teamMembersData,
                'sections' => $this->sections,
            ]
        );
    }
}
