<?php

namespace Manzoli2122\Salao\Cadastro\Ajax\Http\Controllers;

use Manzoli2122\Salao\Cadastro\Ajax\Models\Produto;
use Manzoli2122\Pacotes\Http\Controller\DataTable\Json\DataTableJsonController ;

class ProdutoController extends DataTableJsonController
{
 

    protected $model;
    protected $name = "Produto";
    protected $view = "cadastroAjax::produtos";
    protected $route = "produtosAjax";
    
    
    public function __construct(Produto $produto){
        $this->model = $produto;
        $this->middleware('auth');
        
        $this->middleware('permissao:produtos')->only([ 'index' , 'show'  ]) ;          
        $this->middleware('permissao:produtos-cadastrar')->only([ 'create' , 'store']);
        $this->middleware('permissao:produtos-editar')->only([ 'edit' , 'update']);
        $this->middleware('permissao:produtos-soft-delete')->only([ 'destroy' ]);

        $this->middleware('perfil:Admin')->only([ 'indexApagados' , 'showApagado' ]) ;


        /*
        $this->logCannel = 'cadastro';
              
        $this->middleware('permissao:produtos-cadastrar')->only([ 'create' , 'store']);

        $this->middleware('permissao:produtos-editar')->only([ 'edit' , 'update']);
        $this->middleware('permissao:produtos-soft-delete')->only([ 'destroySoft' ]);
        $this->middleware('permissao:produtos-restore')->only([ 'restore' ]);        
        $this->middleware('permissao:produtos-admin-permanete-delete')->only([ 'destroy' ]);
        $this->middleware('permissao:produtos-apagados')->only([ 'indexApagados' , 'showApagado' ]) ;
        */
    }


    
}
