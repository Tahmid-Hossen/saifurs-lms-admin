<?php

namespace App\Http\Requests\Backend\BranchLocation;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranch_locationRequest extends FormRequest
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
            'branch_name' => 'required',
            'status' => 'nullable'
        ];
    }
}
