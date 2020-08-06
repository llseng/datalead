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
            "aid" => "required|numeric|max:20",
            "cid" => "nullable|numeric|max:20",
            "campaign_id" => "nullable|numeric|max:20",
            "advertiser_id" => "nullable|numeric|max:20",
            "convert_id" => "nullable|numeric|max:20",
            "ctype" => "nullable|numeric|max:10",
            "csite" => "nullable|numeric|max:10",

            "request_id" => "nullable|". static::$alpha_num. "|max:100",

            'imei' => "nullable|". static::$alpha_num. "|max:32",
            'idfa' => "nullable|". static::$alpha_num. "|max:32",
            'androidid' => "nullable|". static::$alpha_num. "|max:32",
            'oaid' => "nullable|max:40",

            "os" => "nullable|numeric|max:3",
            "mac" => "nullable|". static::$alpha_num. "|max:32",
            "ip" => "nullable|max:40",
            "ts" => "nullable|numeric|max:20",
        ];
    }

    public function messages() {
        return [
        ];
    }

}
