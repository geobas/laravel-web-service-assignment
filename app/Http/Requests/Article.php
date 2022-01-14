<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Article extends FormRequest
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
            'title' => 'required|string|max:100',
            'content' => 'required',
            'category' => 'sometimes|filled|in:General,World,Nature',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // 'title.required' => ':attribute is required',
            'title.string' => ':attribute must be a string',
            'title.max' => ':attribute is too big',
            'content.required' => ':attribute is required',
            'category.filled' => ':attribute should not be empty',
            'category.in' => ':attribute must be one of the following types: :values',
        ];
    }
}
