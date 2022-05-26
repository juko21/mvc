<?php

namespace  App\ChartCreator;
use Symfony\UX\Chartjs\Model\Chart;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class ChartCreatorTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateObject()
    {
        $datax = [1992, 1993];
        $datay = [1, 2, 3, 4];
        $chartCreator = new ChartCreator($datax, [$datay], ["Hamburgers per day"], true, true, "bar");
        $this->assertInstanceOf("\App\ChartCreator\ChartCreator", $chartCreator);
    }

    /**
     * Create game object and deal cards to player and dealer, assert
     * by calling methods counting cards in deck and hands
     */
    public function testCreateSingleLineChart()
    {
        $datax = [1992, 1993, 1993, 1994, 1995, 1996, 1997];
        $datay = [1, 2, 3, 4, 5, 6, 7];
        $chartCreator = new ChartCreator($datax, [$datay], ["Hamburgers per day"], true, true, "line");
        $chart = $chartCreator->createChart();
        print_r($chart);
        
        $this->assertInstanceOf("\Symfony\UX\Chartjs\Model\Chart", $chart);
    }
}