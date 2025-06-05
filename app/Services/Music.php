<?php

namespace App\Services;

class Music
{

    public static $songs = [
        [
            'id' => 1,
            'image' => '/img/user/billie.webp',
            'audio' => '/audio/billie.mp3',
            'alt' => 'Billie Eilish',
            'theme' => '<i class="fas fa-dumbbell" title="Workout tunes"></i>',
            'css' => 'mb-4',
            'order' => 2
        ],
        [
            'id' => 2,
            'image' => '/img/user/danceMonkey.jpg',
            'audio' => '/audio/danceMonkey.mp3',
            'alt' => 'Dance Monkey',
            'theme' => '<i class="fas fa-dumbbell" title="Workout tunes"></i>',
            'css' => 'mb-1',
            'order' => 2
        ],
        [
            'id' => 3,
            'image' => '/img/user/duaLipa.webp',
            'audio' => '/audio/duaLipa.mp3',
            'alt' => 'Dua Lipa',
            'theme' => '<i class="fas fa-dumbbell" title="Workout tunes"></i>',
            'css' => 'mb-4',
            'order' => 2
        ],
        [
            'id' => 4,
            'image' => '/img/user/rema.webp',
            'audio' => '/audio/rema.mp3',
            'alt' => 'Rema',
            'theme' => '<i class="fas fa-dumbbell" title="Workout tunes"></i>',
            'css' => 'scale-90 mb-0 relative bottom-1',
            'order' => 2
        ],
        [
            'id' => 5,
            'image' => '/img/user/pomodoro1.jpg',
            'audio' => 'https://ia800508.us.archive.org/12/items/2.5-podomoro/2.5-podomoro.mp3',
            'alt' => 'Pomodoro - piano set',
            'theme' => '<i class="fas fa-bullseye" title="Focus tunes"></i>',
            'css' => 'scale-90 mb-0 relative bottom-1',
            'order' => 1
        ],
        [
            'id' => 6,
            'image' => '/img/user/pomodoro2.jpg',
            'audio' => 'https://ia600508.us.archive.org/23/items/3-pomodoro/3-pomodoro.mp3',
            'alt' => 'Pomodoro - low-fi ',
            'theme' => '<i class="fas fa-bullseye" title="Focus tunes"></i>',
            'css' => 'scale-90 mb-0 relative bottom-1',
            'order' => 1
        ],
        [
            'id' => 7,
            'image' => '/img/user/lewisCapaldi.jpg',
            'audio' => 'https://ia904509.us.archive.org/5/items/lc-someone/LC-Someone.mp3',
            'alt' => 'Lewis Capaldi',
            'theme' => '<i class="fas fa-bicycle" title="Recreation tunes"></i>',
            'css' => 'scale-90 mb-0 relative bottom-1',
            'order' => 3
        ],
        [
            'id' => 8,
            'image' => '/img/user/londonGrammar.jpg',
            'audio' => '/audio/LG.mp3',
            'alt' => 'London Grammar',
            'theme' => '<i class="fas fa-bicycle" title="Recreation tunes"></i>',
            'css' => 'scale-90 mb-0 relative bottom-1',
            'order' => 3
        ],
        [
            'id' => 9,
            'image' => '/img/user/paperKites.jpg',
            'audio' => '/audio/PK.mp3',
            'alt' => 'Paper Kites',
            'theme' => '<i class="fas fa-bicycle" title="Recreation tunes"></i>',
            'css' => 'scale-90 mb-0 relative bottom-1',
            'order' => 3
        ],
        [
            'id' => 10,
            'image' => '/img/user/sade.jpg',
            'audio' => '/audio/SS.mp3',
            'alt' => 'Sade',
            'theme' => '<i class="fas fa-bicycle" title="Recreation tunes"></i>',
            'css' => 'scale-90 mb-0 relative bottom-1',
            'order' => 3
        ],
        [
            'id' => 11,
            'image' => '/img/user/haevn.jpg',
            'audio' => '/audio/VR.mp3',
            'alt' => 'Haevn',
            'theme' => '<i class="fas fa-bicycle" title="Recreation tunes"></i>',
            'css' => 'scale-90 mb-0 relative bottom-1',
            'order' => 3
        ],
        [
            'id' => 12,
            'image' => '/img/user/stillCorners.jpg',
            'audio' => '/audio/SC.mp3',
            'alt' => 'Sill Corners',
            'theme' => '<i class="fas fa-bicycle" title="Recreation tunes"></i>',
            'css' => 'scale-90 mb-0 relative bottom-1',
            'order' => 3
        ],
        [
            'id' => 13,
            'image' => '/img/user/relaxingGuitar.jpg',
            'audio' => 'https://ia902703.us.archive.org/31/items/classic-guitar_202308/classic-guitar.mp3',
            'alt' => 'Relaxing Guitar',
            'theme' => '<i class="fas fa-bullseye" title="Focus tunes"></i>',
            'css' => 'mb-4 scale-x-90',
            'order' => 1
        ],
        [
            'id' => 14,
            'image' => '/img/user/classicalMusic.jpg',
            'audio' => 'https://ia902708.us.archive.org/3/items/classic-piano/classic-piano.mp3',
            'alt' => 'Classical Piano',
            'theme' => '<i class="fas fa-bullseye" title="Focus tunes"></i>',
            'css' => 'scale-90 mb-0 relative bottom-1',
            'order' => 1
        ],
        [
            'id' => 15,
            'image' => '/img/user/sofiaReyes.jpg',
            'audio' => '/audio/sofiaReyes.mp3',
            'alt' => 'Sofia Reyes',
            'theme' => '<i class="fas fa-dumbbell" title="Workout tunes"></i>',
            'css' => 'mb-4',
            'order' => 2
        ],
        [
            'id' => 16,
            'image' => '/img/user/katyPerry.jpg',
            'audio' => '/audio/katyPerry.mp3',
            'alt' => 'Katy Perry',
            'theme' => '<i class="fas fa-dumbbell" title="Workout tunes"></i>',
            'css' => 'scale-90 mb-0 relative bottom-1',
            'order' => 2
        ],
        [
            'id' => 17,
            'image' => '/img/user/chillMix.jpg',
            'audio' => 'https://ia800509.us.archive.org/18/items/chill-mix/ChillMix.mp3',
            'alt' => 'Chill Mix',
            'theme' => '<i class="fas fa-bullseye" title="Focus tunes"></i>',
            'css' => 'mb-4 scale-x-90',
            'order' => 1
        ],
        [
            'id' => 18,
            'image' => '/img/user/loFi.jpg',
            'audio' => 'https://ia600508.us.archive.org/17/items/lowfi_202308/lowFi.mp3',
            'alt' => 'Lo-Fi',
            'theme' => '<i class="fas fa-bullseye" title="Focus tunes"></i>',
            'css' => 'scale-x-90 mb-1 relative bottom-1',
            'order' => 1
        ],
        [
            'id' => 19,
            'image' => '/img/user/frankSinatra.jpg',
            'audio' => 'https://ia801805.us.archive.org/28/items/fs-strangers/FS-Strangers.mp3',
            'alt' => 'Frank Sinatra',
            'theme' => '<i class="fas fa-microphone" title="Oldies - 60s tunes"></i>',
            'css' => 'scale-x-90 mb-1 relative bottom-1',
            'order' => 5
        ],
        [
            'id' => 20,
            'image' => '/img/user/deanMartin.jpg',
            'audio' => 'https://ia803104.us.archive.org/25/items/dm-amore/DM-Amore.mp3',
            'alt' => 'Dean Martin',
            'theme' => '<i class="fas fa-microphone" title="Oldies - 60s tunes"></i>',
            'css' => 'scale-x-90 mb-1 relative bottom-1',
            'order' => 5
        ],
        [
            'id' => 21,
            'image' => '/img/user/perryComo.jpg',
            'audio' => 'https://ia904506.us.archive.org/9/items/pc-killing_202308/PC-Killing.mp3',
            'alt' => 'Perry Como',
            'theme' => '<i class="fas fa-microphone" title="Oldies - 60s tunes"></i>',
            'css' => 'scale-x-90 mb-1 relative bottom-1',
            'order' => 5
        ],
        [
            'id' => 22,
            'image' => '/img/user/natKingCole.jpg',
            'audio' => 'https://ia803104.us.archive.org/32/items/nk-smile/NK-Smile.mp3',
            'alt' => 'Nat King Cole',
            'theme' => '<i class="fas fa-microphone" title="Oldies - 60s tunes"></i>',
            'css' => 'scale-x-90 mb-1 relative bottom-1',
            'order' => 5
        ],
        [
            'id' => 23,
            'image' => '/img/user/luisArmstrong.jpg',
            'audio' => 'https://ia904509.us.archive.org/3/items/la-lavie/LA-Lavie.mp3',
            'alt' => 'Luis Armstrong',
            'theme' => '<i class="fas fa-microphone" title="Oldies - 60s tunes"></i>',
            'css' => 'scale-x-90 mb-1 relative bottom-1',
            'order' => 5
        ],
        [
            'id' => 24,
            'image' => '/img/user/dorisDay.jpg',
            'audio' => 'https://ia800505.us.archive.org/34/items/dd-autumn/DD-Autumn.mp3',
            'alt' => 'Doris Day',
            'theme' => '<i class="fas fa-microphone" title="Oldies - 60s tunes"></i>',
            'css' => 'scale-x-90 mb-1 relative bottom-1',
            'order' => 5
        ],
        [
            'id' => 25,
            'image' => '/img/user/nightTraveler.jpg',
            'audio' => '/audio/C.mp3',
            'alt' => 'Night Traveler',
            'theme' => '<i class="fas fa-compact-disc" title="Retro - 80s tunes"></i>',
            'css' => 'scale-y-90 mb-0 relative bottom-1',
            'order' => 4
        ],
        [
            'id' => 26,
            'image' => '/img/user/newConstellation.jpg',
            'audio' => 'https://ia801805.us.archive.org/0/items/nc-hot/NC-Hot.mp3',
            'alt' => 'New Constellation',
            'theme' => '<i class="fas fa-compact-disc" title="Retro - 80s tunes"></i>',
            'css' => 'mb-0 relative bottom-1',
            'order' => 4
        ],
        [
            'id' => 27,
            'image' => '/img/user/kalax.jpg',
            'audio' => 'https://ia601904.us.archive.org/21/items/k-out/K-Out.mp3',
            'alt' => 'Kalax',
            'theme' => '<i class="fas fa-compact-disc" title="Retro - 80s tunes"></i>',
            'css' => 'mb-0 relative bottom-1',
            'order' => 4
        ],
        [
            'id' => 28,
            'image' => '/img/user/fm84.jpg',
            'audio' => 'https://ia601801.us.archive.org/17/items/fm-running/FM-Running.mp3',
            'alt' => 'FM-84',
            'theme' => '<i class="fas fa-compact-disc" title="Retro - 80s tunes"></i>',
            'css' => 'mb-0 relative bottom-1',
            'order' => 4
        ],
        [
            'id' => 29,
            'image' => '/img/user/elvisPresley.jpg',
            'audio' => 'https://ia600504.us.archive.org/6/items/ep_20230908_202309/ep.mp3',
            'alt' => 'Elvis Presley',
            'theme' => '<i class="fas fa-microphone" title="Oldies - 60s tunes"></i>',
            'css' => 'scale-90 scale-y-80 mb-0 relative bottom-1',
            'order' => 5
        ],
        [
            'id' => 30,
            'image' => '/img/user/peggyLee.jpg',
            'audio' => 'https://ia800504.us.archive.org/31/items/pl_20230908_20230908/PL.mp3',
            'alt' => 'Peggy Lee',
            'theme' => '<i class="fas fa-microphone" title="Oldies - 60s tunes"></i>',
            'css' => 'mb-0 relative bottom-1',
            'order' => 5
        ],
    ];


    public static function getSongs()
    {
        return self::$songs;
    }


    public static function sortByTheme()
    {
        $sortedSongs = [];
        //sort based on theme
        foreach (self::$songs as $song) {
            $theme = $song['theme'];
            $sortedSongs[$theme][] = $song;
        }
        // sort based on order
        uasort($sortedSongs, fn($a, $b) => $a[0]['order'] - $b[0]['order']);

        return $sortedSongs;
    }
}
