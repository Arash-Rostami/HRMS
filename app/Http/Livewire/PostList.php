<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostList extends Component
{
    public $posts;

    public function render()
    {
        $this->posts = Post::simplePaginate(2);
        return view('livewire.post-list', ['posts' => $this->posts]);
    }
}
