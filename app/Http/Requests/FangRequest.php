<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator;

class FangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fang_name' => 'required',
            'fang_xiaoqu' => 'required',
            'fang_province' => 'required|numeric|min:1',
            'fang_city' => 'required|numeric|min:1',
            'fang_region' => 'required|numeric|min:1',
             'fang_addr' => 'required',
            'fang_direction' => 'required|numeric|min:1',
            'fang_build_area' => 'required',
            'fang_using_area' => 'required',
            'fang_year' => 'required',
            'fang_rent' => 'required',
            'fang_floor' => 'required',
            'fang_shi' => 'required|numeric|min:1',
            'fang_ting' => 'required|numeric|min:1',
            'fang_wei' => 'required|numeric|min:1',
            'fang_rent_class' => 'required|numeric|min:1',
            'fang_config' => 'required',
            'fang_area' => 'required|numeric|min:1',
            'fang_rent_range' => 'required|numeric|min:1',
            'fang_rent_type' => 'required|numeric|min:1',
            'fang_owner' => 'required|numeric|min:1',
            'fang_group' => 'required|numeric|min:1',
            'fang_pic' => 'required',
            'fang_body' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'fang_name.required' => '房源名称不得为空',
            'fang_xiaoqu' => '小区名称不得为空',
            'fang_province.required' => '省份不得为空',
            'fang_province.min' => '省份不得为空',
            'fang_city.required' => '城市名不得为空',
            'fang_city.min' => '城市名不得为空',
            'fang_region.required' => '区名不得为空',
            'fang_region.min' => '区名不得为空',
            'fang_addr.required' => '详细地址不得为空',

            ];


    }
}
