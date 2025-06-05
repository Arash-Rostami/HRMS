<?php


namespace App\Services;


/**
 * Class Theme
 * @package App\Classes
 */
class Theme
{
    private static $theme;
    private static $mode;

    public static function getTheme(): array
    {
        return self::$theme = [
            'red-theme' => '#C82348',
            'blue-theme' => '#1785FF',
            'purple-theme' => '#673AB7',
            'oak-theme' => '#c1a26b',
            'teal-theme' => '#5EA1A1',
            'maroon-theme' => '#a15e7f',
            'grey-theme' => '#607D8B',
            'silver-theme' => '#a9a9a9',
            'orange-theme' => '#FFA500',
        ];
    }

    /**
     * @param $color
     * @return string
     */
    public static function changeColor($color): string
    {
        // if any nonsense is given
        if (isThemeOrModeActivated($color)) abort(404, 'No such place!');
        // check to see if it is theme or mode
        (Utility::isTheme($color))
            ? self::getTheme()
            : self::getMode();

        return self::$theme[$color] ?? self::$mode[$color];
    }

    /**
     * @return string[]
     */
    public static function getMode(): array
    {
        return self::$mode = [
            'light-mode' => '#F1F1F1',
            'dark-mode' => '#1B232E'
        ];
    }

    /**
     * @param mixed $selectedTheme
     * @return array|string[]
     */
    public static function setDefaultMode(mixed $selectedTheme): array
    {
        // check if theme is selected, rather than mode. Then drop theme for SVG
        if (str_contains($selectedTheme, '-theme')) {
            session(['svg' => str_replace('-theme', '', $selectedTheme)]);
        }


        if ($selectedTheme === null) {
            $cookieName = 'mode';
            $selectedMode = 'light-mode';
        } else {
            $cookieName = $selectedTheme;
            $selectedMode = $selectedTheme;
        }
        return array($cookieName, $selectedMode);
    }
}
