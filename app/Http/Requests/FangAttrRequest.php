<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator;

class FangAttrRequest extends FormRequest
{
    /**
     开启验证
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 验证规则
     */
    public function rules()
    {
        $this->fieldname();
        return [
            'name' => 'required',
            'field_name' => 'fieldname'
        ];
    }

    //验证信息
    public function messages()
    {
        return [
          'field_name.fieldname' => '顶级属性必须填写字段名称'
        ];

    }

    //自定义验证器
    public function fieldname()
    {
        Validator::extend('fieldname', function ($attribute, $value, $parameters, $validator) {

            $bool = request()->get('pid') == 0 ? false : true;
            $reg = '/[a-zA-Z_]+/';

            return $bool || preg_match($reg,$value);

        });

    }


}
