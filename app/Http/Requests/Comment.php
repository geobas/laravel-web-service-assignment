<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Comment extends FormRequest
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
            'article_id' => 'required|exists:articles,id',
            'content' => 'required|string',
            'owner' => 'required|string',
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
            'article_id.required' => ':attribute is required',
            'article_id.exists' => ':attribute is unknown',
            'content.required' => ':attribute is required',
            'content.string' => ':attribute must be a string',
            'owner.required' => ':attribute is required',
            'owner.string' => ':attribute must be a string',
        ];
    }
}
