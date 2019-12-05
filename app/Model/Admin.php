<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Traits\Btn;

class Admin extends Authenticatable
{
    use SoftDeletes, Btn;
    //定义黑名单
    protected $guarded = [];
    //软删除
    protected $dates = ['deleted_at'];



    //添加一个加密密码的修改器
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    //添加一个模型关联关联角色表 从属于
    public function role()
    {
        return $this->belongsTo(Role::class,'role_id');
    }


}
