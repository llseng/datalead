<?php

namespace App\Http\Requests\Api\AppClick;

use Illuminate\Foundation\Http\FormRequest;

class KuaiShou extends FormRequest
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
            "os" => "nullable|numeric|between:0,3",
            "mac" => "nullable|regex:/^[0-9a-zA-Z:]+$/|size:17", //原值，需要大写并且用:分割
            "ip" => "nullable|between:7,40",
            "ts" => "nullable|numeric",
            
            "csite" => "nullable|numeric", //广告投放场景
    
            "imei" => "nullable|regex:/^[0-9a-zA-Z]+$/|size:32", //对15位数字的 IMEI 进行 MD5
            "idfa" => "nullable|regex:/^[0-9a-zA-Z]+$/|size:32", //iOS下的idfa计算MD5
            "androidid" => "nullable|regex:/^[0-9a-zA-Z]+$/|size:32", //对 ANDROIDID进行 MD5
            "oaid" => "nullable|regex:/^[0-9a-zA-Z-]+$/|between:10,64", //Android设备标识，原值
        ];
    }
}
