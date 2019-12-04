<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyValidateException;
use App\Model\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends BaseController
{
    //用户列表
    public function index()
    {
        $data = Admin::paginate($this->pagesize);
        return ['status' => 0,'msg'=>'用户列表获取成功','data'=>$data];

    }

    //根据用户id获取详情
    public function show(Request $request)
    {
        try{
            $data = $this->validate($request,[
                'id' => 'required'
            ]);
        }catch(\Exception $e){
            throw new MyValidateException('数据异常',3);
        }

        $data = Admin::where($data)->get();
        return ['status' => 0,'msg'=>'用户信息获取成功','data'=>$data];

    }

}
