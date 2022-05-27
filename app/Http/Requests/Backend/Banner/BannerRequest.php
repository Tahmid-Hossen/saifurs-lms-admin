<?php

namespace App\Http\Requests\Backend\Banner;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest {
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
                    'company_id'     => 'required',
                    'banner_title'   => 'required|min:3|max:255',
                    'existing_image' => 'nullable|string',
                    'banner_image'   => 'file|required_if:existing_image,null|mimes:jpg,bmp,png,gif|max:512',
                ];
            }
        case 'PUT':
        case 'PATCH':
            {
                return [
                    'company_id'     => 'required',
                    'banner_title'   => 'required|min:3|max:255',
                    'existing_image' => 'nullable|string',
                    'banner_image'   => 'file|required_if:existing_image,null|mimes:jpg,bmp,png,gif|max:512',
                ];
            }
        default:
            break;
        }
    }
}
