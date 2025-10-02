<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class TeamData
{
    public function applyRules(Builder $query, User $viewer): void
    {
        if (!$viewer->profile) {
            $query->whereRaw('1 = 0');
            return;
        }

        $query->where('status', 'active');


        $viewerProfile = $viewer->profile;
        $viewerDepartment = $viewerProfile->department;
        $isManager = $viewerProfile->position == 'manager';
        $rulesApplied = false;

        switch ($viewerDepartment) {
            case 'MA':
                $rulesApplied = true;
                if ($viewerProfile->gender == 'female') {
                    $query->where(function (Builder $q) {
                        $q->whereHas('profile', fn(Builder $pq) => $pq->where('position', 'manager')->where('department', '!=', 'MA'))
                            ->orWhereHas('profile', fn(Builder $pq) => $pq->where('department', 'CX'));
                    });
                } elseif ($viewerProfile->gender == 'male') {
                    $query->where(function (Builder $q) {
                        $q->whereHas('profile', fn(Builder $pq) => $pq->where('position', 'manager')->whereNotIn('department', ['CP', 'WP', 'CH', 'MA']))
                            ->orWhereHas('profile', fn(Builder $pq) => $pq->where('department', 'SO')->where('position', 'senior'));
                    });
                }
                break;

            case 'MK':
                if ($isManager) {
                    $rulesApplied = true;
                    $query->where(function (Builder $q) use ($viewerDepartment) {
                        $q->whereHas('profile', fn(Builder $pq) => $pq->where('department', $viewerDepartment))
                            ->orWhereHas('profile', fn(Builder $pq) => $pq->where('position', 'manager')->whereIn('department', ['CP', 'WP', 'CH']))
                            ->orWhereHas('profile', fn(Builder $pq) => $pq->where('position', 'expert')->whereIn('department', ['CH', 'SO']));
                    });
                }
                break;

            case 'HC':
            case 'HR':
                if ($isManager) {
                    $rulesApplied = true;
                    $query->whereHas('profile', fn(Builder $pq) => $pq->whereIn('department', [$viewerDepartment, 'AS', 'HC']));
                }
                break;

            case 'CP':
                $rulesApplied = true;
                if ($viewer->surname == 'Rashidbeygi') {
                    $query->where('surname', 'Adami');
                } elseif ($viewer->surname == 'Shirzadeh') {
                    $query->where('surname', 'Nafar');
                } else {
                    $query->whereRaw('1 = 0');
                }
                break;

            default:
                if ($isManager) {
                    $rulesApplied = true;
                    $query->whereHas('profile', fn(Builder $q) => $q->where('department', $viewerDepartment));
                }
        }

        if (!$rulesApplied) {
            $query->whereRaw('1 = 0');
        }
    }
}
