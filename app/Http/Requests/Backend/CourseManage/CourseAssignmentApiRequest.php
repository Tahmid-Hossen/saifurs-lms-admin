<?php

namespace App\Http\Requests\Backend\CourseManage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class CourseAssignmentApiRequest extends FormRequest
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
            'course_assignment_document' => 'nullable|max:5120',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'company_id.required' => 'Company is required!',
            'course_id.required' => 'Course is required!',
            'instructor_id.required' => 'Instructor is required!',
            'student_id.required' => 'Student is required!',
            'course_assignment_name.required' => 'Course Assignment Title is required!',
            'course_assignment_detail.required' => 'Course Assignment Details is required!',
            'course_assignment_url.url' => 'Course Assignment Url provide valid url',
            'course_assignment_document.max' => 'Course Assignment document maximum 5MB'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        //if(in_array('auth:api', request()->route()->action['middleware'])):
            $errors = (new ValidationException($validator))->errors();
            $getError = array();
            foreach ($errors as $key=>$error):
                $getError[$key] = $error[0];
            endforeach;
            //dd($getError);
            throw new HttpResponseException(response()->json(['array_message' => $getError, 'status'=>false
            ], 200));
        //endif;
    }
}
