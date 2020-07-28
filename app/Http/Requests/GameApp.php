<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameApp extends FormRequest
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
            'id' => 'required|alpha_dash|min:5|max:20',
            'name' => 'required|min:2|max:20',
            'desc' => 'required|max:100',
            'download_url' => 'required|max:300',
        ];
    }

    public function messages() {
        return [
            'id.required' => 'id 必填',
            'id.alpha_dash' => 'id 只可是英文,数字和下划线',
            'id.min' => 'id 最小长度5,最大长度20',
            'id.max' => 'id 最小长度5,最大长度20',

            'name.required' => 'name 必填',
            'name.min' => 'name 最小长度5,最大长度20',
            'name.max' => 'name 最小长度5,最大长度20',

            'desc.required' => 'desc 必填',
            'desc.max' => 'desc 最大长度100',

            'download_url.required' => 'download_url 必填',
            'download_url.max' => 'download_url 最大长度300',
        ];
    }
}
