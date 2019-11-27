<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

//登录
//请求api/login
/*Route::get('login',function(){
    $username = request()->header('username');
    $password = request()->header('password');
    $signate = request()->header('sign');
    $timestamp = request()->header('timestamp');

    $userData = ['username' => $username,'password'=>$password];
    //auth登录
    $bool = auth()->guard('api')->attempt($userData);

    //异常情况统一到一个地方
    if(!$bool){//登录不成功
        //处理主动抛出一个异常
        throw new \App\Exceptions\LoginException('登录失败',1);
    }
    //登录成功后，进行签名的比较
    $token = auth()->guard('api')->user()->token;
    //签名计算
    $sign = $username . $token . $timestamp . $password;
    $sign = md5($sign);

    if($sign !== $signate){
        //验签失败
        throw new \App\Exceptions\LoginException('登录异常',2);
    }
    return ['status' => 0,'msg'=>'登录成功'];


});*/
//restful接口uri，有版本，有前缀
Route::group(['prefix'=>'v1','namespace'=>'Api'],function(){
    //实现小程序的登录
    Route::post('wxlogin','WxloginController@wxlogin');
    //小程序授权
    Route::post('userinfo','WxloginController@userinfo');
    //图片上传
    Route::post('upfile','RentingController@upfile');
    //租客信息上传
    Route::put('edituser','RentingController@edituser');
    //根据openid获取租客信息
    Route::get('getrenting','RentingController@getrenting');
    //看房通知的列表
    Route::get('notices','NoticeController@index');

});


