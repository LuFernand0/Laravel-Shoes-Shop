<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdmimController extends Controller
{
    public function listarProdutos(Request $request)
    {
        $dadosProdutos = new ProductController(); 
        $dadosProdutos = $dadosProdutos->buscarProduto($request, 'id');
        return view('index', ['dadosProduto' => $dadosProdutos]);
    }
}
