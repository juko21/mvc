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
     * Construct ChartCreator object and verify that the object is of right type
     */
    public function testCreateObject()
    {
        $datax = [1992, 1993];
        $datay = [1, 2, 3, 4];
        $chartCreator = new ChartCreator($datax, ["Hamburgers per day" => $datay], true, "bar");
        $this->assertInstanceOf("\App\ChartCreator\ChartCreator", $chartCreator);
    }

    /**
     * Construct ChartCreator object, create single line chart and verify that returned
     * chart is of right type
     */
    public function testCreateSingleLineChart()
    {
        $datax = [1992, 1993, 1993, 1994, 1995, 1996, 1997];
        $datay = [1, 2, 3, 4, 5, 6, 7];
        $chartCreator = new ChartCreator($datax, ["Hamburgers per day" => $datay], true, "bar");
        $chart = $chartCreator->createChart();

        $this->assertInstanceOf("\Symfony\UX\Chartjs\Model\Chart", $chart);
        $this->assertInstanceOf("\Symfony\UX\Chartjs\Model\Chart", $chartCreator->getChart());
    }

    /**
     * Construct ChartCreator object, create single line chart and verify that returned
     * chart is of right type
     */
    public function testCreateMultipleLineChart()
    {
        $datax = [1992, 1993, 1993, 1994, 1995, 1996, 1997];
        $datay = [
            "Numbers" => [1, 2, 3, 4, 5, 6, 7],
            "More numbers" => [4 ,6 ,4 ,8 ,4 ,4, 2],
            "Even more numbers" => [4 ,1 ,4 ,2 ,4 ,20, 3]
        ];
        $chartCreator = new ChartCreator($datax, $datay, false, "line");
        $chart = $chartCreator->createChart();

        $this->assertInstanceOf("\Symfony\UX\Chartjs\Model\Chart", $chart);
        $this->assertInstanceOf("\Symfony\UX\Chartjs\Model\Chart", $chartCreator->getChart());
    }

    /**
     * Construct ChartCreator object, create single line chart and verify that datasets
     * are generated correctly
     */
    public function testSingleLineDatasets()
    {
        $datax = [1992, 1993, 1993, 1994, 1995, 1996, 1997];
        $datay = [1, 2, 3, 4, 5, 6, 7];
        $chartCreator = new ChartCreator($datax, ["Hamburgers per day" => $datay], true, "bar");
        $exp = [
            'labels' => $datax,
            'datasets' => [
                [
                'label' => "Hamburgers per day",
                'fontColor' => 'rgb(255, 255, 255)',
                'backgroundColor' => 'rgb(255, 255, 175)',
                'borderColor' => 'rgb(255, 255, 175)',
                "color" => 'rgb(255, 255, 175)',
                'data' => $datay
                ]
            ]
        ];
        $this->assertEquals($exp, $chartCreator->getDataset());
    }

    /**
     * Construct ChartCreator object, create single line chart and verify that datasets
     * are generated correctly
     */
    public function testSingleLineOptions()
    {
        $datax = [1992, 1993, 1993, 1994, 1995, 1996, 1997];
        $datay = [1, 2, 3, 4, 5, 6, 7];
        $chartCreator = new ChartCreator($datax, ["Hamburgers per day" => $datay], true, "bar");
        $exp = [
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'labels' => [
                        'color' => 'rgb(255, 255, 255)'
                    ],
                    'position' => 'bottom'
                ]
            ],
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 7,
                    'ticks' => [
                        'color' => 'rgb(255, 255, 255)',
                    ],
                    'title' => [
                        'title' => ["Hamburgers per day"],
                        'color' => 'rgb(255, 255, 255)'
                    ],
                    'grid' => [
                        'color' => 'rgba(255, 255, 255, 0.3)',
                        'borderColor' => 'rgba(255, 255, 255, 0.3)'
                    ]
                ],
                'x' => [
                    'ticks' => [
                        'color' => 'rgb(255, 255, 255)',
                    ],
                    'grid' => [
                        'color' => 'rgba(255, 255, 255, 0.3)',
                        'borderColor' => 'rgba(255, 255, 255, 0.3)'
                    ]
                ],
            ],
        ];
        $this->assertEquals($exp, $chartCreator->getOptions());
    }

    /**
     * Construct ChartCreator object, create multiple line chart and verify that datasets
     * are generated correctly
     */
    public function testMultipleLineDatasets()
    {
        $datax = [1992, 1993, 1993, 1994, 1995, 1996, 1997];
        $datay = [
            "Numbers" => [1, 2, 3, 4, 5, 6, 7],
            "More numbers" => [4 ,6 ,4 ,8 ,4 ,4, 2],
            "Even more numbers" => [4 ,1 ,4 ,2 ,4 ,20, 3]
        ];
        $chartCreator = new ChartCreator($datax, $datay, false, "line");
        $exp = [
            'labels' => $datax,
            'datasets' => [
                [
                'label' => "Numbers",
                'fontColor' => 'rgb(80, 80, 80)',
                'backgroundColor' => 'rgb(255, 255, 175)',
                'borderColor' => 'rgb(255, 255, 175)',
                "color" => 'rgb(255, 255, 175)',
                'data' => [1, 2, 3, 4, 5, 6, 7]
                ],
                [
                'label' => "More numbers",
                'fontColor' => 'rgb(80, 80, 80)',
                'backgroundColor' => 'rgb(175, 255, 255)',
                'borderColor' => 'rgb(175, 255, 255)',
                "color" => 'rgb(175, 255, 255)',
                'data' => [4 ,6 ,4 ,8 ,4 ,4, 2]
                ],
                [
                'label' => "Even more numbers",
                'fontColor' => 'rgb(80, 80, 80)',
                'backgroundColor' => 'rgb(255, 175, 255)',
                'borderColor' => 'rgb(255, 175, 255)',
                "color" => 'rgb(255, 175, 255)',
                'data' => [4 ,1 ,4 ,2 ,4 ,20, 3]
                ]
            ]
        ];
        $this->assertEquals($exp, $chartCreator->getDataset());
    }

    /**
     * Construct ChartCreator object, create multiple line chart and verify that options
     * are generated correctly
     */
    public function testMultipleLineOptions()
    {
        $datax = [1992, 1993, 1993, 1994, 1995, 1996, 1997];
        $datay = [
            "Numbers" => [1, 2, 3, 4, 5, 6, 7],
            "More numbers" => [4 ,6 ,4 ,8 ,4 ,4, 2],
            "Even more numbers" => [4 ,1 ,4 ,2 ,4 ,20, 3]
        ];
        $chartCreator = new ChartCreator($datax, $datay, false, "line");
        $exp = [
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'labels' => [
                        'color' => 'rgb(80, 80, 80)'
                    ],
                    'position' => 'bottom'
                ]
            ],
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 20,
                    'ticks' => [
                        'color' => 'rgb(80, 80, 80)',
                    ],
                    'title' => [
                        'title' => array_keys($datay),
                        'color' => 'rgb(80, 80, 80)'
                    ],
                    'grid' => [
                        'color' => 'rgb(80, 80, 80)',
                        'borderColor' => 'rgb(80, 80, 80)'
                    ]
                ],
                'x' => [
                    'ticks' => [
                        'color' => 'rgb(80, 80, 80)',
                    ],
                    'grid' => [
                        'color' => 'rgb(80, 80, 80)',
                        'borderColor' => 'rgb(80, 80, 80)'
                    ]
                ],
            ],
        ];
        $this->assertEquals($exp, $chartCreator->getOptions());
    }
}
