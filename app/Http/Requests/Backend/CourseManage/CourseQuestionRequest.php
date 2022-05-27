<?php

namespace App\Http\Requests\Backend\CourseManage;

use Illuminate\Foundation\Http\FormRequest;

class CourseQuestionRequest extends FormRequest
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
            'quiz_id' => 'required',
            'question' => 'required',
            //'question_image' => 'nullable|image|max:512|mimes:jpg,png,jpeg,gif,svg',
        ];
    }
}
