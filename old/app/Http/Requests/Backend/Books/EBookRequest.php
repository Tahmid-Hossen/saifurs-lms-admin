<?php

namespace App\Http\Requests\Backend\Books;

use Illuminate\Foundation\Http\FormRequest;

class EBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    /*
    The book name field is required.
    The page number field is required.


     */
    public function rules(): array
    {
        return [
            'ebook_name' => 'required|string|min:3|max:255',
            'edition' => 'nullable|string|min:1|max:255',
            'author' => 'required|string|min:3|max:255',
            'contributor' => 'nullable|string|min:3|max:255',
            'ebook_description' => 'nullable|string|min:3',
            'book_category' => 'required|integer',
            'language' => 'required|integer|min:1',
            'publish_date' => 'required|string|date',
            'isbn_number' => 'string|min:10|max:255',
            'type' => 'required|integer',
            'existing_image' => 'nullable|string',
            'photo' => 'file|required_if:existing_image,null|mimes:jpg,bmp,png,gif|max:512', //5MB
            'company' => 'required|integer',
            'branch' => 'required|integer',
            'existing_file' => 'nullable|string',
            'ebook_file' => 'file|required_if:existing_file,null|mimes:pdf,epub,azw3,mobi|max:5120' //100MB
        ];
    }
}
