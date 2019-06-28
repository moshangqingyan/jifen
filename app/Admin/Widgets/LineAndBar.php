<?php

namespace App\Admin\Widgets;

/**
 * 自定义chart.js Line Bar混合统计图的挂件
 * @package App\Admin\Widgets
 */
class LineAndBar extends Chart
{
    protected $line;

    protected $bar;

    public function __construct(Line $line, Bar $bar)
    {
        $this->line = $line;
        $this->bar = $bar;
    }

    public function getData()
    {
        $barDate = $this->bar->getData();
        $lineDate = $this->line->getData();

        $data = [
            'labels' => array_unique(array_merge($barDate['labels'], $lineDate['labels'])),
            'datasets' => array_merge($lineDate['datasets'], $barDate['datasets']),
        ];
        return $data;
    }

    public function script()
    {
        $config = json_encode([
            'type' => 'bar',
            'data' => $this->getData(),
            'options' => [
                'tooltips' => [
                    'mode' => 'index',
                    'intersect' => true
                ]
            ],
        ]);

        return <<<EOT

(function() {
    var canvas = $("#{$this->elementId}").get(0).getContext("2d");
    var chart = new Chart(canvas, {$config});
})();
EOT;
    }
}