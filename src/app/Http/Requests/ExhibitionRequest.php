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
            'condition'   =>['required'],
            'price'       =>['required','integer','min:0']
        ];
    }

    public function messages()
    {
        return [
             'name.required' => '商品名を入力してください',
             'description.required' => '商品説明を入力してください',
             'description.max' => '255文字以内で入力してください',
             'images.required' => '画像をアップロードしてください',
             'images.*.mimes' => '商品画像はjpegまたはpng形式でアップロードしてください',
             'category_ids.required' => '商品のカテゴリーを選択してください',
             'condition.required' => '商品の状態を選択してください',
             'price.required' => '商品価格を入力してください',
             'price.integer' => '商品価格は数値で入力してください',
             'price.min' => '商品価格は0円以上で入力してください',
             
        ];
    }
}
