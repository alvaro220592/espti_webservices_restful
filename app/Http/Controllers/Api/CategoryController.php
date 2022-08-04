<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category){
        $this->category = $category;    
    }

    public function index(Request $request){
        return $this->category->getResults($request->name);
    }

    public function store(Request $request){
        if ($this->category->create($request->all())) {
            return response()->json('Cadastrado com sucesso', 201);
        } else {
            return response()->json('Erro ao cadastrar', 500);
        }        
    }

    public function update(Request $request, $id){
        $category = $this->category->find($id);
        
        if(!$category)
            return response()->json('Categoria não encontrada', 400);
        
        if ($category->update($request->all())) {
            return response()->json('Editado com sucesso', 201);
        } else {
            return response()->json('Erro ao editar', 500);
        }
    }

    public function destroy($id){
        $category = $this->category->find($id);

        if(!$category)
            return response()->json('Categoria não encontrada', 404);
        
        if ($category->delete()) {
            return response()->json('Deletado com sucesso', 200);
        } else {
            return response()->json('Erro ao deletar', 500);
        }        
    }
}