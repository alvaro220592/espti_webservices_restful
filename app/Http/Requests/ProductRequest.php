<?php

namespace App\Http\Requests;

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
        return [
            'name' => "required|min:3|max:100|unique:products,name,{$this->Segment(3)},id",
            'description' => 'required|min:10|max:180',
            'image' => 'image',
            'category_id' => 'required|exists:categories,id'
            // 'name' => 'unique:products'
        ];
    }

    public function messages(){
        return [
            // name
            'name.required' => 'Por favor, insira um nome para o produto',
            'name.min' => 'O nome deve ter no mínimo :min caracteres',
            'name.max' => 'O nome deve ter no máximo :max caracteres',
            'name.unique' => 'Já existe um produto com esse nome',

            // description
            'description.required' => 'Por favor, insira uma descrição',
            'description.min' => 'A descrição deve ter no mínimo :min caracteres',
            'description.max' => 'A descrição deve ter no máximo :max caracteres',

            // category
            'category_id.required' => 'Por favor, informe a categoria',
            'category_id.exists' => 'Categoria não encontrada'
        ];
    }
}
