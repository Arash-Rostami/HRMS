<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EnsureQuestionnaireIsCompleted
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) return $next($request);

        $user = auth()->user();
        $cacheKey = 'profile_initiate_energy_' . $user->id;

        // SCENARIO 1: Forced Period (25th to 30th)
        if (isForcedQuestionnairePeriod($user)) {
            Cache::lock($cacheKey . '_lock', 10)
                ->get(fn() => Cache::put($cacheKey, true, now()->addMinutes(60)));
        }

        // SCENARIO 2: Optional Period (20th to 25th)
        if (isOptionalQuestionnairePeriod($user)) {
            if (!$request->session()->get('dismissed_questionnaire', false)) {
                Cache::add($cacheKey, true, now()->addMinutes(60));
            }
        }

        return $next($request);
    }
}
