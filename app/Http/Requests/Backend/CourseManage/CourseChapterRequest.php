<?php

namespace App\Http\Requests\Backend\CourseManage;

use Illuminate\Foundation\Http\FormRequest;

class CourseChapterRequest extends FormRequest
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
            'chapter_title' => 'required|max:50',
            'chapter_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'chapter_file' => 'nullable|mimes:doc,docx,pdf',
        ];
    }
}
