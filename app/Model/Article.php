<?php

namespace App\Model;

use App\Observers\ArticleObserver;
use Illuminate\Database\Eloquent\Model;


class Article extends Base
{
    //给模型动态添加一个对象属性
    protected $appends = ['actionBtn','dt'];

    protected static function boot()
    {
        parent::boot();
        self::observe(ArticleObserver::class);
    }


    public function cates()
    {
        return $this->belongsTo(Cate::class,'cid','id');
    }


    //获取器配合动态添加属性
    public function getActionBtnAttribute()
    {
        return $this->editBtn('admin.article.edit'). ' ' .$this->delBtn('admin.article.destroy');

    }
    //获取图片
    public function getPicAttribute()
    {
        if(stristr($this->attributes['pic'],'http')){
            return $this->attributes['pic'];
        }
        return self::$host . '/' . ltrim($this->attributes['pic'],'/');
    }
    //添加一个自定义属性
    public function getDtAttribute()
    {
        //把时间字段字符串转换为时间戳再重新定义
        return date('Y-m-d',strtotime($this->attributes['created_at']));

    }


}
