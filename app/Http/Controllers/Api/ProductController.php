<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private $product, $totalPage = 10;

    public function __construct(Product $product){
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json($this->product->getResults($request->all(), $this->totalPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = $this->product;
        $data = $request->all();

        // Ver se o request tem uma imagem e se essa imagem é válida
        // if($request->hasFile('image') && $request->file('image')->isValid()){
        //     $this->uploadImagem($request->name, $request->file('image'), $data['image'], 'products');
        // }
        if($request->hasFile('image') && $request->file('image')->isValid()){

            $nome = $request->file('image');

            // Definindo a extensão
            $extensao = $request->file('image')->extension();
            
            // Nome final:
            $nome_final = "$nome.$extensao";

            // Retirando o "/temp/" do nome
            $nome_final = explode('/', $nome_final)[2];
            
            // Upload (foi feito o link simbólico e configuração no app/config/filesystem.php. As instruções estão no anotacoes.txt)
            $upload = $request->file('image')->storeAs('products/', $nome_final);
            
            if(!$upload){
                return response()->json('Erro ao inserir imagem', 500);
            }
            
            $data['image'] = $nome_final;
        }

        // Carregando o produto com os dados
        $product->fill($data);

        if($product->save()){
            return response()->json('Cadastrado com sucesso', 201);
        }else{
            return response()->json('Erro ao cadastrar', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->product->find($id);
        
        return $product ? response()->json($product) : response()->json('Produto não encontrado');        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = $this->product->find($id);
        $data = $request->all();

        if(!$product){
            return response()->json('Producto não encontrado', 404);
        }

        // Ver se o request tem uma imagem e se essa imagem é válida
        if($request->hasFile('image') && $request->file('image')->isValid()){
            // Se houver imagem cadastrada, vai deletar e substituir pela nova
            if($product->image){
                // Se a imagem do banco de dados estiver também no storage, será deletada
                if(Storage::exists("products/{$product->image}")){
                    Storage::delete("products/{$product->image}");
                }
            }

            $nome = $request->file('image');

            // Definindo a extensão
            $extensao = $request->file('image')->extension();
            
            // Nome final:
            $nome_final = "$nome.$extensao";

            // Retirando o "/temp/" do nome
            $nome_final = explode('/', $nome_final)[2];
            
            // Upload (foi feito o link simbólico e configuração no app/config/filesystem.php. As instruções estão no anotacoes.txt)
            $upload = $request->file('image')->storeAs('products/', $nome_final);
            
            if(!$upload){
                return response()->json('Erro ao inserir imagem', 500);
            }
            
            $data['image'] = $nome_final;
        }

        $product->fill($data);
        
        return $product->update() ? 
            response()->json('Salvo com sucesso') : 
            response()->json('Erro ao alterar', 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->product->find($id);
        if(!$product){
            return response()->json('Producto não encontrado', 404);
        }

        // Se o produto tiver imagem armazenada, ela será apagada
        if($product->image){
            if(Storage::exists("products/{$product->image}")){
                Storage::delete("products/{$product->image}");
            }
        }
        return $product->delete() ? 
            response()->json('Excluído com sucesso') : 
            response()->json('Erro ao excluir', 500);
    }

    public function uploadImagem($model_image, $arquivo, $extensao, $dados){        
        
        // Se houver imagem cadastrada, vai deletar e substituir pela nova
        if($model_image->image){
            // Se a imagem do banco de dados estiver também no storage, será deletada
            if(Storage::exists("products/$model_image->image")){
                Storage::delete("products/$model_image->image");
            }
        }

        $nome = $arquivo;

        // Definindo a extensão
        $extensao = $extensao;
        
        // Nome final:
        $nome_final = "$nome.$extensao";
        $nome_final = explode('/', $nome_final)[2];
        
        // Upload (foi feito o link simbólico e configuração no app/config/filesystem.php. As instruções estão no anotacoes.txt)
        // $upload = $arquivo->storeAs('products/', $nome_final);
        
        // if(!$upload){
        //     return response()->json('Erro ao inserir imagem', 500);
        // }
    }
}