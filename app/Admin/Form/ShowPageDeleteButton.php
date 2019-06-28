<?php

namespace App\Admin\Form;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Illuminate\Contracts\Support\Htmlable;

class ShowPageDeleteButton implements Htmlable
{
    public function toHtml()
    {
        $confirm = trans('admin::lang.delete_confirm');
        $previousUrl = url()->previous();

        $script = <<<SCRIPT

$('.show-page-delete').unbind('click').click(function() {
    if(confirm("{$confirm}")) {
        $.ajax({
            method: 'post',
            url: '{$this->getResource()}',
            data: {
                _method:'delete',
                _token:LA.token,
            },
            success: function (data) {
                if (typeof data === 'object') {
                    if (data.status) {
                        toastr.success(data.message);
                        window.location.href="{$previousUrl}"; 
                    } else {
                        toastr.error(data.message);
                    }
                }
            }
        });
    }
});

SCRIPT;

        Admin::script($script);

        return <<<EOT
<div class="btn-group pull-right" style="margin-right: 10px">
    <a href="javascript:void(0);" class="btn btn-sm btn-default show-page-delete"><i class="fa fa-list"></i>&nbsp;删除</a>
</div>
EOT;
    }

    /**
     * 组装编辑的链接地址
     *
     * @return string
     */
    public function getResource()
    {
        return parse_url(app('request')->getUri())['path'];
    }
}