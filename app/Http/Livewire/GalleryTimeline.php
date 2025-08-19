<?php

namespace App\Http\Livewire;

use App\Models\Photo;
use Livewire\Component;

class GalleryTimeline extends Component
{
    public $photos, $hasMorePages;

    public $perPage = 1, $page = 1;

    public bool $isLoading = false;


    /**
     * Increment the page and load more photos when the user scrolls
     * to the end of the current list.
     */
    public function loadMore()
    {
        if ($this->isLoading || !$this->hasMorePages) return;

        $this->isLoading = true;
        $this->page++;
        $this->loadPhotos();
        $this->isLoading = false;
    }

    /**
     * Load photos from the database, ordered chronologically.
     */
    public function loadPhotos()
    {
        $dept = optional(auth()->user()->profile)->department ?? null;

        $photos = Photo::orderBy('event_date', 'desc')
            ->where(fn($q) => $q->whereNull('department')->orWhere('department', '')->orWhere('department', $dept))
            ->paginate($this->perPage, ['*'], 'page', $this->page);

        $this->hasMorePages = $photos->hasMorePages();
        $newPhotos = $photos->getCollection();
        $this->photos = $this->page > 1 ? $this->photos->concat($newPhotos) : $newPhotos;
    }

    public function mount()
    {
        $this->loadPhotos();
    }

    public function render()
    {
        return view('components.user.gallery.timeline');
    }
}
