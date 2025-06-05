<?php

namespace App\Services;

class RandomMessage
{

    private static array $birthdayMessages = [
        "Wishing you a day filled with happiness and a year filled with joy. Happy birthday!\n",
        "May your birthday be as special as you are. Happy birthday!\n",
        "Another adventure filled year awaits you. Wishing you a very happy and fun-filled birthday!\n",
        "May the joy that you have spread in the past come back to you on this day. Wishing you a very happy birthday!\n",
        "Wow, it is a big day as it is your birthday! Happy birthday! Happy birthday!\n",
        "This is a special day, and we want to make sure you enjoy it to the fullest. Wishing you a very happy birthday!\n",
        "May your birthday and every day be filled with the smiles, laughter, and love.\n",
        "Wishing you a day that is as special in every way as you are. Happy birthday!\n",
        "You are a gift to the world. Happy birthday!\n",
        "Celebrate your birthday today. Celebrate being happy every day.\n",
        "May this year be the best one yet. Wishing you all the happiness your heart can hold. Happy birthday!\n",
        "May your birthday be filled with many happy hours and your life with many happy birthdays. Happy birthday!\n",
        "You make life more fun for everyone you meet. Happy birthday!\n",
        "Wishing you a day that is as special as you are. Happy birthday!\n",
        "Set the world on fire with your dreams and use the flame to light a birthday candle. Happy birthday!\n",
        "May your birthday be the start of a year filled with good luck, good health, and much happiness. Happy birthday!\n",
        "Have a wonderful birthday. I wish your every day to be filled with lots of love, laughter, happiness, and the warmth of sunshine.\n",
        "May your birthday mark the beginning of a wonderful period of time in your life! Happy birthday!\n",
        "May your birthday be filled with many happy hours and your life with many happy birthdays. Happy birthday!\n",
        "Wishing you a birthday filled with joy and unforgettable moments!\n",
        "May your special day be as bright and cheerful as your smile. Happy birthday!\n",
        "Sending you lots of love and best wishes for a fantastic year ahead. Happy birthday!\n",
        "Another year older, wiser, and even more amazing. Happy birthday!\n",
        "May your heart be filled with dreams, your life with love, and your day with happiness. Happy birthday!\n",
        "May all your wishes come true on this special day. Happy birthday!\n",
        "Every day is a gift, but today is extra special. Happy birthday!\n",
        "May your birthday be filled with sunshine, laughter, and good friends!\n",
        "Another year older, another year better! Wishing you a very happy birthday!\n",
        "May your birthday be the start of a year filled with new adventures and happy memories!\n",
        "You deserve the happiest birthday ever! Wishing you all the best on your special day!\n",
        "Cheers to another year of being awesome! Happy birthday!\n",
        "May your birthday be the start of a year filled with good health, good fortune, and good times!\n",
        "You're the most amazing person I know. Happy birthday!\n",
        "Wishing you a birthday that's as fabulous as you are!\n",
    ];

    private static array $anniversaryMessages = [
        "Congratulations on your work anniversary!\n",
        "Happy work anniversary!\n",
        "Cheers to another year of success!\n",
        "Congratulations on your work anniversary! You are an inspiration to us all!\n",
        "Happy work anniversary! Your contributions to our team and the company have been immeasurable.\n",
        "Congratulations on your work anniversary! You are a valuable asset to our team and the company.\n",
        "Happy work anniversary! Your dedication and hard work have helped us achieve great things.\n",
        "Congratulations on your work anniversary! You are an integral part of our team and the company.\n",
        "Happy work anniversary! Your dedication and hard work have helped us grow and succeed.\n",
        "Congratulations on your work anniversary! You are a valuable member of our team and the company.\n",
        "Congratulations on your work anniversary! Your commitment to excellence is truly remarkable.\n",
        "Happy work anniversary! Your dedication and passion continue to inspire us all.\n",
        "Cheers to another year of success and accomplishments!\n",
        "Happy work anniversary! Your cooperation and teamwork have been instrumental in our achievements.\n",
        "Happy work anniversary! Your hard work and persistence have sent us to new heights.\n",
        "Congratulations on your work anniversary! Your contributions have made a great difference in our company's journey.\n",
        "Happy work anniversary! Your commitment to excellence is the foundation of our success.\n",
        "Congratulations on your work anniversary! We're grateful for your dedication and all that you've accomplished.\n"
    ];


    public static function getHeader($name)
    {
        return "PERSOL HRMS\nFROM: {$name}\n\n";
    }

    public static function getFooter()
    {
        return "\n لغو 11";
    }

    public static function getBDayMessage()
    {
        return self::getHeader(auth()->user()->fullName) . self::$birthdayMessages[array_rand(self::$birthdayMessages)] . self::getFooter();
    }

    public static function getAnniversaryMessage()
    {
        return self::getHeader(auth()->user()->fullName) . self::$anniversaryMessages[array_rand(self::$anniversaryMessages)] . self::getFooter();
    }

    public static function getCustomizedMessage($message)
    {
        return self::getHeader(auth()->user()->fullName) . $message . "\n" . self::getFooter();
    }

}
