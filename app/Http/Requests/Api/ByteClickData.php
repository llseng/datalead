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

    //纯英文数字正则
    static protected $alpha_num = "regex:/^[0-9a-zA-Z]+$/";

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
            "campaign_id" => "nullable|numeric",
            "advertiser_id" => "nullable|numeric",
            "convert_id" => "nullable|numeric",
            "ctype" => "nullable|numeric",
            "csite" => "nullable|numeric",

            "request_id" => "nullable|". static::$alpha_num. "|between:20,100",

            'imei' => "nullable|". static::$alpha_num. "|between:16,32",
            'idfa' => "nullable|". static::$alpha_num. "|between:16,32",
            'androidid' => "nullable|". static::$alpha_num. "|between:16,32",
            'oaid' => "nullable|between:16,40",

            "os" => "nullable|numeric|between:0,3",
            "mac" => "nullable|". static::$alpha_num. "|between:16,32",
            "ip" => "nullable|between:7,40",
            "ts" => "nullable|numeric",
        ];
    }

    public function messages() {
        return [
        ];
    }

}
