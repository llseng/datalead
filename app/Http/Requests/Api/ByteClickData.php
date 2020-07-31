<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ByteClickData extends FormRequest
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
            "cid" => "required|numeric",
            "campaign_id" => "required|numeric",
            "advertiser_id" => "required|numeric",
            "convert_id" => "nullable|numeric",
            "ctype" => "required|numeric",
            "csite" => "required|numeric",

            "request_id" => "nullable|regex:/^\w{1,40}$/",

            'imei' => "nullable|regex:/^\w{32}$/",
            'idfa' => "nullable|max:32",
            'androidid' => "nullable|regex:/^\w{32}$/",
            'oaid' => "nullable|regex:/^\w{32}$/",

            "os" => "required|numeric",
            "mac" => "required|regex:/^\w{32}$/",
            "ip" => "required|max:40",
            "ts" => "required|numeric",
        ];
    }

    public function messages() {
        return [
        ];
    }

}
