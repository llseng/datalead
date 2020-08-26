<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class User extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages() {
        return [
            "required" => "必填",
            "max" => "长度不可大于 :max 位",
            "min" => "长度不可小于 :min 位",
            "email" => "非有效邮箱地址",
            "confirmed" => "密码不一致"
        ];
    }
}
