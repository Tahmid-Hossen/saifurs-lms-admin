<?php

namespace App\Http\Requests\Backend\CourseManage;

use Illuminate\Foundation\Http\FormRequest;

class CourseSyllabusRequest extends FormRequest
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
            'course_id' => 'required',
            'syllabus_title' => 'required',
            'syllabus_file' => 'nullable|max:7500|mimes:doc,docx,pdf',
        ];
    }
}
