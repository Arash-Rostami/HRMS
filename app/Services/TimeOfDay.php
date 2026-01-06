<?php

namespace App\Services;

class TimeOfDay
{
    public static $images = [
        'morning' => 'morning.jpeg',
        'noon' => 'noon.jpeg',
        'evening' => 'evening.jpeg',
        'night' => 'night.jpeg'
    ];

    public static function getImage()
    {
        $hour = date('H');

        $time = match (true) {
            $hour >= 5 && $hour < 11 => 'morning',
            $hour >= 11 && $hour < 16 => 'noon',
            $hour >= 16 && $hour < 20 => 'evening',
            default => 'night',
        };

        return self::$images[$time];
    }
}

