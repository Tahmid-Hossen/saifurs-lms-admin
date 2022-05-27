<?php

namespace App\Http\Requests\Backend\Books;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'book_name' => 'required|string|min:3|max:255',
            'edition' => 'nullable|string|min:1|max:255',
            'author' => 'required|string|min:3|max:255',
            'contributor' => 'nullable|string|min:3|max:255',
            'book_description' => 'nullable|string|min:3',
            'book_category' => 'required|integer',
            'language' => 'required|integer|min:1',
            'publish_date' => 'required|string|date',
            'isbn_number' => 'string|min:10|max:255',
            'page_number' => 'required|integer',
            'existing_image' => 'nullable|array',
            'existing_image.*' => 'nullable|string',
            'photo' => 'nullable|array',
            'photo.*' => 'file|required_if:existing_image,null|mimes:jpg,bmp,png,gif|max:512', //5MB
            'company' => 'required|integer',
            'branch' => 'nullable|integer',
            'book_keywords' => 'required|array|min:3',
            'book_keywords.*' => 'required|string|min:1|max:255',
            'is_sellable' => 'nullable|string',
            'book_price' => 'required_if:is_sellable,YES|nullable|numeric|min:0',
            'currency' => 'nullable|string|size:3',
            'is_ebook' => 'nullable|string',
            'type' => 'required_if:is_ebook,YES',
            'existing_file' => 'nullable|string',
            'ebook_file' => 'file|required_if:existing_file,null|mimes:txt,pdf,doc,docx,zip,mobi,azw3|max:5000', //5MB,
           'status' => 'nullable|string'
        ];
    }
}
