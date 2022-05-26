<?php

namespace App\ChartCreator;

use App\Repository\ArticleRepository;
use App\Repository\DemographicsRepository;
use App\Entity\Article;
use App\Entity\Demographics;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\UX\Chartjs\Builder\ChartBuilder;

/**
 * Class ChartCreator:
 * Initiates with datasets and options used for generating datasets and chart options
 * in the correct format to be used by chartjs. Datasets and charts
 * fetched with getDataset and getOptions
 *
 * @method array getDataset() Returns dataset formatted in array for chartjs
 * @method array getOptions() Returns options formatted in array for chartjs
 */
class ChartCreator
{
    private array $colors = [
        "rgb(255, 255, 175)",
        "rgb(175, 255, 255)",
        "rgb(255, 175, 255)",
        "rgb(255, 175, 175)",
        "rgb(175, 175, 255"
    ];
    private array $datax;
    private array $datay;
    private array $labels;
    private bool $inverted = false;
    private bool $multiple = false;
    private Chart $chart;
    private string $type;

    /**
     * Creates new ChartCreator object
     * Initiates with datasets and options used for generating datasets and chart options
     * in the correct format to be used by chartjs. Datasets and charts
     * fetched with getDataset and getOptions
     *
     * @param array $datax Array of dataset-values to be used for x-value on chart
     * @param array $datay Array of dataset-values to be used for y-value on chart
     * @param array $labels Array of labels for y-values
     * @param bool $inverted Whether chart colours are inverted or not
     */
    public function __construct(
        array $datax,
        array $datay,
        array $labels,
        bool $multiple,
        bool $inverted,
        string $type
    ) {
        $this->datax = $datax;
        $this->datay = $datay;
        $this->labels = $labels;
        $this->multiple = $multiple;
        $this->inverted = $inverted;
        $this->type = $type;
    }

    /**
     * createChartset()
     * Builds the charts from given data
     * 
     * @return Chart Returns the chart
     */
    public function createChart(): Chart {
        // Loop through datasets and create charts, if multiple line chart indicated, send all datasets at once
        // an finish loop after 1 iteration
        $chartBuilder = new ChartBuilder;
        $this->chart = $chartBuilder->createChart($this->type);
        $this->chart->setData($this->getDataset());
        $this->chart->setOptions($this->getOptions());
        return $this->chart;
    }

    /**
     * getCharts()
     * Returns chart
     * 
     * @return array Returns chart
     */
    public function getChart() {

        return $this->chart;
    }

    /**
     * getDataset
     * Formats and returns dataset with options and label as an array suitable for chartjs
     *
     * @return array Returns dataset formatted in array for chartjs
     */
    public function getDataset() : array
    {
        $dataset = ['labels' => $this->datax, 'datasets' => []];
        $fontColor = $this->inverted ? 'rgb(255, 255, 255)' : 'rgb(80, 80, 80)' ;
        $count = count($this->datay);
        for ($i = 0; $i < $count; $i++) {
            $dataset['datasets'][] = [
                'label' => $this->labels[$i],
                'fontColor' => $fontColor,
                'backgroundColor' => $this->colors[$i],
                'borderColor' => $this->colors[$i],
                "color" => $this->colors[$i],
                'data' => $this->datay[$i]
            ];
        }
        return $dataset;
    }

    /**
     * getOptions
     * Formats and returns options as an array suitable for chartjs
     *
     * @return array Returns options formatted in array for chartjs
     */
    public function getOptions()
    {
        $fontColor = $this->inverted ? 'rgb(255, 255, 255)' : 'rgb(80, 80, 80)' ;
        $gridColor = $this->inverted ? 'rgba(255, 255, 255, 0.3)' : 'rgb(80, 80, 80)';
        $options = [
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'labels' => [
                        'color' => $fontColor
                    ],
                    'position' => 'bottom'
                ]
            ],
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => max(array_map(function($item) { return max($item); }, $this->datay)),
                    'ticks' => [
                        'color' => $fontColor,
                    ],
                    'title' => [
                        'title' => $this->labels,
                        'color' => $fontColor
                    ],
                    'grid' => [
                        'color' => $gridColor,
                        'borderColor' => $gridColor
                    ]
                ],
                'x' => [
                    'ticks' => [
                        'color' => $fontColor,
                    ],
                    'grid' => [
                        'color' => $gridColor,
                        'borderColor' => $gridColor
                    ]
                ],
            ],
        ];
        return $options;
    }
}


