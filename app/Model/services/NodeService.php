<?php


namespace App\Model\services;

use Illuminate\Http\Request;
use App\Model\Node;
class NodeService
{
    //权限列表搜索业务
    public function getList(Request $request)
    {

        //获取关键字
        $kw = $request->get('kw');

        //查询分页数据
        return Node::when($kw,function($query) use ($kw) {
            $query->where('name','like',"%{$kw}%");
        })->get();


    }





}
