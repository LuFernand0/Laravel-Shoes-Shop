<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ModalAdicionar');
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dadosValidados = $request->validate([
            'nome' => 'string|required',
            'preco' => 'string|required',
            'descricao' => 'string|required',
            'quantidade' => 'numeric|required'
        ]);
        
        
        Product::create($dadosValidados);
        
        return redirect()->back();
    }
    
    private function buscarProduto(Request $request, string $parametro)
    {
        $dadosProdutos = Product::query();
        $dadosProdutos->when($request->$parametro, function($query, $valor) use ($parametro){
            $query->where( $parametro , 'like', '%'.$valor.'%');
        });
        $dadosProdutos = $dadosProdutos->get();
        return $dadosProdutos;
    }
    
    public function DetalhesProdutos(Request $request)
    {
        $dadosProdutos = $this->buscarProduto($request, 'id');
        return view('Detalhes', ['dadosProduto' => $dadosProdutos]);
    }

    public function listarProdutos(Request $request)
    {
        $dadosProdutos = $this->buscarProduto($request, 'id');
        return view('index', ['dadosProduto' => $dadosProdutos]);
    }

    public function listaProdutosPorNome(Request $request)
    {
        $dadosProdutos = $this->buscarProduto($request, 'nome');
        return view('ListaItens', ['dadosProduto' => $dadosProdutos]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $id)
    {
        return view('ModalAtualizar', ['dadosProduto' => $id]);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $id)
    {
        $dadosValidados = $request->validate([
            'nome' => 'string|required',
            'preco' => 'string|required',
            'descricao' => 'string|required',
            'quantidade' => 'numeric|required'
        ]);
        $id->fill($dadosValidados);
        $id->save();
        return Redirect::to('/');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $id)
    {
        $id->delete();
        return redirect()->back();
    }
}
