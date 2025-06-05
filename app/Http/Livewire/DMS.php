<?php

namespace App\Http\Livewire;

use App\Models\Read;
use Livewire\Component;
use App\Models\DMS as DMSModel;
use Livewire\WithPagination;

class DMS extends Component
{
    use WithPagination;

    protected $docs;
    protected $types;
    public $confirmedDocs = [];
    public $readDocs = [];
    public $searchTerm = '';

    public function mount()
    {
        $reads = Read::where('user_id', auth()->id())
            ->where('read', true)
            ->get(['document_id', 'read_count']);

        $this->confirmedDocs = $reads->pluck('document_id')->unique()->toArray();

        $this->readDocs = $reads->where('read_count', '>', 0)->pluck('document_id')->unique()->toArray();
    }

    public function confirmRead($docId)
    {
        $this->confirmOrIncrementRead($docId);
    }

    public function incrementRead($docId)
    {
        $this->confirmOrIncrementRead($docId, true);
    }

    public function confirmOrIncrementRead($docId, $increment = false)
    {
        $document = DMSModel::find($docId);
        if ($document) {
            $readRecord = $document->reads()->firstOrCreate(
                ['user_id' => auth()->id()],
                ['read_count' => 0, 'read' => true]
            );

            if ($increment) {
                $readRecord->increment('read_count');
                $document->increment('combined_read_count');
            } else {
                if (!in_array($docId, $this->confirmedDocs)) {
                    $this->confirmedDocs[] = $docId;
                }
            }
        }
    }


    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function render()
    {
        $docsQuery = DMSModel::with('reads')->visibleToUser();

        if ($this->searchTerm) {
            $docsQuery->where(function ($query) {
                $query->where('title', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('code', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('version', 'like', '%' . $this->searchTerm . '%')
                    ->orWhereJsonContains('extra->category', $this->searchTerm)
                    ->orWhereJsonContains('extra->Category', $this->searchTerm)
                    ->orWhereJsonContains('extra->type', $this->searchTerm)
                    ->orWhereJsonContains('extra->Type', $this->searchTerm);
            });
        }
        $this->docs = $docsQuery->simplePaginate(10);

        $this->types = DMSModel::visibleToUser()
            ->get()
            ->filter(fn($item) => isset($item->extra['Type']) || isset($item->extra['type']))
            ->map(fn($item) => ($item->extra['Type'] ?? $item->extra['type']))
            ->filter()
            ->unique()
            ->values();

        return view('livewire.d-m-s', [
            'docs' => $this->docs,
            'types' => $this->types,
        ]);
    }
}
