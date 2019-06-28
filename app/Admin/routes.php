<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();
Route::group([
    'prefix' => config('admin.prefix'),
    'namespace' => Admin::controllerNamespace(),
    'middleware' => ['web'],
], function (Router $router) {
    $router->get('/index', 'IndexController@index');
    $router->any('/wechat/index', 'WeChatController@index');
    $router->get('/list', 'IndexController@recodeList');
    $router->get('/grade', 'IndexController@grade');
    $router->get('/rank', 'IndexController@rank');
    $router->get('/auth', 'IndexController@getAccessToken');
    $router->get('/test', 'WeChatController@test');
});
//Route::get('/index', 'IndexController@index');
Route::group([
    'prefix' => config('admin.prefix'),
    'namespace' => Admin::controllerNamespace(),
    'middleware' => ['web', 'admin'],
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->get('/test', 'HomeController@test');
    $router->get('/account/log', 'InsuranceAccountController@log');
    $router->post('/proxy/check', 'ProxyController@check');
    $router->get('/apiuser/{id}/count', 'ApiUserController@count');
    $router->get('/apiuser/{id}/countGrid', 'ApiUserController@countGrid');
    $router->get('/insurance/{id}/count', 'InsuranceController@count');
    $router->get('/api/insurance', 'InsuranceController@ajaxGetInsurance');

    $router->resource('apiuser','ApiUserController');
    $router->resource('proxy','ProxyController');
    $router->resource('insurance','InsuranceController');
    $router->resource('account','InsuranceAccountController');
    $router->resource('interface','InterfaceController');

    $router->get('/code', 'WxUserController@code');
//    $router->get('/index', 'IndexController@index');

    $router->resource('wxuser','WxUserController');
    $router->resource('users', UserController::class);
    $router->resource('movie', MovieController::class);
    $router->resource('wxusers', WxUserController::class);
    $router->resource('wxlabels', WxLabelController::class);
    $router->resource('record', WxRecordController::class);
    $router->resource('recorder', WxRecorderController::class);
    $router->resource('wxuserlabels', WxUserLabelController::class);
    $router->resource('integral', WxIntegralController::class);
});
