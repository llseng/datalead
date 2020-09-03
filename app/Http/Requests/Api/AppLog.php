<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AppLog extends FormRequest
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

    static protected $date_regex = "/^\d{4}-\d{2}-\d{2}$/";
    static protected $time_regex = "/^\d{2}:\d{2}:\d{2}$/";
    static protected $datetime_regex = "/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/";

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "start_datetime" => "nullable|regex:". static::$datetime_regex. "|date",
            "end_datetime" => "nullable|regex:". static::$datetime_regex. "|date",
        ];
    }
}
