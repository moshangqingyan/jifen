<?php

namespace App\Admin\Form;

use Encore\Admin\Form;
use Illuminate\Contracts\Support\Htmlable;

class ShowPageEditButton implements Htmlable
{
    public function toHtml()
    {
        return <<<EOT
<div class="btn-group pull-right" style="margin-right: 10px">
    <a href="{$this->getResource()}" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;编辑</a>
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
        $uriParams = parse_url(app('request')->getUri());
        $uriParams['path'] .= '/edit';
        return $uriParams['path'] . ( isset($uriParams['query']) ? '?'.$uriParams['query'] : '' );
    }
}