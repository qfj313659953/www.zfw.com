<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiuserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    //验证规则
    public function rules()
    {
        return [
            'username' => 'required',
            'password' => 'required',
            'token' => 'required',
        ];
    }

    //验证消息
    public function messages()
    {
        return [
          'token.required' => 'token值不得为空'
        ];

    }
}
