<?php

    /**
     * "app/Helpers/helpers.php"
     *
     * This is a helper file to write custom functions to use accress Laravel
     *
         * This file is autoloaded using composer.json
         *
         * See: https://stackoverflow.com/questions/28290332/best-practices-for-custom-helpers-on-laravel-5
     */

 namespace oliverbj\cwreporter\Http;

class Helper
{
    /*
    * This function removes numbers in $array
    * higher than $value
    * example removeHiger($array, $key, 300) - this will remove all values higher than 300 in $array
    * return @array
    */
    public static function removeHigher($array, $key, $value)
    {
        foreach ($array as $subKey => $subArray) {
            if ($subArray[$key] > $value) {
                unset($array[$subKey]);
            }
        }
        return $array;
    }

    /*
    * This function removes the array items
    * that does not contain $value
    * example onlyKeepValue($array, $key, (Closed|DK)) - this will only keep where the values is "Closed" or "DK"
    * return @array
    */
    public static function onlyKeepValue($array, $key, $values)
    {
        foreach ($array as $subKey => $subArray) {
            if (!preg_match("/($values)/i", $subArray[$key])) {
                unset($array[$subKey]);
            }
        }
        return $array;
    }
}
