<?php

namespace App\Http\Requests\Backend\Setting;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
                    'vendor_name' => 'required',
                    'vendor_logo' => 'required|file|mimes:jpeg,png,jpg,gif,svg',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'vendor_name' => 'required',
                    'vendor_logo' => 'file|mimes:jpeg,png,jpg,gif,svg',
                ];
            }
            default:
                break;
        }
    }
}
