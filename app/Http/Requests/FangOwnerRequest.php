<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//引入验证
use Validator;

class FangOwnerRequest extends FormRequest
{
    /**
     * 开启验证
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
        $this->addRules();
        return [
            'name' => 'required',
            'age' => 'required|integer|min:1|max:110',
            'phone' => 'required|checkphone',
            'card' => 'required|checkcard',
            'address' => 'required',
            'pic' => 'required',
            'email' => 'required|email'
        ];
    }


    public function addRules()
    {
        Validator::extend('checkphone', function ($attribute, $value, $parameters, $validator) {

            $reg = '/^1[3456789]\d{9}$/';

            return preg_match($reg,$value);

        });
        Validator::extend('checkcard', function ($attribute, $value, $parameters, $validator) {

            $reg = '/\d{17}[\dx]$/i';
            $card = trim($value);
            $bool = strlen($card) == 18 ? true : false;

            return preg_match($reg,$value) && $bool;

        });

    }
}
