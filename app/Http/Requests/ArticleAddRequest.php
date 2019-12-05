<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleAddRequest extends FormRequest
{
    /**
     * 是否允许验证
     */
    public function authorize()
    {
        #return false;
        return true;
    }

    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'body' => 'required',
            'author' => 'required'
        ];
    }

    /**
     * 验证消息
     */
    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
            'body.required' => '内容不能为空',
            'author.required' => '作者不能为空'
        ];
    }


}
