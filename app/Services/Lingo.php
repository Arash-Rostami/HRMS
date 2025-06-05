<?php

namespace App\Services;

class Lingo
{
    // if data is in Persian, add dir:rtl to the tag
    public static function changeDirection($data)
    {
        return (isFarsi(strip_tags($data)))
            ? preg_replace('/<(?!br)(.*?)>/', '<$1 style="direction: rtl;">', $data)
            : $data;
    }
}
