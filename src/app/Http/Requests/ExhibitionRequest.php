<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name'        =>['required'],
            'description' =>['required','string','max:255'],
            'images'      =>['required', 'array'],
            'images.*'    =>['image', 'mimes:jpeg,png'],
            'category_ids'   => ['required', 'array', 'min:1'],
            'category_ids.*' =>['required','integer','exists:categories,id'],

            'condition'   =>['required'],
            'price'       =>['required','integer','min:0']
        ];
    }
}
