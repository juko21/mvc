<?php

namespace  App\Utils;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class ArrayUtils.
 */
class ArrayUtilsTest extends TestCase
{
    /**
     * Test that arrayFlip correctly returns a flipped 2d array
     */
    public function testArrayFlip()
    {
        $array = [[1992, 1993, 1994], ["a", "b", "c"], [1.0, 2.0, 3.0]];
        $exp = [[1992, "a", 1.0], [1993, "b", 2.0], [1994, "c", 3.0]];
        $testArray = ArrayUtils::arrayFlip($array);
        $datay = [1, 2, 3, 4];
        $this->assertEquals($testArray, $exp);
    }

    /**
     * Test that arrayFlip correctly returns null for uneven 2d array
     */
    public function testArrayFlipUnevenArray()
    {
        $array = [[1992, 1993, 1994], ["a", "b"], [1.0, 2.0, 3.0, 4.0]];
        $exp = null;
        $testArray = ArrayUtils::arrayFlip($array);
        $datay = [1, 2, 3, 4];
        $this->assertEquals($testArray, $exp);
    }

}
