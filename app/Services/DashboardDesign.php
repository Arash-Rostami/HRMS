<?php


namespace App\Services;


class DashboardDesign
{
    /**
     * @param $space
     * @return bool
     */
    public static function isNotInCenter($space): bool
    {
        return substr($space, 0, 1) != 5 && substr($space, 0, 1) != 7;
    }

    /**
     * @return string
     */
    public static function randomizeDesks(): string
    {
        $shapes = ["rhombus", "oval", "square"];
        return "components.dashboard." . $shapes[array_rand($shapes, 1)] . "-office";
    }

    /**
     * @return string
     */
    public static function showCar(): string
    {
        $colorSetOne = ["yellow", "tangerine", "orange", "teal", "green", "silver", "black", "blue"];
        $colorSetTwo = ["yellow", "orange", "silver", "black"];
        return $colorSetOne[array_rand($colorSetOne, 1)];
    }

    /**
     * @return string
     */
    public static function showObjects(): string
    {
        $objects = ["bookcase", "coffee-table", "folder", "sofa", "vas"];
        return "/img/" . $objects[array_rand($objects, 1)] . ".png";
    }
}
