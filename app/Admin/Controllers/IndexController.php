<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public  $app_id = 'wx2d21558220e85656';
    public  $app_secret = 'b82b42e24f314681fae9486ea7888fe4';
    public function index(Request $request)
    {
        $id = $request->input('id');
        $code = array_get($_GET, 'code');
        if (!$code) {
            $APPID = $this->app_id;

            $ran = rand(1,100); //预防缓存

            $REDIRECT_URI = 'http://jifen.zteamtech.com/index?number='.$ran.'&id=' . $id; //一定写上http://

            $scope='snsapi_userinfo';

            $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$APPID.'&redirect_uri='.urlencode($REDIRECT_URI).'&response_type=code&scope='.$scope.'&state=wx'.'#wechat_redirect';

            //加缓存 随机数

            header("Location:".$url);
        } else {
            $app_id = $this->app_id;
            $secret = $this->app_secret;
            $code = $_GET["code"];
            $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$app_id.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$get_token_url);
            curl_setopt($ch,CURLOPT_HEADER,0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            $res = curl_exec($ch);
            curl_close($ch);
            $json_obj = json_decode($res,true);
            if (!array_get($json_obj, 'access_token')) {
                return redirect('index?id=' . $id);
            }
            //根据openid和access_token查询用户信息
            $access_token = $json_obj['access_token'];
            $openid = $json_obj['openid'];
            $userInfo = $this->getUserInfo($openid, $access_token);

            // 判断做openid保存
            if ($id) {
                $user = DB::table('wx_user')->where('id', $id)->first();
                // 第一个扫面二维码的人openid=1，绑定这个二维码
                if ($user && $user->openId = '1') {
                    $data = [
                        'openId' => array_get($userInfo, 'openid', 1),
                        'sex' => array_get($userInfo, 'sex', 1),
                        'uionid' => array_get($userInfo, 'unionid', 1),
                        'headimgurl' => array_get($userInfo, 'headimgurl', 1)
                    ];
                    DB::table('wx_user')->where('id', $id)->update($data);
                } else {
                    return '无效的二维码';
                }
                $user = DB::table('wx_user')->find($id);
            } else {
                // 没有传id，是用户打开自己的微信查看自己的 通过openid查出id
                $user = DB::table('wx_user')->where('openid', array_get($userInfo, 'openid'))->first();
                if (!$user) {
                    return '';
                }
                $id = $user->id;
            }
        }
        if (!$code) {
            return '未知错误请重试！';
        }
        // 判断当前用户是否是打分人员
//        $record = DB::table()->where()
        // 构建模型渲染数据
//        $user = DB::table('wx_user')->find($id);
        // 打分次数
        $count = DB::table('wx_record')->where('user_id', $id)->where('created_at', '>', date('Y'))->count();
        // 分数相关
        $grades = DB::table('wx_record')->select('user_id', DB::raw('SUM(grade) as grades'))
            ->where('created_at', '>', date('Y'))
            ->groupBy('user_id')
            ->pluck('grades', 'user_id')
            ->toArray();
        // 排名
        arsort($grades);
        $rank = 0;
        $i = 0;
        foreach ($grades as $k => $v) {
            $i++;
            if ($k == $id) {
                $rank = $i;
            }
        }
        $g = array_get($grades, $id);
        $data = [
            'title' => $user->account,
            'count' => $count,
            'grade' => $g,
            'rank' => $rank,
        ];
        return view('index2', $data);
    }
    public function recodeList()
    {
        return view('list');
    }
    public function grade()
    {
        return view('grade');
    }
    public function rank()
    {
        return view('rank');
    }

    public function getAccessToken()
    {
        $app_id = $this->app_id;
        $secret = $this->app_secret;
        $get_token_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $app_id . '&secret=' . $secret;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$get_token_url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        $json_obj = json_decode($res,true);
        return $json_obj;
    }

    public function accessToken($route='auth')
    {
        if(!isset($_GET['code'])){

            $APPID = $this->app_id;

            $ran = rand(1,100); //预防缓存

            $REDIRECT_URI = 'http://jifen.zteamtech.com/' . $route . '?number='.$ran.''; //一定写上http://

            $scope='snsapi_userinfo';

            $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$APPID.'&redirect_uri='.urlencode($REDIRECT_URI).'&response_type=code&scope='.$scope.'&state=wx'.'#wechat_redirect';

            //加缓存 随机数

            header("Location:".$url);

        }else{
            $appid = $this->app_id;
            $secret = $this->app_secret;
            $code = $_GET["code"];
            $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$get_token_url);
            curl_setopt($ch,CURLOPT_HEADER,0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            $res = curl_exec($ch);
            curl_close($ch);
            $json_obj = json_decode($res,true);
            //根据openid和access_token查询用户信息
            $access_token = $json_obj['access_token'];
            $openid = $json_obj['openid'];
            return $json_obj;

        }
    }

    public function getUserInfo($open_id, $access_token)
    {
        $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$open_id.'&lang=zh_CN';

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$get_user_info_url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        //解析json
        $user_obj = json_decode($res,true);
        return $user_obj;
    }

    public function concern($code)
    {
        if (!$code) {
            $APPID = $this->app_id;

            $ran = rand(1,100); //预防缓存

            $REDIRECT_URI = 'http://jifen.zteamtech.com/index?number='.$ran.''; //一定写上http://

            $scope='snsapi_userinfo';

            $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$APPID.'&redirect_uri='.urlencode($REDIRECT_URI).'&response_type=code&scope='.$scope.'&state=wx'.'#wechat_redirect';

            //加缓存 随机数

            header("Location:".$url);
        }
    }

    public function test()
    {
        $arr = $this->returnSquarePoint(104.051956,30.547919);
        dd($arr);
        return $this->inCircle(104.052244,30.548416, $arr);
    }

    public function inCircle($lat, $lng, $arr)
    {
        if ($arr['lat'][0] > $lat && $arr['lat'][1] < $lat && $arr['lng'][0] > $lng && $arr['lng'][1] < $lng) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * 计算某个经纬度的周围某段距离的正方形的四个点
     *
     * @param radius 地球半径 平均6371km
     * @param lng float 经度
     * @param lat float 纬度
     * @param distance float 该点所在圆的半径，该圆与此正方形内切，默认值为1千米
     * @return array 正方形的四个点的经纬度坐标
     */
    public function returnSquarePoint($lng, $lat, $distance = 1, $radius = 6371)
    {
        $dlng = 2 * asin(sin($distance / (2 * $radius)) / cos(deg2rad($lat)));
        $dlng = rad2deg($dlng);

        $dlat = $distance / $radius;
        $dlat = rad2deg($dlat);
        return [
            'lng' => [
                $lat + $dlat,
                $lat - $dlat,
            ],
            'lat' => [
                $lng + $dlng,
                $lng - $dlng
            ]
        ];

//        return array(
//            'left-top' => array(
//                'lat' => $lat + $dlat,
//                'lng' => $lng - $dlng
//            ),
//            'right-top' => array(
//                'lat' => $lat + $dlat,
//                'lng' => $lng + $dlng
//            ),
//            'left-bottom' => array(
//                'lat' => $lat - $dlat,
//                'lng' => $lng - $dlng
//            ),
//            'right-bottom' => array(
//                'lat' => $lat - $dlat,
//                'lng' => $lng + $dlng
//            )
//        );
    }
}
