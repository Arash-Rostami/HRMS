<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnergyTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mind_score',
        'emotion_score',
        'physique_score',
        'soul_score',
        'overall_score',
        'answers',
        'completed_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
