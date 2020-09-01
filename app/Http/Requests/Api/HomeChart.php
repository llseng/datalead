<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class HomeChart extends FormRequest
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

    static protected $date_regex = "/^\d{4}-[0-1]\d-[0-3]\d$/";

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "date_start" => "nullable|regex:". static::$date_regex,
            "date_end" => "nullable|regex:". static::$date_regex,
        ];
    }

    public function messages() {
        return [
            "regex" => "日期格式错误 (yyyy-mm-dd)"
        ];
    }
}
