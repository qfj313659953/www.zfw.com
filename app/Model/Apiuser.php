<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apiuser extends Authenticatable
{
    use SoftDeletes;
    //定义黑名单
    protected $guarded = [];
    //软删除
    protected $dates = ['deleted_at'];

    //修改器，对密码进行加密
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
        //给数据表添加一个明文的密码
        $this->attributes['plainpass'] = $value;

    }

    //获取器

}
