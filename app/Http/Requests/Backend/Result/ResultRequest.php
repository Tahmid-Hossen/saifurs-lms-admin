<?php

namespace App\Http\Requests\Backend\Result;

use Illuminate\Foundation\Http\FormRequest;

class ResultRequest extends FormRequest
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
            'company_id' => 'required',
            'course_id' => 'required',
            'batch_id' => 'required',
            'quiz_id' => 'required',
        ];
    }
}
