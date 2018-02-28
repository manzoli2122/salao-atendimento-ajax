<?php

namespace Manzoli2122\Salao\Atendimento\Ajax\Http\Controllers;

use Manzoli2122\Salao\Atendimento\Ajax\Models\Cliente;
use Manzoli2122\Pacotes\Http\Controller\DataTable\Json\SoftDeleteJsonController ;

class ClienteSoftDeleteController extends SoftDeleteJsonController
{
  
    protected $model;
    protected $name = "Cliente";
    protected $view = "atendimentoAjax::clientes.apagados";
    protected $route = "clientes.ajax.apagados";



    public function __construct(Cliente $cliente){
        
        
        $this->model = $cliente;
        $this->middleware('auth');
        $this->middleware('permissao:clientes')->only([ 'index' , 'show' ]) ;        
        $this->middleware('permissao:clientes-soft-delete')->only([ 'destroy' ]);

        
        
    }   


}
