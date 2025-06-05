<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'start_date', 'end_date', 'content', 'active'];

    public function responses()
    {
        return $this->hasMany(Response::class);
    }


    public function uniqueResponses()
    {
        return $this->hasMany(Response::class)
            ->whereIn('id', function ($query) {
                $query->select(\DB::raw('MIN(id)'))
                    ->from('responses')
                    ->whereColumn('responses.content', 'content')
                    ->groupBy('content');
            });
    }


    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeInTime($query)
    {
        return $query->where('start_date', '<=', now()->format('Y-m-d'))
            ->where('end_date', '>=', now()->format('Y-m-d'));
    }

    public static function getUnansweredQuestions()
    {
        $cacheKey = 'unanswered_questions_' . auth()->id();

        return Cache::remember($cacheKey, 20, function () {
            $questions = static::whereDoesntHave('responses', function ($query) {
                $query->where('user_id', auth()->id());
            })
                ->inTime()
                ->active()
                ->get();

            $questionCount = $questions->count();

            return compact('questionCount', 'questions');
        });
    }
}
