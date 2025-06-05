<?php

namespace App\Services;

class AccessLevel
{

    public static function hasPermission($permission, $model)
    {
        // Allow users in User panel or with Developer role
        if (auth()->user()->role !== 'admin') {
            return true;
        }

        // Retrieve profilePermissions
        $profilePermissions = auth()->user()->permissions()
            ->where('model', $model)
            ->whereIn('permission', [$permission, 'all'])
            ->get();

        return $profilePermissions->contains(function ($profilePermission) {
            return $profilePermission->user_id === auth()->user()->id;
        });
    }
}
