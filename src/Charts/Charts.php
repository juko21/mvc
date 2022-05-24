<?php

namespace App\Charts;

use App\Repository\ArticleRepository;
use App\Repository\DemographicsRepository;
use App\Entity\Article;
use App\Entity\Demographics;

class Charts
{
    /**
     * Creates a bar chart using chartjs
     */
    static function getBarChartSettings(array $datax, array $datay, array $label, bool $multiple = false, bool $inverted = false): array {
        $colors = ["rgb(255, 255, 175)", "rgb(175, 255, 255)", "rgb(255, 175, 255)", "rgb(255, 175, 175)", "rgb(175, 175, 255"];
        $fontColor = $inverted ? 'rgb(255, 255, 255)' : 'rgb(80, 80, 80)' ;
        $gridColor = $inverted ? 'rgb(255, 255, 255, 0.3)' : 'rgb(80, 80, 80)' ;
        $settings[] = ['labels' => $datax, 'datasets' => []];
        
        for($i = 0; $i < ($multiple ? count($datay) : 1); $i++){
            $settings[0]['datasets'][] = [
                'label' => $label[$i],
                'fontColor' => $fontColor,
                'backgroundColor' => $colors[$i],
                'borderColor' => $colors[$i],
                "color" => $colors[$i],
                'data' => $datay[$i]
            ];
        }
        $settings[] = [
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
                    'suggestedMax' => max($datay),
                    'ticks'=> [
                        'color' => $fontColor,
                    ], 
                    'title' => [
                        'title'=> $label,
                        'color' => $fontColor
                    ],
                    'grid'=> [
                        'color' => $gridColor,
                        'borderColor' => $gridColor
                    ]                           
                ],
                'x' => [
                    'ticks' => [
                        'color' => $fontColor,
                    ],
                    'grid'=> [
                        'color' => $gridColor,
                        'borderColor' => $gridColor
                    ]                    
                ],
            ],
        ];
        return $settings;
    }
}
