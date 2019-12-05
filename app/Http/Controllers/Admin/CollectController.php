<?php

namespace App\Http\Controllers\Admin;

use App\Model\Collect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CollectController extends BaseController
{
    //看房确认列表
    public function index(Request $request)
    {
        echo null == false ? '相等' : '不';
        die;




        //时间
        $st = $request->get('st');
        $et = $request->get('et');
        $data = Collect::when($st,function($query) use($st,$et) {
            $st = date('Y-m-d 00:00:00',strtotime($st));
            $et = date('Y-m-d 00:00:00',strtotime($et));
            $query->whereBetween('created_at',[$st,$et]);
        })->with(['fang:id,fang_name,fang_xiaoqu,fang_addr','fangowner:id,name,sex,phone','renting:openid,truename,sex,phone'])->orderBy('created_at','desc')->paginate($this->pagesize);

        return view('admin.collect.index',compact('data'));

    }
}
