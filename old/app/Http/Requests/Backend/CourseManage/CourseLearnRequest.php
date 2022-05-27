<?php

namespace App\Http\Requests\Backend\CourseManage;

use Illuminate\Foundation\Http\FormRequest;

class CourseLearnRequest extends FormRequest
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
            'learn_title' => 'required|max:500',
        ];
    }
}
