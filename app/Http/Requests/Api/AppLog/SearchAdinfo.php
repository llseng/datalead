<?php

namespace App\Http\Requests\Api\AppLog;

use Illuminate\Foundation\Http\FormRequest;

class SearchAdinfo extends FormRequest
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
    static protected $datetime_regex = "/^\d{4}-[0-1]\d-[0-3]\d( [0-2]\d(:[0-5]\d){2})$/";

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "init_ids" => "required|regex:/^[\w\-\,]+$/",
            "start_datetime" => "nullable|regex:". static::$datetime_regex,
            "end_datetime" => "nullable|regex:". static::$datetime_regex,
        ];
    }

    public function messages() {
        return [
            "init_ids.regex" => "搜索条件格式错误",
            "start_datetime.regex" => "开始时间格式错误 (yyyy-mm-dd HH:ii:ss)",
            "end_datetime.regex" => "结束时间格式错误 (yyyy-mm-dd HH:ii:ss)",
        ];
    }

}
