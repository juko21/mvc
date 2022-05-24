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
    static function getBarChartSettingsSingle(array $datax, array $datay, string $label, bool $multiple): array {
        $settings[] = [
            'labels' => $datax,
            'datasets' => [
                [
                    'label' => $label,
                    'fontColor' => 'rgb(255, 255, 255)',
                    'backgroundColor' => 'rgb(255, 255, 255)',
                    'borderColor' => 'rgb(255, 255, 255)',
                    "color" => 'rgb(255, 255, 255)',
                    'data' => $datay
                ],
            ]
        ];
        
        $settings[] = [
            'plugins' => [
                'legend' => [
                    'labels' => [
                        'color' => "rgb(255, 255, 255)"
                    ],
                    'align' => 'end'
                ]
            ],
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => max($datay),
                    'ticks'=> [
                        'color' => 'rgb(255, 255, 255)',
                    ], 
                    'title' => [
                        'title'=> $label,
                        'color' => 'rgb(255, 255, 255)'
                    ],
                    'grid'=> [
                        'color' => 'rgba(255, 255, 255, 0.3)',
                        'borderColor' => 'rgba(255, 255, 255, 0.3)'
                    ]                           
                ],
                'x' => [
                    'ticks' => [
                        'color' => 'rgb(255, 255, 255)',
                    ],
                    'grid'=> [
                        'color' => 'rgba(255, 255, 255, 0.3)',
                        'borderColor' => 'rgba(255, 255, 255, 0.3)'
                    ]                    
                ],
            ],
        ];
        return $settings;
    }

    static function getBarChartSettings(array $datax, array $datay, array $label, bool $multiple = false): array {
        $colors = ["rgb(255, 255, 175)", "rgb(175, 255, 255)", "rgb(255, 175, 255)". "rgb(255, 175, 175)", "rgb(175, 175, 255"];
        
        $settings[] = ['labels' => $datax, 'datasets' => []];
        
        for($i = 0; $i < ($multiple ? count($datay) : 1); $i++){
            $settings[0]['datasets'][] = [
                'label' => $label[$i],
                'fontColor' => 'rgb(255, 255, 255)',
                'backgroundColor' => $colors[$i],
                'borderColor' => $colors[$i],
                "color" => $colors[$i],
                'data' => $datay[$i]
            ];
        }
        $settings[] = [
            'plugins' => [
                'legend' => [
                    'labels' => [
                        'color' => "rgb(255, 255, 255)"
                    ],
                    'align' => 'end'
                ]
            ],
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => max($datay),
                    'ticks'=> [
                        'color' => 'rgb(255, 255, 255)',
                    ], 
                    'title' => [
                        'title'=> $label,
                        'color' => 'rgb(255, 255, 255)'
                    ],
                    'grid'=> [
                        'color' => 'rgba(255, 255, 255, 0.3)',
                        'borderColor' => 'rgba(255, 255, 255, 0.3)'
                    ]                           
                ],
                'x' => [
                    'ticks' => [
                        'color' => 'rgb(255, 255, 255)',
                    ],
                    'grid'=> [
                        'color' => 'rgba(255, 255, 255, 0.3)',
                        'borderColor' => 'rgba(255, 255, 255, 0.3)'
                    ]                    
                ],
            ],
        ];
        return $settings;
    }
}