/*
<?php

namespace App\ChartSettings;

use App\Repository\ArticleRepository;
use App\Repository\DemographicsRepository;
use App\Entity\Article;
use App\Entity\Demographics;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\UX\Chartjs\Builder\ChartBuilder;

/**
 * Class ChartSettings:
 * Initiates with datasets and options used for generating datasets and chart options
 * in the correct format to be used by chartjs. Datasets and charts
 * fetched with getDataset and getOptions
 *
 * @method array getDataset() Returns dataset formatted in array for chartjs
 * @method array getOptions() Returns options formatted in array for chartjs
class ChartSettings
{
    private array $colors = [
        "rgb(255, 255, 175)",
        "rgb(175, 255, 255)",
        "rgb(255, 175, 255)",
        "rgb(255, 175, 175)",
        "rgb(175, 175, 255"
    ];
    private array $datax;
    private array $datay;
    private array $labels;
    private bool $inverted = false;
    private ChartBuilder $chartBuilder;

    /**
     * Creates new ChartSettings object
     * Initiates with datasets and options used for generating datasets and chart options
     * in the correct format to be used by chartjs. Datasets and charts
     * fetched with getDataset and getOptions
     *
     * @param array $datax Array of dataset-values to be used for x-value on chart
     * @param array $datay Array of dataset-values to be used for y-value on chart
     * @param array $labels Array of labels for y-values
     * @param bool $inverted Whether chart colours are inverted or not
    public function __construct(
        ChartBuilder $chartBuilder,
        array $datax,
        array $datay,
        array $labels,
        bool $inverted
    ) {
        $this->chartBuilder = $chartBuilder;
        $this->datax = $datax;
        $this->datay = $datay;
        $this->labels = $labels;
        $this->inverted = $inverted;
    }

    /**
     * getDataset
     * Formats and returns dataset with options and label as an array suitable for chartjs
     *
     * @return array Returns dataset formatted in array for chartjs
    public function getDataset()
    {
        $dataset = ['labels' => $this->datax, 'datasets' => []];
        $fontColor = $this->inverted ? 'rgb(255, 255, 255)' : 'rgb(80, 80, 80)' ;
        $count = count($this->datay);
        for ($i = 0; $i < $count; $i++) {
            $dataset['datasets'][] = [
                'label' => $this->labels[$i],
                'fontColor' => $fontColor,
                'backgroundColor' => $this->colors[$i],
                'borderColor' => $this->colors[$i],
                "color" => $this->colors[$i],
                'data' => $this->datay[$i]
            ];
        }
        return $dataset;
    }

    /**
     * getOptions
     * Formats and returns options as an array suitable for chartjs
     *
     * @return array Returns options formatted in array for chartjs
    public function getOptions()
    {
        $fontColor = $this->inverted ? 'rgb(255, 255, 255)' : 'rgb(80, 80, 80)' ;
        $gridColor = $this->inverted ? 'rgb(255, 255, 255, 0.3)' : 'rgb(80, 80, 80)';
        $options = [
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'labels' => [
                        'color' => $fontColor
                    ],
                    'position' => 'bottom'
                ]
            ],
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => max($this->datay),
                    'ticks' => [
                        'color' => $fontColor,
                    ],
                    'title' => [
                        'title' => $this->labels,
                        'color' => $fontColor
                    ],
                    'grid' => [
                        'color' => $gridColor,
                        'borderColor' => $gridColor
                    ]
                ],
                'x' => [
                    'ticks' => [
                        'color' => $fontColor,
                    ],
                    'grid' => [
                        'color' => $gridColor,
                        'borderColor' => $gridColor
                    ]
                ],
            ],
        ];
        return $options;
    }
}
*/