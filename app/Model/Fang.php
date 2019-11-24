<?php

namespace App\Model;

use App\Observers\FangObserver;
use Illuminate\Database\Eloquent\Model;

class Fang extends Base
{
    //
    protected static function boot()
    {
        parent::boot(); //
        self::observe(FangObserver::class);
    }

    //关联房源于房东之间的关系
    public function fangOwner()
    {
        return $this->belongsTo(FangOwner::class,'fang_owner');
    }

    //根据属性id获取属性名
    public function getNameById($id)
    {
        if(!is_array($id)){
            return FangAttr::where('id',$id)->value('name');
        }
        $name = FangAttr::whereIn('id',$id)->pluck('name')->toArray();
        return implode(',',$name);
    }

    //获取器
    public function getPicsAttribute()
    {
        $arr = explode('#',$this->attributes['fang_pic']);
        array_shift($arr);
        return $arr;

    }

}
