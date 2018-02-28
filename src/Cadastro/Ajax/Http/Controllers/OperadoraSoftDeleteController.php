<?php

namespace Manzoli2122\Salao\Cadastro\Ajax\Http\Controllers;

use Manzoli2122\Salao\Cadastro\Ajax\Models\Operadora;
use Manzoli2122\Pacotes\Http\Controller\DataTable\Json\SoftDeleteJsonController ;

class OperadoraSoftDeleteController extends SoftDeleteJsonController
{
  
    protected $model;
    protected $name = "Operadora";
    protected $view = "cadastroAjax::operadoras.apagados";
    protected $route = "operadoras.ajax.apagados";



    public function __construct(Operadora $operadora){
        
        
        $this->model = $operadora;
        $this->middleware('auth');

        $this->middleware('permissao:operadoras')->only([ 'index' , 'show' ]) ;        
        //$this->middleware('permissao:operadoras-cadastrar')->only([ 'create' , 'store']);
       // $this->middleware('permissao:operadoras-editar')->only([ 'edit' , 'update']);
        $this->middleware('permissao:operadoras-soft-delete')->only([ 'destroy' ]);

        //$this->middleware('perfil:Admin')->only([ 'indexApagados' , 'showApagado' ]) ;

        
       // $this->middleware('permissao:operadoras-soft-delete')->only([ 'destroySoft' ]);
        //$this->middleware('permissao:operadoras-restore')->only([ 'restore' ]);        
        //$this->middleware('permissao:operadoras-admin-permanete-delete')->only([ 'destroy' ]);
        //$this->middleware('permissao:operadoras-apagados')->only([ 'indexApagados' , 'showApagado']) ;
        
    }   


}
