<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//引入软删除类（片段trait）
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Traits\Btn;

class Base extends Model
{
    //继承 软删除trait
    use SoftDeletes,Btn;
    //指定软删除字段
    protected $dates = ['deleted_at'];
    //定义黑名单
    protected $guarded = [];

    //前缀域名
    protected static $host;

    protected static function boot()
    {
        parent::boot();
        self::$host = env('APP_URL');
    }


}
