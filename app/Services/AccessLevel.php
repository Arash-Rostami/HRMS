<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class AccessLevel
{
    public static function hasPermission($permission, $model)
    {
        $user = auth()->user();
        if (!$user) return false;

        // Allow users in User panel or with Developer role
        if ($user->role !== 'admin') return true;


        $allPermissions = Cache::remember("user_permissions_{$user->id}", 36000, function () use ($user) {
            return $user->permissions()->get(['model', 'permission']);
        });

        // Retrieve profilePermissions
        return $allPermissions
            ->where('model', $model)
            ->whereIn('permission', [$permission, 'all'])
            ->isNotEmpty();
    }
}
