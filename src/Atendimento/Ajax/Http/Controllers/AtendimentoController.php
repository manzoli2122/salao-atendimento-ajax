<?php

namespace Manzoli2122\Salao\Atendimento\Ajax\Http\Controllers;

use Manzoli2122\Salao\Atendimento\Ajax\Models\Atendimento;
use Manzoli2122\Salao\Atendimento\Ajax\Models\Pagamento;
use Manzoli2122\Salao\Atendimento\Ajax\Models\AtendimentoFuncionario;
use Manzoli2122\Salao\Atendimento\Ajax\Models\ProdutosVendidos;
use Manzoli2122\Salao\Atendimento\Ajax\Models\Cliente;
use  Manzoli2122\Salao\Atendimento\Ajax\Exceptions\Atendimento\ServicoValorException;
use Manzoli2122\Salao\Atendimento\Ajax\Exceptions\Atendimento\ProdutoValorException;
use Manzoli2122\Salao\Atendimento\Ajax\Exceptions\Atendimento\PagamentoValorException;
use Manzoli2122\Salao\Atendimento\Ajax\Models\Caixa;




use Manzoli2122\Salao\Cadastro\Http\Controllers\Padroes\Controller ;
use Carbon\Carbon;
use Illuminate\Http\Request;
use ChannelLog as Log;
use Session;
use Auth;





class AtendimentoController extends Controller  {

    protected $totalPage = 35;

    protected $model;
    protected $pagamento;
    protected $atendimentoFuncionario;
    protected $produtosVendidos;
    protected $name = "Atendimento";
    protected $view = "atendimentoAjax::atendimentos";
    protected $route = "atendimentos.ajax";

    protected $logCannel = 'atendimento' ;
    

    public function __construct(Pagamento $pagamento , Atendimento $atendimento, AtendimentoFuncionario $atendimentoFuncionario , 
                                 ProdutosVendidos $produtosVendidos ){

        $this->model = $atendimento;
        $this->pagamento = $pagamento;
        $this->atendimentoFuncionario = $atendimentoFuncionario;
        $this->produtosVendidos = $produtosVendidos;
        $this->middleware('auth');

        $this->middleware('permissao:atendimentos')->only([ 'index' , 'show' ]) ;       
        $this->middleware('permissao:atendimentos-soft-delete')->only([ 'destroySoft' ]);
        $this->middleware('permissao:atendimentos-restore')->only([ 'restore' ]);        
        $this->middleware('permissao:atendimentos-admin-permanete-delete')->only([ 'destroy' ]);
        $this->middleware('permissao:atendimentos-apagados')->only([ 'indexApagados' , 'showApagado' ]) ;      

    }
    




    public function create($id){
        $cliente = Cliente::find($id);      
        return view("{$this->view}.create", compact('cliente'));
    }

    


    

    public function finalizar(Request $request){
                 
        try{
            $servicos = $this->validarServicos( json_decode( $request->input('_servicos') ) );
        }
        catch( ServicoValorException $e ){
            return response()->json(['erro' => true , 'msg' => $e->getMessage() , 'data' => null ], 200);
        }


        try{
            $produtos = $this->validarProdutos( json_decode( $request->input('_produtos') ) );
        }
        catch( ProdutoValorException $e ){
            return response()->json(['erro' => true , 'msg' => $e->getMessage() , 'data' => null ], 200);
        }


        try{
            $pagamentos = $this->validarPagamentos( json_decode( $request->input('_pagamentos') ) );
        }
        catch( PagamentoValorException $e ){
            return response()->json(['erro' => true , 'msg' => $e->getMessage() , 'data' => null ], 200);
        }


        dd($servicos);
        
        


        return response()->json(['erro' => false , 'msg' => 'ok' , 'data' => null ], 200);
    }









