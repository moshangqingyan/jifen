<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WxLabel extends Model
{
    public $table = 'wx_label';

    public function yxusers()
    {
        return $this->belongsToMany('App\Model\WxUser', 'wx_user_label', 'user_id', 'label_id');
    }

}
