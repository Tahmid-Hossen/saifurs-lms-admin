<?php


namespace App\Http\Requests\Backend\User;


use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
            'branch_name' => 'required',
            'manager_name' => 'required',
            'branch_phone' => 'required|regex:/[0-9]{9}/|min:8|max:13',
            'branch_mobile' => 'required|regex:/[0-9]{9}/|min:8|max:13',
            'branch_email' => 'required|email',
            'branch_address' => 'nullable|min:10|max:250',
            'address_bn' => 'nullable|min:10|max:250',
            'branch_zip_code' => 'nullable|integer|min:1000|max:99999',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
        ];
    }
}
