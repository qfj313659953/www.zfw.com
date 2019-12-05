<?php

namespace App\Observers;

use App\Jobs\FangOwnerJob;
use App\Model\FangOwner;


class FangOwnerObserver
{
    /**
     * 添加成功后触发
     */
    public function created(FangOwner $fangOwner)
    {
        $email = $fangOwner->email;
        $name = $fangOwner->name;
        $data = ['name'=>$name,'email'=>$email];

        //投递一个任务   属于生产者
        dispatch(new FangOwnerJob($data));

    }




}
