<?php


namespace App\Model\Services;

use Illuminate\Http\Request;
use App\Model\Admin;
class AdminService
{

    //用户列表搜索业务
    public function getList(Request $request,int $pagesize,int $userid = 1,int $recycle = 0)
    {
        //时间
        $st = $request->get('st');
        $et = $request->get('et');

        //获取关键字
        $kw = $request->get('kw');

        //查询分页数据
        return Admin::when($st,function($query) use ($st,$et) {
           $st = date('Y-m-d 00:00:00',strtotime($st));
           $et = date('Y-m-d 00:00:00',strtotime($et));
           $query->whereBetween('created_at',[$st,$et]);
        })->when($kw,function($query) use ($kw) {
            $query->where('username','like',"%{$kw}%");
        })->when($recycle,function($query) {
            $query->onlyTrashed();
        })->where('id','!=',$userid)->orderBy('id','desc')->paginate($pagesize);


    }



}
