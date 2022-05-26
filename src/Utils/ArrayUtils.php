<?php

namespace App\Utils;

/**
 * Class ArrayUtils:
 * IUtility class for arrays, so far only one method
 */
class ArrayUtils
{
    /**
     * Flips a 2d array on its side. Returns null if nested arrays not even in length
     *
     * @param array $array Array to be flpped
     * @return array|null Returns flipped 2d array or null if uneven
     */
    public static function arrayFlip(array $array): ?array
    {
        $returnArray = [];
        $sameLength = array_map(function ($item) {
            return count($item);
        }, $array);
        if (count(array_unique($sameLength)) == 1) {
            $count = count($array[0]);
            for ($i = 0; $i < $count; $i++) {
                foreach ($array as $value) {
                    $returnArray[$i][] = $value[$i];
                }
            }
            return $returnArray;
        }
        return null;
    }
}
