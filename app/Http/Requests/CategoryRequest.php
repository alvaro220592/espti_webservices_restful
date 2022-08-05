<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            // O nome é obrigatório, mímimo 3 caracteres, máximo 100 caracteres e único na tabela citada
            /*
             Explicação do unique: para edição é preciso liberar q seja salvo com o mesmo nome.
             Por isso segue unique:<nomeTabela>,<nomeColuna>,<variavelDoId>,<colunaCorrespAoId>
             "segment" serve pra pegar os valores pela URL e o (3) é a posição do valor: /api/categories/4 */
            'name' => "required|min:3|max:100|unique:categories,name,{$this->segment(3)},id"
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Por favor, insira um nome',
            'name.min' => 'Por favor, insira no mínimo :min catacteres',
            'name.max' => 'Por favor, insira no máximo :max catacteres',
            'name.unique' => 'Já existe uma categoria cadastrada com esse nome'
        ];
    }
}
