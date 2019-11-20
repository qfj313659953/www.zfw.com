<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Article extends Base
{
    //给模型动态添加一个对象属性
    protected $appends = ['actionBtn'];

    public function cates()
    {
        return $this->belongsTo(Cate::class,'cid','id');
    }


    //获取器配合动态添加属性
    public function getActionBtnAttribute()
    {
        return $this->editBtn('admin.article.edit'). ' ' .$this->delBtn('admin.article.destroy');

    }
}
