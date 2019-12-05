<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyValidateException;
use App\Model\Fav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavController extends Controller
{
    //添加或取消收藏
    public function fav(Request $request)
    {
        //表单验证
        try{
            $data = $this->validate($request,[
               'openid' => 'required',
               'fang_id' => 'required|numeric',
                //添加或取消标识
                'add' => 'required|numeric'
            ]);

        }catch (\Exception $e){
            throw new MyValidateException('数据异常',3);
        }

        //根据openid和fangid查询收藏数据表中是否存在
        //把add赋值给变量
        $add = $request['add'];
        //把add元素从data对象中删除
        unset($data['add']);
        $model = Fav::where($data)->first();
        //判断是添加操作还是取消操作
        if($add > 0){
            //添加操作
            if(!$model){
                //如果不存在则添加数据，存在则不操作
                Fav::create($data);
            }
            $msg = '添加收藏成功';
        }else{
            //取消收藏
            if($model){
                //如果数据表中存在则删除数据，否则不操作
                $model->forceDelete();
            }
            $msg = '取消收藏成功';
        }
        return ['status' => 0,'msg'=>$msg];
    }


    //是否已收藏 此房源
    public function isFav(Request $request)
    {
        //表单验证
        try{
            $data = $this->validate($request,[
                'openid' => 'required',
                'fang_id' => 'required|numeric',
            ]);

        }catch (\Exception $e){
            throw new MyValidateException('数据异常',3);
        }
        $model = Fav::where($data)->first();
        if($model){
            //已收藏，做取消操作
            return ['status' => 0,'msg'=>'取消收藏','data'=>1];
        }
        return ['status' => 0,'msg' => '添加收藏','data'=> 0];

    }

}
