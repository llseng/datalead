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
            "cid" => "nullable|numeric|max:20",
            "campaign_id" => "nullable|numeric|max:20",
            "csite" => "nullable|numeric|max:10",

            'imei' => "nullable|". static::$alpha_num. "|max:32",
            'idfa' => "nullable|". static::$alpha_num. "|max:32",
            'androidid' => "nullable|". static::$alpha_num. "|max:32",

            "os" => "nullable|numeric|max:3",
            "mac" => "nullable|". static::$alpha_num. "|max:32",
            "ip" => "nullable|max:40",
            "ts" => "nullable|numeric|max:20",
        ];
    }
}
