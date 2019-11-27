<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyValidateException;
use App\Model\Notice;
use App\Model\Renting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoticeController extends BaseController
{
    //看房通知列表
    public function index(Request $request)
    {
        try{
            $data = $this->validate($request,[
               'openid' => 'required'
            ]);
        }catch(\Exception $e){
            throw new MyValidateException('数据异常',3);
        }
        //获取租客id
        $id = Renting::where('openid',$data['openid'])->value('id');

        $res = Notice::where('renting_id',$id)->with('fangowner:id,name,phone,address,sex')->orderBy('updated_at','desc')->paginate($this->pagesize);

        return ['status' => 0,'msg' => '看房通知列表','data'=>$res];
    }
}
