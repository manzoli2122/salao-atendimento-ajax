<?php

namespace Manzoli2122\Salao\Atendimento\Ajax\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use ChannelLog as Log;
use Manzoli2122\Salao\Atendimento\Ajax\Models\Cliente;

use Manzoli2122\Pacotes\Http\Controller\DataTable\Json\DataTableJsonController ;


class ClienteController extends DataTableJsonController
{

    
    protected $model;    
    protected $name = "Cliente";    
    protected $view = "atendimentoAjax::clientes";  
    protected $route = "clientes.ajax";
    protected $logCannel;


    public function __construct(Cliente $user){
        $this->model = $user; 
        $this->logCannel = 'atendimento';
        $this->middleware('permissao:clientes')->only([ 'index' , 'show' ]) ;        
        $this->middleware('permissao:clientes-cadastrar')->only([ 'create' , 'store']);
        $this->middleware('permissao:clientes-editar')->only([ 'edit' , 'update']);
        $this->middleware('permissao:clientes-soft-delete')->only([ 'destroySoft' ]);
        $this->middleware('permissao:clientes-restore')->only([ 'restore' ]);        
        $this->middleware('permissao:clientes-admin-permanete-delete')->only([ 'destroy' ]);
        $this->middleware('permissao:clientes-apagados')->only([ 'indexApagados' , 'showApagado' ]) ;
                            
    }


   
   




















    public function store(Request $request){
        $this->validate($request , $this->model->rules());
        $dataForm = $request->all();              
        $dataForm['password'] = bcrypt("senha123"); 
        if($request->hasFile('image')){
            $image = $request->file('image');           
            $nameImage = uniqid(date('YmdHis')).'.'. $image->getClientOriginalExtension();
            $upload = $image->storeAs('users', $nameImage );
            if($upload){
                $dataForm['image'] = $nameImage;
            }
            else 
                redirect()->route("{$this->route}.create")->withErrors(['errors' =>'Erro no upload'])->withInput();
        }        
        $insert = $this->model->create($dataForm);           
        if($insert){
            $msg =  "CREATEs - " . $this->name . ' Cadastrado(a) com sucesso !! ' . $insert . ' responsavel: ' . session('users') ;
            Log::write( $this->logCannel , $msg  );
            return redirect()->route("{$this->route}.show", ['id' => $insert->id])->with(['success' => 'Cadastro realizado com sucesso']);
        }
        else {
            return redirect()->route("{$this->route}.create")->withErrors(['errors' =>'Erro no Cadastro'])->withInput();
        }

    }



/*
    public function update( Request $request, $id){
        $this->validate($request , $this->model->rules($id));        
        $dataForm = $request->all();                      
        $model = $this->model->ativo()->find($id); 
        if( $request->hasFile('image')){
            $image =  $request->file('image'); 
            if(!isset($model->image))  
            $model->image = uniqid(date('YmdHis')).'.'. $image->getClientOriginalExtension(); 
            $upload = $image->storeAs('users', $model->image );
            $dataForm['image'] = $model->image;
            if(!$upload){
                return redirect()->route("{$this->route}.edit" , ['id'=> $id])->withErrors(['errors' =>'Erro no upload'])->withInput();
            }
        }       
        $update = $model->update($dataForm);                
        if($update){

            $msg =  "UPDATEs- " . $this->name . ' alterado(a) com sucesso !! ' . $update . ' responsavel: ' . session('users') ;
            Log::write( $this->logCannel , $msg  );
            return redirect()->route("{$this->route}.show", ['id'=> $id] )->with(['success' => 'Alteração realizada com sucesso']);
        }        
        else {
            return redirect()->route("{$this->route}.edit" , ['id'=> $id])->withErrors(['errors' =>'Erro no Editar'])->withInput();
        }
    }
    */


    
     
    /**
    * Processa a requisição AJAX do DataTable na página de listagem.
    * Mais informações em: http://datatables.yajrabox.com
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function getDatatable()
    {
        $models = $this->model->getDatatable();
        return Datatables::of($models)                
        ->addColumn('action', function($linha) {        
            return                 
                           '<a href="'.route("{$this->route}.atender", $linha->id).'" class="btn btn-success btn-xs btn-datatable"     title="Atender"> <i class="fa fa-money fa-lg"></i>  </a> '
                            
                            . '<button data-id="'.$linha->id.'" type="button" class="btn btn-primary btn-xs btn-datatable" btn-show    title="Visualizar" style="margin-left: 10px;"> <i class="fa fa-search"></i> </button>'
                           
                            ;
                    })
                    ->make(true);
    }
    



}
