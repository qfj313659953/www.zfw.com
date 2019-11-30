<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\LoginException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Renting;
use App\Exceptions\MyValidateException;
use function foo\func;

class RentingController extends Controller
{
    //上传图片
    public function upfile(Request $request)
    {
        $file = $request->file('cardimg');
        $url = $file->store('card','renting');

        return ['status' => 0,'msg'=>'图片上传成功','url'=>'/uploads/renting/' . $url];


    }

    //根据openid修改用户数据
    public function edituser(Request $request)
    {

        try{
        //表单验证
           $data = $this->validate($request,[
               'openid' => 'required',
               'truename' => 'required',
                /*'sex' => "in:'男','女'",*/
                /*'nickname' => 'required',
                'phone' => 'required',
                'sex' => 'required',
                'age' => 'required',
                'avatar' => 'required',*/
                'card' => 'required',
                'card_img' => 'required',
               /* 'is_auth' => 'required'*/
            ]);
        }catch(\Exception $e){
            //dump($e->validator->messages());
            throw new MyValidateException('数据异常,验证不通过',3);
        }

        //获取所有的数据
        $res = Renting::where('openid',$data['openid'])->first();
        $res->update($data);

        //返回数据
        return ['status' => 0,'msg' => '数据修改成功'];


    }

    //根据openid获取租客信息
    public function getrenting(Request $request)
    {
        try{
            $data = $this->validate($request,[
                'openid' => 'required'
            ]);
        }catch(\Exception $e){
            throw new MyValidateException('数据异常,验证不通过',3);
        }

        $resulte = Renting::where('openid',$data['openid'])->first();
        if(!$resulte) throw new LoginException('没有查询到信息',4);
        return ['status' => 0,'msg'=>'信息查询成功','userinfo'=>$resulte];
    }
    //删除图片
    public function delImg(Request $request)
    {
        try{
            $data = $this->validate($request,[
               'openid' => 'required',
                'cardimg' => 'required'
            ]);
        }catch(\Exception $e){
            throw new MyValidateException('数据异常',3);
        }
        $cardimg = Renting::where('openid',$data['openid'])->value('card_img');
        if(in_array($data['cardimg'],$cardimg)){
            $img = str_replace(env('APP_URL'),'.',$data['cardimg']);
            if(is_file($img)){
                unlink($img);
            }
            /*$cardimg = array_merge(array_diff($cardimg,array($data['cardimg'])));
          //  return $cardimg;
            $cardimg = array_map(function($item){
                $str = str_replace(env('APP_URL'),'',$item);
                return $str;
            },$cardimg);*/
        }

        return ['status' => 0,'msg'=>'图片删除成功'];

    }


}
