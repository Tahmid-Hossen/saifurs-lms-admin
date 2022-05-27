<?php

namespace App\Http\Requests\Backend\Sale;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
            'company' => 'required|integer',
            'branch' => 'required|integer',
            'reference_number' => 'required|string|max:255',
            'entry_date' => 'required|date',
            'user' => 'nullable|integer',
            'name' => 'required_if:user,0|string|max:255',
            'phone' => 'required_if:user,0|string|max:255',
            'email' => 'required_if:user,0|string|max:255',
            'address' => 'required_if:user,0|string|max:255',
            'invoice.*' => 'required|array|min:1|max:100',
            'invoice.*.item' => 'required|integer|min:1',
            'invoice.*.price' => 'required|numeric|min:0',
            'invoice.*.quantity' => 'required|numeric|min:1',
            'invoice.*.total' => 'required|numeric|min:1',
            'discount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|min:3|max:255'
        ];
    }
}
