<?php

namespace App\Http\Requests\Backend\Course;

use Illuminate\Foundation\Http\FormRequest;

class CourseChildCategoryRequest extends FormRequest
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
            'course_child_category_title' => 'required|max:50',
            // 'course_child_category_slug' => 'alpha_dash|unique:course_child_category',
            'course_child_category_slug' => 'alpha_dash',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg:max:512',
        ];
    }
}
