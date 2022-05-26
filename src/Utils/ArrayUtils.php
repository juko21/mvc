<?php 

namespace App\Utils;

class ArrayUtils
{
    public static function arrayFlip(array $array): ?array
    {
        $returnArray = [];
        $sameLength = array_map(function($y) { return count($y); }, $array);
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