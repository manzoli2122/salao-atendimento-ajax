<?php

namespace Manzoli2122\Salao\Cadastro\Ajax\Http\Controllers;

use Manzoli2122\Salao\Cadastro\Ajax\Models\Servico;
use Manzoli2122\Pacotes\Http\Controller\DataTable\Json\SoftDeleteJsonController ;

class ServicoSoftDeleteController extends SoftDeleteJsonController
{
  
    protected $model;
    protected $name = "Servico";
    protected $view = "cadastroAjax::servicos.apagados";
    protected $route = "servicos.ajax.apagados";



    public function __construct(Servico $servico){
        
        
        $this->model = $servico;
        $this->middleware('auth');

        $this->middleware('permissao:servicos')->only([ 'index' , 'show' ]) ; 
        $this->middleware('permissao:servicos-restore')->only([ 'restore' ]);        
        $this->middleware('permissao:servicos-soft-delete')->only([ 'destroy' ]);

        
    }   


}
