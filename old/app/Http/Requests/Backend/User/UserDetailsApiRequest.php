<?php
namespace App\Http\Requests\Backend\User;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserDetailsApiRequest extends FormRequest
{

    public function rules()
    {
        $user_id = (int)collect(request()->segments())->last();
        Validator::extend('valid_mobile_number', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        switch ($this->method()) {
            case 'POST':
            {
                return [
                    //'sponsor_id' => 'required',
                    'company_id' => 'required',
                    //'name' => 'required|max:255',
                    'username' => 'required|unique:users,username,'.$this->user_id.',id,deleted_at,NULL',
                    'email' => 'required|unique:users,email,'.$this->user_id.',id,deleted_at,NULL',
                    'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                    'confirm_password' => 'min:6',
                    //'national_id' => 'nullable|alpha_num',
                    'date_of_birth' => 'required|date_format:Y-m-d',
                    'gender' => 'required',
                    'mailing_address' => 'required',
                    //'police_station' => 'required',
                    'state_id' => 'required|not_in:0',
                    'city_id' => 'required|not_in:0',
                    //'country_id' => 'required|not_in:0',
                    //'mobile_phone' => ['required', 'valid_mobile_number', 'max:255', Rule::unique('user_details')->ignore($user_id)->whereNull('deleted_at')],
                    //'mobile_phone' => 'required|max:13|unique:user_details,mobile_phone,'.$user_id.',id,deleted_at,NULL'
                    'mobile_phone' => 'required|regex:/[0-9]{9}/|min:8|max:16|unique:user_details,mobile_phone,'.$user_id.',id,deleted_at,NULL',
                    'user_detail_photo' => 'file|mimes:jpeg,png,jpg,gif,svg'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    //'sponsor_id' => 'required',
                    'company_id' => 'required',
                    //'name' => 'required|max:255',
                    'username' => 'required|unique:users,username,'.$this->user_id.',id,deleted_at,NULL',
                    'email' => 'required|unique:users,email,'.$this->user_id.',id,deleted_at,NULL',
                    'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                    'confirm_password' => 'min:6',
                    //'national_id' => 'nullable|alpha_num',
                    'date_of_birth' => 'required|date_format:Y-m-d',
                    'gender' => 'required',
                    'mailing_address' => 'required',
                    //'police_station' => 'required',
                    'state_id' => 'required|not_in:0',
                    'city_id' => 'required|not_in:0',
                    'user_detail_photo' => 'file|mimes:jpeg,png,jpg,gif,svg',
                    //'country_id' => 'required|not_in:0',
                    //'mobile_phone' => ['required', 'valid_mobile_number', 'max:255', Rule::unique('user_details')->ignore($user_id)->whereNull('deleted_at')],
                    //'mobile_phone' => 'required|max:13|unique:user_details,mobile_phone,'.$user_id.',id,deleted_at,NULL'
                    'mobile_phone' => 'required|regex:/[0-9]{9}/|min:8|max:16|unique:user_details,mobile_phone,'.$user_id.',id,deleted_at,NULL',
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
            'company_id.required' => 'Company ID is required!',
            'name.required' => 'Name is required!',
            'name.max' => 'Name Maximum 255!',
            'username.required' => 'Username is required!',
            'username.unique' => 'Username already exists!',
            'email.required' => 'User Email is required!',
            'email.unique' => 'User exists with this Email!',
            'national_id.required' => 'User NID is required!',
            'national_id.alpha_num' => 'User NID is Alpha Numeric!',
            'date_of_birth.required' => 'User Date of Birth is required!',
            'date_of_birth.date_format' => 'User Date of Birth Format is Y-m-d!',
            'gender.required' => 'User Gender is required!',
            'mailing_address.required' => 'User Mailing Address is required!',
            'police_station.required' => 'User Police Station is required!',
            'state_id.required' => 'User Division is required!',
            'state_id.not_in' => 'User Division Not in Zero (0)!',
            'city_id.required' => 'User City is required!',
            'city_id.not_in' => 'User City Not in Zero (0)!',
            'country_id.required' => 'User Country is required!',
            'country_id.not_in' => 'User Country Not in Zero (0)!',
            'mobile_phone.required' => 'User Mobile Number is required!',
            'mobile_phone.unique' => 'User exists with this Mobile Number!',
            'mobile_phone.max' => 'User Mobile Number Maximum 16!',
            'mobile_phone.regex' => 'User Mobile Number format is invalid!',
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
        $errors = (new ValidationException($validator))->errors();
        $getError = array();
        foreach ($errors as $key=>$error):
            $getError[$key] = $error[0];
        endforeach;
        throw new HttpResponseException(response()->json(['backend_issues' => $getError, 'status'=>false
        ], 200));
    }
}
