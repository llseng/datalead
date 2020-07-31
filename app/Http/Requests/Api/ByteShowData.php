<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ByteShowData extends FormRequest
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
            "aid" => "required|integer",
            "cid" => "required|integer",
            "csite" => "required|integer",
            "request_id" => "regex:/^\w{,40}$/",

            'imei' => "regex:/^\w{32}$/",
            'idfa' => "max:32",
            'androidid' => "regex:/^\w{32}$/",

            "os" => "required|integer",
            "mac" => "required|regex:/^\w{32}$/",
            "ip" => "required|max:40",
            "ts" => "required|integer",
        ];
    }
}