    private function validarServicos( $servicosJson ){        
        $servicos = collect([]);        
        foreach ($servicosJson as $value) {
            $array = [
                'valor' => $value->valor_servico_total,
                'cliente_id' => $value->cliente_id,
                'funcionario_id' => $value->funcionario_id,
                'servico_id' => $value->servico_id,
                'quantidade' => $value->quantidade,
                'acrescimo' => $value->acrescimo,
                'valor_unitario' => $value->valor_servico_unitario,
                'desconto' => $value->desconto,
            ];
            $atendimentoFuncionario = new AtendimentoFuncionario($array) ;
            $atendimentoFuncionario->validate();
            $servicos->push( $atendimentoFuncionario );           
        }
        return $servicos ;
    }



    private function validarProdutos( $produtosJson ){  
        $produtos = collect([]);
        foreach ($produtosJson as $value) {
            $array = [
                'valor' => $value->valor_produto_total,
                'cliente_id' => $value->cliente_id,                
                'produto_id' => $value->produto_id,
                'quantidade' => $value->quantidade,
                'acrescimo' => $value->acrescimo,
                'valor_unitario' => $value->valor_produto_unitario,
                'desconto' => $value->desconto,
            ];            
            $produtosVendidos = new ProdutosVendidos($array) ;
            $produtosVendidos->validate();
            $produtos->push( $produtosVendidos );            
        }
        return $produtos ;
    }




    private function validarPagamentos( $pagamentosJson ){  
        $pagamentos = collect([]);
        foreach ($pagamentosJson as $value) {
            $array = [
                'valor' => $value->valor,
                'cliente_id' => $value->cliente_id,                
                'parcelas' => $value->parcelas,
                'operadora_id' => $value->operadora_id,
                'formaPagamento' => $value->formaPagamento,
                'bandeira' => $value->bandeira,
                'observacoes' => $value->observacoes,
            ];    
            $pagamento_temp = new Pagamento($array) ;
            $pagamento_temp->validate();
            $pagamentos->push( $pagamento_temp  );  
        }
        return $pagamentos ;
    }





















    public function index(){       
        $caixa = new Caixa;
        $caixa->data =  today() ; 
        return view("{$this->view}.index", compact('caixa'));
    }


    public function pesquisar(Request $request){       
        $dataForm = $request->except('_token');
        $dataString = $dataForm['data'];
        $data = Carbon::createFromFormat('Y-m-d', $dataString);
        $caixa = new Caixa;
        $caixa->data = $data ; 
        return view("{$this->view}.index", compact('caixa'));
    }


    
    public function show($id){
        $model = $this->model->find($id);
        if(!$model){
            return redirect()->route("{$this->route}.index")->withErrors(['message' => __('msg.erro_nao_encontrado', ['1' => $this->name ])]);
        } 
        return view("{$this->view}.show", compact('model'));
    }
   

    public function alterarData(Request $request , $id){
        $model = $this->model->find($id);        
        if(!$model){
            return redirect()->route("{$this->route}.index")->withErrors(['message' => __('msg.erro_nao_encontrado', ['1' => $this->name ])]);
        } 
        if( $model->created_at->isToday() or Auth::user()->hasPerfil('Admin') ){
            $data = $request->input('data');  
            $data = $data . " 12:00:00";
            $msg =  "ATENDIMENTO NÚMERO (ID) ". $model->id  .   " - ALTERAÇÃO DE DATA - DE " . $model->created_at . " PARA " . $data  . ' responsavel: ' . session('users') ;  
            foreach($model->servicos as $servico){
                $servico->created_at = $data;
                $servico->save();
            }
            foreach($model->pagamentos as $pagamento){
                $pagamento->created_at = $data;
                $pagamento->save();                
            }
            foreach($model->produtos as $produto){
                $produto->created_at = $data;
                $produto->save();            
            } 
            $model->created_at = $data;    
            $model->save();              
            Log::write( $this->logCannel , $msg  );            
        }        
        return redirect()->route('atendimentos.index');
    }


    

