<?php

namespace App\Http\Requests\Backend\User;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'company_name' => 'required|max:255',
                    'company_email' => 'required|email',
                    //'mobile_number' => ['required', 'valid_mobile_number', 'max:255'],
                    'company_phone' => 'required|regex:/[0-9]{9}/|min:8|max:13',
                    'company_mobile' => 'required|regex:/[0-9]{9}/|min:8|max:13',
                    'country_id' => 'required',
                    'state_id' => 'required',
                    'city_id' => 'required',
                    'company_logo' => 'required|file|mimes:jpeg,png,jpg,gif,svg',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'company_name' => 'required|max:255',
                    'company_email' => 'required|email',
                    //'mobile_number' => ['required', 'valid_mobile_number', 'max:255'],
                    'company_phone' => 'required|regex:/[0-9]{9}/|min:8|max:13',
                    'company_mobile' => 'required|regex:/[0-9]{9}/|min:8|max:13',
                    'country_id' => 'required',
                    'state_id' => 'required',
                    'city_id' => 'required',
                    'company_logo' => 'file|mimes:jpeg,png,jpg,gif,svg',
                ];
            }
            default:
                break;
        }
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'company_name.required' => 'Company Name is required!',
            'company_name.max' => 'Company Name Should be Maximum of 255 Character!',
            'company_email.required' => 'Company Email Address is required. Please Provide Your Email Address For Better Communication, Thank You!',
            'company_email.email' => 'Please Provide valid Company Email Address!',
            'company_phone.required' => 'Company Phone Number is required!',
            'company_phone.regex' => 'Company Phone Number format is invalid!',
            'company_phone.min' => 'Company Phone Should be Minimum of 8 Character!',
            'company_phone.max' => 'Company Phone Should be Maximum of 13 Character!',
            'company_mobile.required' => 'Company Mobile Number is required!',
            'company_mobile.regex' => 'Company Mobile Number format is invalid!',
            'company_mobile.min' => 'Company Mobile Should be Minimum of 8 Character!',
            'company_mobile.max' => 'Company Mobile Should be Maximum of 13 Character!',
            'country_id.required' => 'Country is required!',
            'state_id.required' => 'State or Division is required!',
            'city_id.required' => 'City is required!',
            'company_logo.required' => 'Company Logo is required!',
            'company_logo.file' => 'Company Logo must be a file!',
            'company_logo.mimes' => 'Supported file format for Company Logo are jpeg,png,jpg,gif,svg!'
        ];
    }
}
