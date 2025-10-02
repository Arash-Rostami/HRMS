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

    public array $feedIds = [];
    public array $loadedDates = [];
    public array $newComments = [];
    public $editingCommentId;
    public $editingContent = '';
    public bool $hasMorePages = false;

    public function mount()
    {
        $this->loadMore();
    }

    public function loadMore()
    {
        $nextDateToLoad = Feed::query()
            ->whereNotIn(DB::raw('DATE(created_at)'), $this->loadedDates)
            ->latest('created_at')
            ->select(DB::raw('DATE(created_at) as feed_date'))
            ->first();

        if (!$nextDateToLoad) {
            $this->hasMorePages = false;
            return;
        }

        $date = $nextDateToLoad->feed_date;

        $newFeeds = Feed::whereDate('created_at', $date)->latest()->get(['id']);

        $this->feedIds = array_unique(array_merge($this->feedIds, $newFeeds->pluck('id')->toArray()));
        $this->loadedDates[] = $date;

        $this->hasMorePages = Feed::whereNotIn(DB::raw('DATE(created_at)'), $this->loadedDates)->exists();
    }

    public function render()
    {
        $feeds = collect();
        if (!empty($this->feedIds)) {
            $feeds = Feed::with(self::FEED_RELATIONS)
                ->whereIn('id', $this->feedIds)
                ->orderByRaw('FIELD(id, ' . implode(',', $this->feedIds) . ')')
                ->get();
        }

        foreach ($feeds as $feed) {
            if (!isset($this->newComments[$feed->id])) {
                $this->newComments[$feed->id] = '';
            }
        }

        return view('components.user.feed.timeline', [
            'feeds' => $feeds,
        ]);
    }

    public function addComment($feedId)
    {
        $this->validate(['newComments.' . $feedId => 'required|string|max:1000']);

        Comment::create([
            'feed_id' => $feedId,
            'user_id' => auth()->id(),
            'content' => $this->newComments[$feedId],
        ]);

        $this->newComments[$feedId] = '';
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::find($commentId);
        if ($comment) {
            $comment->delete();
        }
    }

    public function toggleReaction(int $feedId, string $emoji): void
    {
        DB::transaction(function () use ($feedId, $emoji) {
            $attrs = ['feed_id' => $feedId, 'user_id' => auth()->id()];
            $reaction = Reaction::where($attrs)->first();

            if ($reaction && $reaction->emoji === $emoji) {
                $reaction->delete();
            } else {
                Reaction::updateOrCreate($attrs, ['emoji' => $emoji]);
            }
        });
    }

    public function startEditing($commentId)
    {
        $comment = Comment::find($commentId);
        if (!$comment || $comment->user_id !== auth()->id()) return;

        $this->editingCommentId = $commentId;
        $this->editingContent = $comment->content;
    }

    public function updateComment(): void
    {
        $commentId = (int)$this->editingCommentId;
        $content = trim((string)$this->editingContent);

        if ($content !== '') {
            $this->validate(['editingContent' => 'string|max:1000']);
        }

        $comment = Comment::whereKey($commentId)->where('user_id', auth()->id())->first();

        if ($comment) {
            if ($content === '') {
                $comment->delete();
            } else {
                $comment->update(['content' => $content]);
            }
        }

        $this->reset(['editingCommentId', 'editingContent']);
    }
}
