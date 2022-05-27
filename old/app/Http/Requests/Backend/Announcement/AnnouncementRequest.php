<?php

namespace App\Http\Requests\Backend\Announcement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnnouncementRequest extends FormRequest {
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
                    'company_id'           => 'required',
                    'course_id'           => 'required',
                    'announcement_title'   => 'required|max:255',
                    'announcement_details' => 'required|max:10000',
                    'announcement_status'  => 'required',
                ];
            }
        case 'PUT':
        case 'PATCH':
            {
                return [
                    'company_id'           => 'required',
                    'course_id'           => 'required',
                    'announcement_title'   => 'required|max:255',
                    'announcement_details' => 'required|max:10000',
                    'announcement_status'  => 'required'
                ];
            }
        default:
            break;
        }
    }
}
