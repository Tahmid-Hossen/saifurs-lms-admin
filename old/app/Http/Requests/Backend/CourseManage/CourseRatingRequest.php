<?php

namespace App\Http\Requests\Backend\CourseManage;

use Illuminate\Foundation\Http\FormRequest;
// use App\Rules\Custom\CustomValidation;

class CourseRatingRequest extends FormRequest
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
            'company_id'            => 'required',
            'course_rating_stars'   => 'required|max:5|min:0',
            'course_id'             => 'required'
        ];
    }
}
