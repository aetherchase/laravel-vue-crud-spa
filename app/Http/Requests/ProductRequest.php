<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = [
            'description' => 'string|nullable|max:1024',
            'categories' => 'required|array',
            'categories.*' => 'integer|exists:categories,id' //ошибка, если категории по указанному id не существует
        ];
        switch ($this->getMethod())
        {
            case 'POST':
                return [
                    'title' => 'required|min:3|max:64|unique:products',
                    'article' => 'required|min:3|max:64|unique:products',
                    ]+$rules;
            case 'PUT':
                return [
                    'title' => [
                        'required','min:3','max:64',
                        Rule::unique('products')->ignore($this->title, 'title') //должен быть уникальным, за исключением себя же
                    ]
                ]+$rules;
        }
    }
}
