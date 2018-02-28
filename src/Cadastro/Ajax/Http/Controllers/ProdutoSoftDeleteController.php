<?php

namespace Manzoli2122\Salao\Cadastro\Ajax\Http\Controllers;

use Manzoli2122\Salao\Cadastro\Ajax\Models\Produto;
use Manzoli2122\Pacotes\Http\Controller\DataTable\Json\SoftDeleteJsonController ;

class ProdutoSoftDeleteController extends SoftDeleteJsonController
{
  
    protected $model;
    protected $name = "Produto";
    protected $view = "cadastroAjax::produtos.apagados";
    protected $route = "produtos.ajax.apagados";



    public function __construct(Produto $produto){
        
        
        $this->model = $produto;
        $this->middleware('auth');

        $this->middleware('permissao:produtos')->only([ 'index' , 'show' ]) ; 
        $this->middleware('permissao:produtos-restore')->only([ 'restore' ]);        
        $this->middleware('permissao:produtos-soft-delete')->only([ 'destroy' ]);

        
    }   


}
