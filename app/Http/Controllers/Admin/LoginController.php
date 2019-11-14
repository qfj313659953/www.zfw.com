<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Message;
use Mail;

class LoginController extends Controller
{
    //显示登录界面
    public function index()
    {
        return view('admin.login.index');
    }

    //登录功能
    public function login(Request $request)
    {
        //dump($request->all());
        //表单验证
        $data = $this->validate($request,[
            'username' => 'required|min:5|max:8',
            'password' => 'required',
            'captcha'  => 'required|captcha'
        ]);
        if($data['captcha']){
            unset($data['captcha']);
        }
       $bool = auth()->attempt($data);
        //dump($bool);
        //dump(auth()->user());
       if(!$bool){
           return redirect(route('admin.login'))->withErrors(['errors'=>'请先登录']);
       }
       //给登录的用户发送邮件，包括登录时间，ip以及用户名
        $model = auth()->user();
       $ip =  $request->getClientIp();
       $user = $data['username'];
       $time = date('Y-m-d H:i:s');
       $info = ['ip' => $ip,'user'=>$user,'time' => $time];
        Mail::send('admin.mailer.login',compact('info'),function(Message $message) use ($model) {
              //主题
            $message->subject('用户成功登录通知');
            //发给谁
            $message->to($model->email,$model->truename);
        });

       return redirect(route('admin.index'));

    }



}
