<?php
namespace App\Http\Requests\Backend\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest {
    public function rules() {
        switch ( $this->method() ) {
        case 'POST':
            {
                return [
                    'company_id'        => 'required',
                    'event_title'       => 'required|min:3|max:255',
                    'event_type'        => 'required|min:3|max:255',
                    'event_description' => 'required',
                    'event_link'        => 'required|url',
                    'existing_image'    => 'nullable|string',
                    'event_image'       => 'file|required_if:existing_image,null|max:512|mimes:jpg,bmp,png,gif|max:512',
                ];
            }
        case 'PUT':
        case 'PATCH':
            {
                return [
                    'company_id'        => 'required',
                    'event_title'       => 'required|min:3|max:255',
                    'event_type'        => 'required|min:3|max:255',
                    'event_description' => 'required',
                    'event_link'        => 'required|url',
                    'existing_image'    => 'nullable|string',
                    'event_image'       => 'file|required_if:existing_image,null|mimes:jpg,bmp,png,gif|max:512',
                ];
            }
        default:
            break;
        }
    }
}
