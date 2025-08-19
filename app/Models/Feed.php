<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feed extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'content',
        'media_paths',
        'poll_options',
    ];

    protected $casts = [
        'media_paths' => 'array',
        'poll_options' => 'array',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
