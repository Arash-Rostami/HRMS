<?php

namespace App\Filament\Resources\EnergyTestResource\Pages;

use App\Filament\Resources\EnergyTestResource;
use App\Http\Livewire\Energy\Test;
use Filament\Resources\Pages\ViewRecord;

class ViewEnergyTest extends ViewRecord
{
    protected static string $resource = EnergyTestResource::class;

    protected static string $view = 'filament.resources.energy-test-resource.pages.view-energy-test';

    public array $questions = [];
    public array $prompts = [];
    public array $sections = [];

    public function mount($record): void
    {
        parent::mount($record);

        ['questions' => $this->questions, 'prompts' => $this->prompts, 'sections' => $this->sections]
            = app(Test::class)->getQuestions();
    }

    public function getTitle(): string
    {
        return "Energy Questionnaire";
    }

    public function getSubheading(): string
    {
        return "Submitted by " . $this->record->user->full_name;
    }

    protected function getActions(): array
    {
        return [];
    }
}
