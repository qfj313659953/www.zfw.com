<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyValidateException;
use App\Http\Resources\FangAttrResourceCollection;
use App\Http\Resources\FangResourceCollection;
use App\Model\Fang;
use App\Model\FangAttr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FangController extends BaseController
{
    //推荐房源
    public function recommend()
    {
        $data = Fang::where('is_recommend','1')->select(['id','fang_name','fang_pic'])->orderBy('updated_at','desc')->limit(5)->get();
        return ['status' => 0,'msg'=>'推荐房源获取成功','data'=>$data];
    }


    //获取租赁方式
    public function fangattr()
    {
        $data = FangAttr::select(['id','name','icon','pid','field_name'])->get()->toArray();
        $data = subtree2($data);
        $attr = array_slice($data['fang_rent_class']['son'],0,2);
        $attr2 = array_slice($data['fang_rent_type']['son'],0,2);
        $rent = array_merge($attr,$attr2);

        return ['status' => 0,'msg'=>'租期方式和租赁方式返回成功','data'=>$rent];

    }
    //租房小组
    public function group()
    {
        $where['field_name'] = 'fang_group';
        $pid = FangAttr::where($where)->value('id');
        $group = FangAttr::where('pid',$pid)->orderBy('updated_at','desc')->limit(4)->get(['id','name','icon']);

        return ['status' => 0,'msg'=>'获取小组成功','data'=>new FangAttrResourceCollection($group)];


    }

    //房源列表
    public function list(Request $request)
    {
        $data = Fang::orderBy('id','asc')->paginate($this->pagesize);
        return ['status'=>0,'msg'=>'ok','data'=>new FangResourceCollection($data)];
    }

    //获取房源详情
    public function detail(Request $request)
    {
        try{
            $data = $this->validate($request,[
               'id' => 'required'
            ]);
        }catch (\Exception $e){
            throw new MyValidateException('数据异常',3);
        }

        $data = Fang::where('id',$data['id'])->first();

    }


}