    //--------------------------------------------------------------------------------------------------------------------------
    // FIX-ME NÃO ESTA EM AJAX ...............
    // CASO TENHA ALGUM PAGAMENTO FIADO QUITADO EM OUTRO ATENDIMENTO NÃO EXCLUI .
    // CASO TENHA PAGAMENTOS FIADOS DE OUTROS ATENDIMENTOS QUITADOS AQUI, VOLTA A FICAR FIADO
    //--------------------------------------------------------------------------------------------------------------------------
    public function destroySoft($id) {
        $model = $this->model->find($id);        
        if($model->pagamentosFiadosQuitados()->count() != 0  ){
            return redirect()->route("{$this->route}.index");    
        }       
        foreach($model->pagamentosQuitadosAqui as $pagamentoQuitados){
            $pagamentoQuitados->restore();
            $pagamentoQuitados->atendimento_da_quitacao()->dissociate();
            $pagamentoQuitados->save();
            $model->atualizarValor();
        }              
        foreach($model->servicos as $servico){
            $servico->delete();
        }
        foreach($model->pagamentos as $pagamento){
            $pagamento->delete();
        }
        foreach($model->produtos as $produto){
            $produto->delete();
        }
        $delete = $model->delete();
        if($delete){
            $msg2 =  "DELETEs - " . $this->name . ' apagado(a) com sucesso !! ' . $model . ' responsavel: ' . session('users') ;
            Log::write( $this->logCannel , $msg2  ); 

            return redirect()->route("{$this->route}.index");
        }
        else{
            return  redirect()->route("{$this->route}.showApagados",['id' => $id])->withErrors(['errors' => 'Falha ao Deletar']);
        }
    }





    
    public function create_temp($id){
        $atendimento = new Atendimento_temp;
        $cliente = Cliente::find($id);
        $atendimento->valor = 0.0;        
        $atendimento->cliente()->associate($cliente);
        $atendimento->save();      
        return  redirect()->route("{$this->route}.adicionarItens",['id' => $atendimento->id]);
    }



    public function adicionarItens_temp($id){
        $atendimento = $this->model_temp->find($id);
        $atendimento->atualizarValor();       
        return view("{$this->view}.create", compact('atendimento'));
    }



   

    public function finalizar123($id){
        $atendimento_old = $this->model_temp->find($id);        
        $atendimento = $this->model->create( $atendimento_old->toArray() );

        //foreach($atendimento_old->servicos as $servico){
            //$array = $servico->toArray();
            //unset($array['id']);
            //$array['atendimento_id'] = $atendimento->id;
            //$array['valor'] = $servico->valor() ; 
            //$array['valor_unitario'] = $servico->servico->valor; 
            //$array['porcentagem_funcionario'] = $servico->servico->porcentagem_funcionario;  
            //$this->atendimentoFuncionario->create( $array );
        //}



        foreach(Pagamento::where('cliente_id', $atendimento->cliente->id )->where('formaPagamento', 'fiado' )->get() as $pagamentoFiado){
            $pagamentoFiado->atendimento_da_quitacao()->associate($atendimento);
            $pagamentoFiado->save();
            $pagamentoFiado->delete();
        }

        foreach($atendimento_old->pagamentos as $pagamento){
            $array = $pagamento->toArray();
            unset($array['id']);
            $array['atendimento_id'] = $atendimento->id;
            $array['valor_liquido'] = $pagamento->valor ;
            if($pagamento->formaPagamento == 'credito'){
                $array['porcentagem_cartao'] = $pagamento->operadora->porcentagem_credito ;
                $array['valor_liquido'] = $pagamento->valor *(100 - $pagamento->operadora->porcentagem_credito) / 100  ;
            }
            if($pagamento->formaPagamento == 'debito'){
                $array['porcentagem_cartao'] = $pagamento->operadora->porcentagem_debito ;
                $array['valor_liquido'] = $pagamento->valor *(100 - $pagamento->operadora->porcentagem_debito) / 100  ;
            }
            $this->pagamento->create( $array );
        }

        foreach($atendimento_old->produtos as $produto){
            $array = $produto->toArray();
            unset($array['id']);
            $array['atendimento_id'] = $atendimento->id;
            $array['valor'] = $produto->valor();
            $array['valor_unitario'] = $produto->produto->valor;
            
            $this->produtosVendidos->create( $array );
        }

        $atendimento_old->delete();
        
        $atendimento->atualizarValor();

        $msg =  "CREATEs - " . $this->name . ' Cadastrado(a) com sucesso !! ' . $atendimento . ' responsavel: ' . session('users') ;
        Log::write( $this->logCannel , $msg  );
        
        //$msg = "Atendimento criado por " . session('users');
      //  Mail::raw( $msg , function($message){            
        //    $message->from('manzoli.elisandra@gmail.com', 'Salao Espaco Vip');
          //  $message->to('manzoli2122@gmail.com')->subject('Cadastro de atendimento');
        //});
        return  redirect()->route("{$this->route}.index");
        
    }





/*
    public function cancelar($id){
        $atendimento_old = $this->model_temp->find($id); 
        $clienteId = $atendimento_old->cliente_id ;    
        $atendimento_old->delete();
        return redirect()->route("{$this->route}.index");
    }

*/



