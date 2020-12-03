<?php

namespace App\Http\Requests\Api\AppClick;

use Illuminate\Foundation\Http\FormRequest;

class Byte extends FormRequest
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
            "aid" => "required|numeric",
            "cid" => "nullable|numeric",
            "gid" => "nullable|numeric",
            "account_id" => "nullable|numeric",
            "ctype" => "nullable|numeric",
            "csite" => "nullable|numeric",
            "os" => "nullable|numeric|between:0,3",
            "mac" => "nullable|regex:/^[0-9a-zA-Z]+$/|size:32",
            "ip" => "nullable|between:7,40",
            "ts" => "nullable|numeric",

            'imei' => "nullable|regex:/^[0-9a-zA-Z]+$/|size:32",
            'idfa' => "nullable|regex:/^[0-9a-zA-Z-]+$/|size:32",
            'androidid' => "nullable|regex:/^[0-9a-zA-Z]+$/|size:32",
            'oaid' => "nullable|regex:/^[0-9a-zA-Z]+$/|size:32",

            'request_id' => "nullable|between:10,64",
        ];
    }
}
