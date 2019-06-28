<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApiUser extends Model
{
    protected $table = 'api_user';

    const STATUS_ENABLE  = 1;
    const STATUS_DISABLE  = 2;

    const QUICK_PREMIUM_PRE_ENABLE  = 1;
    const QUICK_PREMIUM_PRE_DISABLE  = 0;

    public static $status = [
        self::STATUS_ENABLE => '启用',
        self::STATUS_DISABLE => '禁用',
    ];

    public static $quick_premium = [
        self::QUICK_PREMIUM_PRE_ENABLE => '启用',
        self::QUICK_PREMIUM_PRE_DISABLE => '禁用',
    ];

    /**
     * 一个用户会使用有多个保险公司
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function insurances()
    {
        return $this->belongsToMany('App\Model\Insurance', 'api_user_insurance', 'user_id', 'insurance_id');
    }

    /**
     * 用户提交的账号
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany('App\Model\InsuranceAccount', 'user_id', 'id');
    }

    /**
     * 分配给用户的账号
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function allotAccounts()
    {
        return $this->belongsToMany('App\Model\InsuranceAccount', 'api_user_insurance_account', 'user_id', 'account_id');
    }

    /**
     * 一个用户会使用有多个代理服务器
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function proxy()
    {
        return $this->belongsToMany('App\Model\Proxy', 'api_user_proxy', 'user_id', 'proxy_id');
    }

    /**
     * 一个用户会有多条接口统计记录
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function counts()
    {
        return $this->hasMany('App\Model\ApiUserCount', 'id', 'user_id');
    }

    /**
     * 一个用户可以使用接口
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function interfaces()
    {
        return $this->belongsToMany('App\Model\ApiInterface', 'api_user_interface', 'user_id', 'interface_id');
    }
}
