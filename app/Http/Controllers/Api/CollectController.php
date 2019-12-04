<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyValidateException;
use App\Model\Collect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CollectController extends Controller
{
    //添加数据库
    public function index(Request $request)
    {
        //表单验证
        try{
            $data = $this->validate($request,[
                'openid' => 'required',
                'fang_id' => 'required|numeric',
                'fangowner_id' =>'required|numeric',
            ]);

        }catch (\Exception $e){
            throw new MyValidateException('数据异常',3);
        }

        $model = Collect::where($data)->first();

        $data['is_notice'] = 0;
        if(!$model){
            Collect::create($data);
            return ['status' => 0,'msg'=>'看房已确认','data' => true];
        }


    }

    //查看是否已看房
    public function isCollect(Request $request)
    {
        //表单验证
        try{
            $data = $this->validate($request,[
                'openid' => 'required',
                'fang_id' => 'required|numeric',
                'fangowner_id' =>'required|numeric',
            ]);

        }catch (\Exception $e){
            throw new MyValidateException('数据异常',3);
        }
        $model = Collect::where($data)->first();

        if(!$model){
            return ['status' => 0,'msg'=>'ok','data' => false];
        }
        return ['status' => 0,'msg'=>'此房已确认','data' => true];


    }



}
