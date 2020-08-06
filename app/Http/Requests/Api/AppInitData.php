<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AppInitData extends FormRequest
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
            "imei" => "nullable|". static::$alpha_num. "|min:14|max:32",
            "imei2" => "nullable|". static::$alpha_num. "|min:14|max:32",
            "meid" => "nullable|". static::$alpha_num. "|min:14|max:32",
            "deviceId" => "nullable|". static::$alpha_num. "|min:14|max:32",
            "idfa" => "nullable|regex:/^[0-9a-zA-Z-]+$/|max:64",
            "androidid" => "nullable|". static::$alpha_num. "|max:64",
            "oaid" => "nullable|regex:/^[0-9a-zA-Z-]+$/|max:64",
            "mac" => "nullable|regex:/^[0-9a-zA-Z:]+$/|max:40",

            "serial" => "nullable|max:32",
            "manufacturer" => "nullable|max:32",
            "model" => "nullable|max:32",
            "brand" => "nullable|max:32",
            "device" => "nullable|max:32",

            "os" => "nullable|numeric|max:3",
            "ts" => "nullable|numeric|min:13|max:20",
        ];
    }
}
