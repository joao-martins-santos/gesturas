<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class PermissaoController extends Controller
{
    
    public function index(){
    $caminhos = [
          ['url'=>'/admin','titulo'=>'Início'],
          ['url'=>'here','titulo'=>'Permissões']
          ];
    $permissao = User::orderBy('created_at', 'desc')->paginate(10);
    return view('datatables', compact('permissao', 'caminhos'));
}
}
