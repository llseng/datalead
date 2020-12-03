<?php

namespace App\Http\Requests\Api\AppClick;

use Illuminate\Foundation\Http\FormRequest;

class Txad extends FormRequest
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
            "muid" => "required|regex:/^[0-9a-zA-Z]+$/|size:32",
            "click_time" => "nullable|numeric",
            "click_id" => "nullable|between:10,64",
            "advertiser_id" => "nullable|numeric",
            "android_id" => "nullable|numeric",
            "ip" => "nullable|between:7,40",
            "campaign_id" => "nullable|numeric",
            "creative_id" => "nullable|numeric",
            "agent_id" => "nullable|numeric",
            "site_set" => "nullable|numeric",
            "oaid" => "nullable|regex:/^[0-9a-zA-Z-]+$/|between:10,64",
        ];
    }
}
