<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Collect extends Base
{
    //模型关联与房东表关联
    public function fangowner()
    {
        return $this->belongsTo(FangOwner::class,'fangowner_id','id');

    }
    //模型关联与房源关联
    public function fang()
    {
        return $this->belongsTo(Fang::class,'fang_id','id');
    }
    //模型关联与租客关联
    public function renting()
    {
        return $this->belongsTo(Renting::class,'openid','openid');
    }

}
