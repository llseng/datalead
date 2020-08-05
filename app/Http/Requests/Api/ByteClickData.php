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
            "cid" => "nullable",
            "campaign_id" => "nullable",
            "advertiser_id" => "nullable",
            "convert_id" => "nullable",
            "ctype" => "nullable",
            "csite" => "nullable",

            "request_id" => "nullable|max:100",

            'imei' => "nullable|max:32",
            'idfa' => "nullable|max:32",
            'androidid' => "nullable|max:32",
            'oaid' => "nullable|max:40",

            "os" => "nullable",
            "mac" => "nullable|max:32",
            "ip" => "nullable|max:40",
            "ts" => "nullable",
        ];
    }

    public function messages() {
        return [
        ];
    }

}
