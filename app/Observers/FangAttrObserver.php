<?php

namespace App\Observers;

use App\Model\FangAttr;

class FangAttrObserver
{
    /**
     *添加数据之前被触发
     */
    public function creating(FangAttr $fangAttr)
    {
        $field_name = request()->get('field_name');
        $fangAttr->field_name = $field_name == null ? '' : $field_name;
        $icon = request()->get('icon');
        $fangAttr->icon = $icon == null ? '' : $icon;

    }


    public function updating(FangAttr $fangAttr)
    {
        $field_name = request()->get('field_name');
        $fangAttr->field_name = $field_name == null ? '' : $field_name;
        $icon = request()->get('icon');
        $fangAttr->icon = $icon == null ? '' : $icon;

    }


}
