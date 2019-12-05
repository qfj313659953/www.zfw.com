<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyValidateException;
use App\Model\Renting;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WxloginController extends Controller
{
    //小程序登录接口
    public function wxlogin(Request $request)
    {
        $code = $request->get('code');
        $appid = config('wx.appid');
        $secret = config('wx.secret');
        $url = sprintf(config('wx.url'), $appid, $secret, $code);

        //发起一个get请求
        $client = new Client(['timeout'=>5,'verify'=>false]);
        $response = $client->get($url);

        //获取请求响应值
        $data = (string)$response->getBody();
        //把结果转化为数组
        $arr = json_decode($data,true);
        $openid = $arr['openid'] ?? 'none';

        //把获取 的openid存放数据库
        if($openid != 'none'){
            $info = Renting::where('openid',$openid)->value('openid');
            if(!$info){
                //数据不存在则添加
                renting::create(['openid'=>$openid]);
            }
        }
        return ['openid' => $openid];
    }


    //小程序授权
    public function userinfo(Request $request)
    {
        //数据验证
        try{
           $data = $this->validate($request,[
                'openid' => 'required',
               'nickname' => 'required',
                'sex' => 'required|in:男,女',
                'avatar' => 'required'
            ]);

        }catch(\Exception $e){
            throw new MyValidateException('数据异常',1);
        }
       // dd($data);

      /*$user = Renting::where('openid',$data['openid'])->first();
        if($user){
            //如果存在就修改
            $user->update($data);
        }else{
            //如果不存在就添加
            $user->create($data);
        }
        return ['status'=> 0,'msg'=>'授权成功'];*/




    }


}
