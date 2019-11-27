<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notice extends Base
{
    //房东的关联模型
    public function fangowner()
    {
        return $this->belongsTo(FangOwner::class,'fangowner_id');
    }

    //租客的关联模型
    public function renting()
    {
        return $this->belongsTo(Renting::class,'renting_id');
    }




}