 /*

    public function adicionarServico(Request $request){
        $dataForm = $request->all();              
        $insert = $this->atendimentoFuncionario_temp->create($dataForm);        
        if($insert){
            $insert->atendimento->atualizarValor();
            return redirect()->route("{$this->route}.adicionarItens" , ['id' => $request->input('atendimento_id')])   ;
        }
        else {
            return redirect()->route("{$this->route}.adicionarItens" , ['id' => $request->input('atendimento_id')])  ;
        }
    }


    public function removerServico($id){
        $servico = $this->atendimentoFuncionario_temp->find($id); 
        $atendimento = $this->model_temp->find($servico->atendimento_id);
        $delete = $servico->delete();
        if($delete){
            $atendimento->atualizarValor();
            return redirect()->route("{$this->route}.adicionarItens" , ['id' => $atendimento->id ]);
        }
        else {
            return redirect()->route("{$this->route}.adicionarItens" , ['id' => $atendimento->id ]);
        }
    }

 */
    
/*

    public function adicionarPagamento(Request $request) {        
        $dataForm = $request->all();          
        if($dataForm['operadora_id'] ==null){
            unset($dataForm['operadora_id']);
        }
        if($dataForm['parcelas'] ==null){
            unset($dataForm['parcelas']);
        } 
        $insert = $this->pagamento_temp->create($dataForm);         
        if($insert){
            return redirect()->route("{$this->route}.adicionarItens" , ['id' => $request->input('atendimento_id')]);
        }
        else {
            return redirect()->route("{$this->route}.adicionarItens" , ['id' => $request->input('atendimento_id')]);
        }
    }


    public function removerPagamento($id){
        $pagamento = $this->pagamento_temp->find($id); 
        $atendimento = $this->model_temp->find($pagamento->atendimento_id);
        $delete = $pagamento->delete();
        if($delete){
            $atendimento->atualizarValor();
            return redirect()->route("{$this->route}.adicionarItens" , ['id' => $atendimento->id ]);
        }
        else {
            return redirect()->route("{$this->route}.adicionarItens" , ['id' => $atendimento->id ]);
        }
    }

    
*/



    /*

    public function adicionarProduto(Request $request) {
        $dataForm = $request->all();                 
        $insert = $this->produtosVendidos_temp->create($dataForm);
        if($insert){
            $insert->atendimento->atualizarValor();
            return redirect()->route("{$this->route}.adicionarItens" , ['id' => $request->input('atendimento_id')]);
        }
        else {
            return redirect()->route("{$this->route}.adicionarItens" , ['id' => $request->input('atendimento_id')]);
        }
    }


    public function removerProduto($id) {
        $produto = $this->produtosVendidos_temp->find($id); 
        $atendimento = $this->model_temp->find($produto->atendimento_id);
        $delete = $produto->delete();
        if($delete){
            $atendimento->atualizarValor();
            return redirect()->route("{$this->route}.adicionarItens" , ['id' => $atendimento->id ]);
        }
        else {
            return redirect()->route("{$this->route}.adicionarItens" , ['id' => $atendimento->id ]);
        }
    }


*/





}