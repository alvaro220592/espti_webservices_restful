<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category){
        $this->category = $category;    
    }

    public function index(Request $request){
        // return response()->json(Category::pluck('id')->all());
        return $this->category->getResults($request->name);
    }

    public function store(CategoryRequest $request){
        if ($this->category->create($request->all())) {
            return response()->json('Cadastrado com sucesso', 201);
        } else {
            return response()->json('Erro ao cadastrar', 500);
        }        
    }

    public function show($id){
        $category = $this->category->find($id);

        if(!$category)
            return response()->json('Categoria não encontrada', 401);
        
        return response()->json($category, 200);
    }

    public function update(CategoryRequest $request, $id){
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

    public function products($id){
        $category = $this->category->with('products')->find($id);
        if(!$category){
            return response()->json('Categoria não encontrada', 404);
        }

        // Para paginar, é preciso fazer essas 2 consultas: a de categoria e a de produtos
        $products = $category->products()->paginate(2);

        return response()->json([
            'categoria' => $category->name,
            'produtos' => $products
        ]);
    }
}