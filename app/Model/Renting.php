<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Renting extends Base
{
    //给头像放一个域名前缀
    public function getAvatarAttribute()
    {
        if(strstr($this->attributes['avatar'],'http')){
            return $this->attributes['avatar'];
        }
            return self::$host . $this->attributes['avatar'];

    }
    //设置一个获取器
    public function getCardImgAttribute()
    {
        $imglist = [];
        if(strstr($this->attributes['card_img'],'#')){
            $imglist = explode('#',$this->attributes['card_img']);
            $imglist = array_map(function($item){
                return self::$host . $item;
            },$imglist);
            return $imglist;
        }
        return $imglist;

    }


}
