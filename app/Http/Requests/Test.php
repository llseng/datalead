<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Test extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "pid" => "nullable|numeric",
            "age" => "nullable|numeric|max:200",
            "date" => "nullable|regex:". static::$date_regex. "|date",
        ];
    }
}
