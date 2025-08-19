<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Feed;
use App\Models\Reaction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FeedTimeline extends Component
{
    private const FEED_RELATIONS = ['user.profile', 'comments.user.profile', 'reactions.user.profile'];

    public $feeds, $newComments = [], $editingCommentId, $editingContent = '';
    public int $page = 1, $perPage = 1;
    public bool $hasMorePages = false;

    public function addComment($feedId)
    {
        $this->validate(['newComments.' . $feedId => 'required|string|max:1000']);

        Comment::create([
            'feed_id' => $feedId,
            'user_id' => auth()->id(),
            'content' => $this->newComments[$feedId],
        ]);

        $this->newComments[$feedId] = '';
        $this->refreshFeed($feedId);
    }


    public function deleteComment($commentId)
    {
        $comment = Comment::find($commentId);
        if (!$comment) return;

        $feedId = $comment->feed_id;
        $comment->delete();

        $this->refreshFeed($feedId);
    }

    public function loadFeeds()
    {
        $feeds = Feed::with(self::FEED_RELATIONS)
            ->latest()
            ->paginate($this->perPage, ['*'], 'page', $this->page);

        $this->hasMorePages = $feeds->hasMorePages();
        $newFeeds = $feeds->getCollection();
        $this->feeds = $this->page > 1 ? $this->feeds->concat($newFeeds) : $newFeeds;
        $this->newComments = $this->feeds->mapWithKeys(fn($feed) => [$feed->id => $this->newComments[$feed->id] ?? ''])->all();
    }

    public function loadMore()
    {
        if (!$this->hasMorePages) return;
        $this->page++;
        $this->loadFeeds();
    }

    public function mount()
    {
        $this->feeds = collect();
        $this->loadFeeds();
    }

    public function render()
    {
        return view('components.user.feed.timeline');
    }

    public function startEditing($commentId)
    {
        $comment = Comment::find($commentId);
        if (!$comment || $comment->user_id !== auth()->id()) return;

        $this->editingCommentId = $commentId;
        $this->editingContent = $comment->content;
    }

    public function toggleReaction(int $feedId, string $emoji): void
    {
        DB::transaction(function () use ($feedId, $emoji) {
            $attrs = ['feed_id' => $feedId, 'user_id' => auth()->id()];
            $reaction = Reaction::where($attrs)->first();

            $reaction && $reaction->emoji === $emoji
                ? $reaction->delete()
                : Reaction::updateOrCreate($attrs, ['emoji' => $emoji]);
        });

        $this->refreshFeed($feedId);
    }

    public function updateComment(): void
    {
        $commentId = (int)$this->editingCommentId;
        $content = trim((string)$this->editingContent);

        if ($content !== '') {
            $this->validate(['editingContent' => 'string|max:1000']);
        }

        $feedId = DB::transaction(function () use ($commentId, $content) {
            $comment = Comment::whereKey($commentId)
                ->where('user_id', auth()->id())
                ->lockForUpdate()
                ->first();

            if (!$comment) return null;

            $feedId = $comment->feed_id;
            $content === '' ? $comment->delete() : $comment->update(['content' => $content]);

            return $feedId;
        });

        if ($feedId !== null) $this->refreshFeed($feedId);
        $this->reset(['editingCommentId', 'editingContent']);
    }

    protected function refreshFeed($feedId)
    {
        $updatedFeed = Feed::with(self::FEED_RELATIONS)->find($feedId);
        if (!$updatedFeed) return;

        $this->feeds = $this->feeds->map(fn($feed) => $feed->id === $updatedFeed->id ? $updatedFeed : $feed)->values();
    }
}
