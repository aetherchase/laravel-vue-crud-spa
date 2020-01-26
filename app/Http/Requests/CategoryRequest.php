<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
        switch ($this->getMethod())
        {
            case 'POST':
                return [
                    'name'=>'required|min:4|max:64|unique:categories'
                ];
            case 'PUT':
                return [
                        'name'=>[
                            'required','min:4','max:64',
                            Rule::unique('categories')->ignore($this->name, 'name')
                        ]
                ];
        }
    }
}
