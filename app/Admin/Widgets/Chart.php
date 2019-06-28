<?php

namespace App\Admin\Widgets;

use Encore\Admin\Widgets\Chart\Chart as BaseChart;

class Chart extends BaseChart
{
    protected $type = '';

    protected $defaultColors = [
        '#dd4b39', '#00a65a', '#f39c12', '#008B8B',
        '#00c0ef', '#3c8dbc', '#0073b7', '#6495ED',
        '#39cccc', '#ff851b', '#01ff70', '#FFF68F',
        '#605ca8', '#f012be', '#777',   '#66CDAA',
        '#001f3f', '#9932CC', '#d2d7de', '#FFA500',
        '#8B658B', '#8B4513', '#cd5c5c', '#8B3A3A',
        '#0000EE', '#8B0000', '#CDC8B1', '#FFDEAD',
        '#A020F0', '#CDC9C9', '#836FFF', '#B452CD',
    ];

    public function getData()
    {
        return $this->fillColor($this->data);
    }
}
