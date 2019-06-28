<?php
namespace App\Admin\Widgets;

use Illuminate\Support\Arr;

/**
 * 自定义chart.js Bar统计图的挂件
 * @package App\Admin\Widgets
 */
class Bar extends Chart
{
    protected $type = 'bar';

    protected $labels = [];

    /**
     * Bar constructor.
     *  example :
     *      $labels = ['2018-01-01', '2018-01-02'];
     *      $data = [
     *          ['Bar1', [1,2]],
     *          ['Bar2', [3,4]],
     *          ['Bar3', [1,5]],
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
            'backgroundColor'     => $fillColor,
        ];

        return $this;
    }

    protected function fillColor($data)
    {
        foreach ($data['datasets'] as &$item) {
            if (empty($item['backgroundColor'])) {
                $item['backgroundColor'] = array_shift($this->defaultColors);
            }
        }

        return $data;
    }

    public function script()
    {
        $data = $this->fillColor($this->data);
        $this->options = [
            'tooltips' => [
                'mode' => 'index',
                'intersect' => true
            ]
        ];
        $config = json_encode([
            'type' => $this->type,
            'data' => $data,
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
