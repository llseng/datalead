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
            "aid" => "required|numeric",
            "cid" => "required|numeric",
            "csite" => "required|numeric",
            "campaign_id" => "required|numeric",

            'imei' => "nullable|max:32",
            'idfa' => "nullable|max:32",
            'androidid' => "nullable|regex:/^\w{32}$/",

            "os" => "required|numeric",
            "mac" => "required|max:32",
            "ip" => "required|max:40",
            "ts" => "required",
        ];
    }
}
