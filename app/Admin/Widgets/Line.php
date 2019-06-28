<?php

namespace App\Admin\Widgets;

use Illuminate\Support\Arr;

/**
 * 自定义chart.js Line统计图的挂件
 * @package App\Admin\Widgets
 */
class Line extends Chart
{
    protected $type = 'line';

    /**
     * Line constructor.
     *  example :
     *      $labels = ['2018-01-01', '2018-01-02'];
     *      $data = [
     *          ['line1', [1,2]],
     *          ['line2', [3,4]],
     *      ]
     *
     * @param array $labels
     * @param array $data
     */
    public function __construct($labels = [], $data = [])
    {
        $this->data['labels'] = $labels;

        $this->data['datasets'] = [];

        $this->add($data);
    }

    public function add($label, $data = [], $fillColor = '')
    {
        if (is_array($label)) {
            if (Arr::isAssoc($label)) {
                $this->data[] = $label;
            } else {
                foreach ($label as $item) {
                    call_user_func_array([$this, 'add'], $item);
                }
            }

            return $this;
        }

        $this->data['datasets'][] = [
            'type'         => $this->type,
            'label'         => $label,
            'data'          => $data,
            'borderColor'   => $fillColor,
            'fill'          => false,
        ];

        return $this;
    }

    protected function fillColor($data)
    {
        foreach ($data['datasets'] as &$item) {
            if (empty($item['borderColor'])) {
                $item['borderColor'] = array_shift($this->defaultColors);
            }
        }

        return $data;
    }

    public function script()
    {
        $config = json_encode([
            'type' => $this->type,
            'data' => $this->getData(),
            'options' => $this->options
        ]);

        return <<<EOT

(function() {
    var canvas = $("#{$this->elementId}").get(0).getContext("2d");
    var chart = new Chart(canvas, {$config});
})();
EOT;
    }
}
