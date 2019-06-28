<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\BatchAction;

class Listen extends BatchAction
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function script()
    {
        return <<<SCRIPT

$('.grid-check-row').unbind('click').bind('click', function () {


    $.ajax({
            method: 'get',
            url: '/code',
            data: {
                _token:LA.token,
                id: $(this).data('id'),
            },
            success: function (res) {
                window.open(res);
            }
        });
});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<a class='fa fa-file-image-o grid-check-row' title='查看二维码' data-id='{$this->id}'></a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}