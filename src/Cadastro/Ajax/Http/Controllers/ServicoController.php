<?php

namespace Manzoli2122\Salao\Cadastro\Ajax\Http\Controllers;

use Manzoli2122\Salao\Cadastro\Ajax\Models\Servico;
use Manzoli2122\Pacotes\Http\Controller\DataTable\Json\DataTableJsonController ;

class ServicoController extends DataTableJsonController
{    

    protected $model;
    protected $name = "Servico";
    protected $view = "cadastroAjax::servicos";
    protected $route = "servicosAjax";
    
    public function __construct(Servico $servico){
        $this->model = $servico;
        $this->middleware('auth');
       
        $this->middleware('permissao:servicos')->only([ 'index' , 'show'  ]) ;        
        $this->middleware('permissao:servicos-cadastrar')->only([ 'create' , 'store']);
        $this->middleware('permissao:servicos-editar')->only([ 'edit' , 'update']);
        $this->middleware('permissao:servicos-soft-delete')->only([ 'destroy' ]);

        $this->middleware('perfil:Admin')->only([ 'indexApagados' , 'showApagado' ]) ;

       /*
        $this->logCannel = 'cadastro';
        
        $this->middleware('permissao:servicos-soft-delete')->only([ 'destroySoft' ]);
        $this->middleware('permissao:servicos-restore')->only([ 'restore' ]);
        $this->middleware('permissao:servicos-admin-permanete-delete')->only([ 'destroy' ]);
        $this->middleware('permissao:servicos-apagados')->only([ 'indexApagados' , 'showApagado' ]) ;
        */

    }



    
    



}
