<?php

namespace App\Http\Requests\Backend\CourseManage;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'course_category_id' => 'required',
            'course_sub_category_id' => 'required',
            'course_child_category_id' => 'required',
            'course_title' => 'required|max:50',
            'course_short_description' => 'required|max:255|string',
            // 'course_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:300|dimensions:min_width=100,min_height=100,max_width=700,max_height=500',
            'course_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'course_file' => 'nullable|max:7500|mimes:doc,docx,pdf',
            'course_video' => 'nullable|file|max:7500|mimes:mp4, avi,wmv,mpg',
            'course_video_url' => 'nullable|url'
        ];
    }
}
