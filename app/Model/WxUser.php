<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WxUser extends Model
{
    public $table = 'wx_user';

    /**
     * 一个用户有多个标签
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function labels()
    {
        return $this->belongsToMany('App\Model\WxLabel', 'wx_user_label', 'user_id', 'label_id');
    }
    public function insurances()
    {
        return $this->belongsToMany('App\Model\WxUserLabel', 'wx_user_label', 'user_id', 'label_id');
    }

    public function integral()
    {
        return $this->hasMany('App\Model\WxRecord', 'user_id', 'id');
    }
}
