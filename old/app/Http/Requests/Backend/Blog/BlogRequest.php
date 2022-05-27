<?php

namespace App\Http\Requests\Backend\Blog;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
                    'company_id' => 'required',
                    'user_id' => 'required',
                    'blog_title' => 'required',
                    'blog_description' => 'min:200',
                    'blog_type' => 'required',
                    'blog_publish_date' => 'required',
                    'blog_logo' => 'required|file|max:512|mimes:jpeg,png,jpg,gif,svg',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'company_id' => 'required',
                    'user_id' => 'required',
                    'blog_title' => 'required',
                    'blog_description' => 'min:200',
                    'blog_type' => 'required',
                    'blog_publish_date' => 'required',
                    'blog_logo' => 'nullable|file|max:512|mimes:jpeg,png,jpg,gif,svg',
                ];
            }
            default:
                break;
        }
    }
}
