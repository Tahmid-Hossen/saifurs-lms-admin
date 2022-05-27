<?php

namespace App\Http\Requests\Backend\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $user_id = (int)$this->route('user');
        Validator::extend('valid_mobile_number', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });
        return [
            'name' => 'required|max:255',
            'username' => 'required',
            'mobile_number' => ['required', 'valid_mobile_number', 'max:255', Rule::unique('users')->ignore($user_id)->whereNull('deleted_at')],
            'password' => 'required|confirmed|min:6',
        ];
    }
}

