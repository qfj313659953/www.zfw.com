<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Base
{

    //关联模型，一个角色有多个用户，获取角色下的用户
    public function admins()
    {
        return $this->hasMany(Admin::class,'role_id','id')->select('id as adminId','username');
    }

    //关联模型，角色与权限 多对多的关系
    public function nodes()
    {
        return $this->belongsToMany(Node::class,'role_node','role_id','node_id');
    }
}
