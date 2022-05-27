<?php

namespace App\Http\Requests\Backend\Quiz;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\Backend\Quiz\QuizValidation;

class QuizRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        switch ( $this->method() ) {
        case 'POST':
            {
                return [
                    'quiz_type'            => ['required',new QuizValidation],
                    'quiz_topic'           => 'required',
                    'quiz_full_marks'      => 'numeric',
                    'quiz_pass_percentage' => 'numeric',
                    'quiz_url'             => 'required|url',
                    'quiz_description'     => 'nullable|max:10000',
                    'company_id'           => 'required',
                    'course_id'            => 'required',
                ];
            }
        case 'PUT':
        case 'PATCH':
            {
                return [
                    'quiz_type'            => ['required',new QuizValidation],
                    'quiz_topic'           => 'required',
                    'quiz_full_marks'      => 'numeric',
                    'quiz_pass_percentage' => 'numeric',
                    'quiz_url'             => 'required|url',
                    'quiz_description'     => 'nullable|max:10000',
                    'company_id'           => 'required',
                    'course_id'            => 'required',
                ];
            }
        default:
            break;
        }
    }
}