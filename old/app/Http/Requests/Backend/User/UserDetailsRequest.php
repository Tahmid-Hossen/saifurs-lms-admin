<?php
/**
 * Created by PhpStorm.
 * User: Abdul Aziz
 * Date: 12/3/2018
 * Time: 2:50 PM
 */

namespace App\Http\Requests\Backend\User;


use App\Models\Backend\User\UserDetail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserDetailsRequest extends FormRequest
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
                    'username' => 'required|unique:users,username,'.$user_id.',id,deleted_at,NULL',
                    'email' => 'required|unique:users,email,'.$user_id.',id,deleted_at,NULL',
                    'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                    'confirm_password' => 'min:6',
                    //'national_id' => 'nullable|alpha_num',
                    'date_of_birth' => 'required|date_format:Y-m-d',
                    //'gender' => 'required',
                    'mailing_address' => 'required',
                    //'police_station' => 'required',
                    'state_id' => 'required|not_in:0',
                    'city_id' => 'required|not_in:0',
                    'country_id' => 'required|not_in:0',
                    'mobile_phone' => 'required|regex:/[0-9]{9}/|min:8|max:16|unique:user_details,mobile_phone,'.$user_id.',id,deleted_at,NULL'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                $userDetails = UserDetail::find($user_id);
                return [
                    //'sponsor_id' => 'required',
                    'company_id' => 'required',
                    //'name' => 'required|max:255',
                    'username' => 'required|unique:users,username,'.$userDetails->user_id.',id,deleted_at,NULL',
                    'email' => 'required|unique:users,email,'.$userDetails->user_id.',id,deleted_at,NULL',
                    //'national_id' => 'nullable|alpha_num',
                    'date_of_birth' => 'required|date_format:Y-m-d',
                    //'gender' => 'required',
                    'mailing_address' => 'required',
                    //'police_station' => 'required',
                    'state_id' => 'required|not_in:0',
                    'city_id' => 'required|not_in:0',
                    'country_id' => 'required|not_in:0',
                    'mobile_phone' => 'required|regex:/[0-9]{9}/|min:8|max:16|unique:user_details,mobile_phone,'.$user_id.',id,deleted_at,NULL'
                ];
            }
            default:
                break;
        }
    }
}
