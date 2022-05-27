<?php

namespace App\Http\Requests\Backend\CourseManage;

use Illuminate\Foundation\Http\FormRequest;

class CourseClassRequest extends FormRequest
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
            'class_name' => 'required|max:50',
            'class_image' => 'nullable|image|max:512|mimes:jpg,png,jpeg,gif,svg',
            'class_file' => 'nullable|max:5000|mimes:doc,docx,pdf',
            //'class_video_url' => ['nullable|regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
            'class_video_url' => 'nullable|url'
        ];
    }
}
