<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPwdReset extends FormRequest
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
            'curr_pwd' => 'required|string|min:4',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages() {
        return [
            'required' => '必填',
            'min' => '不可少于 :min 位',
            'confirmed' => '密码不一致',
        ];
    }
}
