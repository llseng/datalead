<?php

namespace App\Http\Requests\Api\AppClick;

use Illuminate\Foundation\Http\FormRequest;

class Huawei extends FormRequest
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
            'aid' => 'required',
            'cid' => 'required',
            'gid' => 'required',
            "oaid" => "required",
            "tracking_enabled" => "required|numeric",
            "event_type" => "required|alpha",
            "trace_time" => "required|numeric",
            "callback" => "required",
        ];
    }
}
