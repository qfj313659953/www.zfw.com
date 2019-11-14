<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//引入软删除类（片段trait）
use Illuminate\Database\Eloquent\SoftDeletes;

class Base extends Model
{
    //继承 软删除trait
    use SoftDeletes;
    //指定软删除字段
    protected $dates = ['deleted_at'];
    //定义黑名单
    protected $guarded = [];

}
