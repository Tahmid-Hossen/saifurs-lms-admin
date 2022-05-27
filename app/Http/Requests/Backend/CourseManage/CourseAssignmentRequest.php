<?php

namespace App\Http\Requests\Backend\CourseManage;

use Illuminate\Foundation\Http\FormRequest;

class CourseAssignmentRequest extends FormRequest
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
            // 'course_chapter_id' => 'required',
            'instructor_id' => 'required',
            'student_id' => 'required',
            'course_assignment_name' => 'required',
            'course_assignment_detail' => 'required',
            'course_assignment_url' => 'nullable|url',
            'course_assignment_document' => 'nullable|max:10000',
        ];
    }
}
