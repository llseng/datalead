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
            "reid" => "nullable|between:7,40",
            "imei" => "nullable|". static::$alpha_num. "|between:14,32",
            "imei2" => "nullable|". static::$alpha_num. "|between:14,32",
            "meid" => "nullable|". static::$alpha_num. "|between:14,32",
            "deviceId" => "nullable|". static::$alpha_num. "|between:14,32",
            "idfa" => "nullable|regex:/^[0-9a-zA-Z-]+$/|between:10,64",
            "androidid" => "nullable|". static::$alpha_num. "|between:10,64",
            "oaid" => "nullable|regex:/^[0-9a-zA-Z-]+$/|between:10,64",
            "mac" => "nullable|regex:/^[0-9a-zA-Z:]+$/|between:10,40",

            "serial" => "nullable|between:1,32",
            "manufacturer" => "nullable|between:1,32",
            "model" => "nullable|between:1,32",
            "brand" => "nullable|between:1,32",
            "device" => "nullable|between:1,32",
            
            "ip" => "nullable|between:7,40",

            "os" => "nullable|numeric|between:0,3",
            "ts" => "nullable|numeric",
        ];
    }
}
