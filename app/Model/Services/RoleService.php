<?php


namespace App\Model\Services;

use Illuminate\Http\Request;
use App\Model\Role;

class RoleService
{

    //权限列表搜索业务
    public function getList(Request $request,$pagesize = 1)
    {
        //获取关键字
        $kw = $request->get('kw');

        //查询分页数据
        return Role::when($kw,function($query) use ($kw) {
            $query->where('name','like',"%{$kw}%");
        })->paginate($pagesize);


    }





}
