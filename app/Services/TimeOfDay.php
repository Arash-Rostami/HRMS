<?php

namespace App\Services;

class TimeOfDay
{
    public static $images = [
        'morning' => 'morning.jpg',
        'noon' => 'noon.jpg',
        'evening' => 'evening.jpg',
        'night' => 'night.jpg'
    ];

    public static function getImage()
    {
        $hour = date('H');

        $time = ($hour >= 5 && $hour < 11) ? 'morning' : (
        ($hour >= 11 && $hour < 16) ? 'noon' : (
        ($hour >= 16 && $hour < 20) ? 'evening' : 'night'
        )
        );

        return self::$images[$time];
    }
}

