<?php

namespace Manzoli2122\Salao\Atendimento\Ajax\Http\Controllers;

use Manzoli2122\Salao\Atendimento\Ajax\Models\Atendimento;
use Manzoli2122\Salao\Atendimento\Ajax\Models\Pagamento;
use Manzoli2122\Salao\Atendimento\Ajax\Models\AtendimentoFuncionario;
use Manzoli2122\Salao\Atendimento\Ajax\Models\ProdutosVendidos;
use Manzoli2122\Salao\Atendimento\Ajax\Models\Cliente;
use Manzoli2122\Salao\Atendimento\Ajax\Models\Funcionario;
use Manzoli2122\Salao\Atendimento\Ajax\Exceptions\Atendimento\ServicoValorException;
use Manzoli2122\Salao\Atendimento\Ajax\Exceptions\Atendimento\ProdutoValorException;
use Manzoli2122\Salao\Atendimento\Ajax\Exceptions\Atendimento\PagamentoValorException;
use Manzoli2122\Salao\Atendimento\Ajax\Models\Caixa;

use Manzoli2122\Salao\Cadastro\Ajax\Models\Produto;
use Manzoli2122\Salao\Cadastro\Ajax\Models\Servico;
use Manzoli2122\Salao\Cadastro\Ajax\Models\Operadora;
use Exception;


use Manzoli2122\Salao\Cadastro\Http\Controllers\Padroes\Controller ;
use Carbon\Carbon;
use Illuminate\Http\Request;
use ChannelLog as Log;
use Session;
use Auth;
use View;




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
    protected $pagamentos_fiados;
    

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
    

    
    public function pesquisar(Request $request){       
        try {    
            $dataForm = $request->except('_token');
            $dataString = $dataForm['data'];
            $data = Carbon::createFromFormat('Y-m-d', $dataString);
            $caixa = new Caixa;
            $caixa->data = $data ; 
            
            $html = (string) View::make("{$this->view}._index", compact("caixa"));    
            $html =  preg_replace( '/\r/' , '', $html)  ; 
            $html =  preg_replace( '/\n/' , '', $html)  ;
            $html =  preg_replace( '/\t/' , '', $html)  ;  
            $html =  preg_replace( '/(>)(\s+)(<)/' , '\1\3', $html)  ; 
            return response()->json(['erro' => false , 'msg' =>'Item encontrado com sucesso.' , 'data' => $html   ], 200);  
           
        } catch(\Illuminate\Database\QueryException $e) {
            $msg = $e->errorInfo[1] == ErrosSQL::DELETE_OR_UPDATE_A_PARENT_ROW ? 
                __('msg.erro_exclusao_fk', ['1' =>  $this->name  , '2' => 'Model']):
                __('msg.erro_bd');
            return response()->json(['erro' => true , 'msg' => $msg , 'data' => null ], 200);
        }
    }


    


    public function show($id){    
        try {            
            if(!$model = $this->model->findModelJson($id) ){
                $msg = __('msg.erro_nao_encontrado', ['1' =>  $this->name ]);
                return response()->json(['erro' => true , 'msg' => $msg , 'data' => null ], 200);
            } 
            
            $html = (string) View::make("{$this->view}.show", compact("model"));              
            $html =  preg_replace( '/\r/' , '', $html)  ; 
            $html =  preg_replace( '/\n/' , '', $html)  ;
            $html =  preg_replace( '/\t/' , '', $html)  ;  
            $html =  preg_replace( '/(>)(\s+)(<)/' , '\1\3', $html)  ; 
            return response()->json(['erro' => false , 'msg' =>'Item encontrado com sucesso.' , 'data' => $html   ], 200);  
           
        } catch(\Illuminate\Database\QueryException $e) {
            $msg = $e->errorInfo[1] == ErrosSQL::DELETE_OR_UPDATE_A_PARENT_ROW ? 
                __('msg.erro_exclusao_fk', ['1' =>  $this->name  , '2' => 'Model']):
                __('msg.erro_bd');
            return response()->json(['erro' => true , 'msg' => $msg , 'data' => null ], 200);
        }
    }




   

    public function alterarData(Request $request ){
        
        try {            
            if(!$model = $this->model->findModelJson($request->input('id')) ){
                $msg = __('msg.erro_nao_encontrado', ['1' =>  $this->name ]);
                return response()->json(['erro' => true , 'msg' => $msg , 'data' => null ], 200);
            } 
            $dataPesquisar = $model->created_at ;
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

            $caixa = new Caixa;
            $caixa->data =  $dataPesquisar  ; 
            
            $html = (string) View::make("{$this->view}._index", compact("caixa"));    
            $html =  preg_replace( '/\r/' , '', $html)  ; 
            $html =  preg_replace( '/\n/' , '', $html)  ;
            $html =  preg_replace( '/\t/' , '', $html)  ;  
            $html =  preg_replace( '/(>)(\s+)(<)/' , '\1\3', $html)  ; 

            return response()->json(['erro' => false , 'msg' =>'Alterar a data.' , 'data' => $html   ], 200);  

           
        } catch(\Illuminate\Database\QueryException $e) {
            $msg = $e->errorInfo[1] == ErrosSQL::DELETE_OR_UPDATE_A_PARENT_ROW ? 
                __('msg.erro_exclusao_fk', ['1' =>  $this->name  , '2' => 'Model']):
                __('msg.erro_bd');
            return response()->json(['erro' => true , 'msg' => $msg , 'data' => null ], 200);
        }
       
    }


    

    //--------------------------------------------------------------------------------------------------------------------------
    // FIX-ME NÃO ESTA EM AJAX ...............
    // CASO TENHA ALGUM PAGAMENTO FIADO QUITADO EM OUTRO ATENDIMENTO NÃO EXCLUI .
    // CASO TENHA PAGAMENTOS FIADOS DE OUTROS ATENDIMENTOS QUITADOS AQUI, VOLTA A FICAR FIADO
    //--------------------------------------------------------------------------------------------------------------------------

    public function destroy($id)
    {
        try {
            if(!$model = $this->model->findModelJson($id) ){
                $msg = __('msg.erro_nao_encontrado', ['1' =>  $this->name ]);
                return response()->json(['erro' => true , 'msg' => $msg , 'data' => null ], 200);
            }    
            
            if($model->pagamentosFiadosQuitados()->count() != 0  ){
                return response()->json(['erro' => true , 'msg' => 'Não foi possivel excluir o atendimento, ele ja tem pagamento quitados' , 'data' => null ], 200);    
            }   

            $dataPesquisar = $model->created_at ;

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
                
                $caixa = new Caixa;
                $caixa->data =  $dataPesquisar  ; 
                
                $html = (string) View::make("{$this->view}._index", compact("caixa"));    
                $html =  preg_replace( '/\r/' , '', $html)  ; 
                $html =  preg_replace( '/\n/' , '', $html)  ;
                $html =  preg_replace( '/\t/' , '', $html)  ;  
                $html =  preg_replace( '/(>)(\s+)(<)/' , '\1\3', $html)  ; 

                return response()->json(['erro' =>false, 'msg' => 'Atendimento Excluido com sucesso' , 'data' =>  $html  ], 200);
                
            }
            else{
                return response()->json(['erro' => true , 'msg' => 'Não foi possivel excluir o atendimento' , 'data' => null ], 200);
            }

        } catch(\Illuminate\Database\QueryException $e) {
            $erro = true;
            $msg = $e->errorInfo[1] == ErrosSQL::DELETE_OR_UPDATE_A_PARENT_ROW ? 
                __('msg.erro_exclusao_fk', ['1' =>  $this->name  , '2' => 'Model']):
                __('msg.erro_bd');
        }
        return response()->json(['erro' => isset($erro), 'msg' => $msg , 'data' => null ], 200);
    }










    public function index(){       
        $caixa = new Caixa;
        $caixa->data =  today() ; 
        return view("{$this->view}.index", compact('caixa'));
    }


    
    public function create($id){
        try {                      
            $cliente = Cliente::find($id); 
            $produtos = Produto::orderBy('nome', 'asc')->get() ;  
            $clientes = Cliente::ativo()->orderBy('name', 'asc')->get();
            $funcionarios = Funcionario::funcionarios();
            $servicos = Servico::orderBy('nome', 'asc')->get() ;
            $operadoras = Operadora::orderBy('nome', 'asc')->get();            
            $html = (string) View::make("{$this->view}.create", compact('cliente' , 'produtos' , 'funcionarios' , 'servicos' , 'clientes' , 'operadoras' ));     
            return response()->json(['erro' => false , 'msg' =>'Pagina criada com sucesso.' , 'data' => $html   ], 200);  
           
        } catch(\Illuminate\Database\QueryException $e) {
            $msg = $e->errorInfo[1] == ErrosSQL::DELETE_OR_UPDATE_A_PARENT_ROW ? 
                __('msg.erro_exclusao_fk', ['1' =>  $this->name  , '2' => 'Model']):
                __('msg.erro_bd');
            return response()->json(['erro' => true , 'msg' => $msg , 'data' => null ], 200);
        }

    }

    


    

    public function finalizar(Request $request){        
        try{
            $finalizou = false ;
            $this->pagamentos_fiados = collect([]);
            $atendimento = $this->model->create( ['cliente_id' => $request->input('_cliente_id') , 'valor' => 0 ] );
           
            $divida = $atendimento->cliente->getDivida() ;
            

            $servicos = $this->validarServicos( json_decode( $request->input('_servicos') ) , $atendimento->id );              
            $produtos = $this->validarProdutos( json_decode( $request->input('_produtos') ) , $atendimento->id);                  
            $pagamentos = $this->validarPagamentos( json_decode( $request->input('_pagamentos') ) , $atendimento->id );

            
            $valor_servicos = $servicos->sum('valor') ;
            $valor_produtos = $produtos->sum('valor') ;         
            $valor_pagamentos = $pagamentos->sum('valor') ;
            
            $valor_atendimento = $valor_servicos + $valor_produtos;            
            $valor_atendimento_com_divida =  $valor_atendimento + $divida ;
        
            $atendimento->valor =  $valor_atendimento ; 
            $atendimento->save();


            if( ( ( $valor_atendimento - $valor_pagamentos )  *  ( $valor_atendimento - $valor_pagamentos ) )  <  0.05  ){
                $finalizou = true ; 
                return response()->json(['erro' => false , 'msg' => 'Atendimento Cadastrado com sucesso.' , 'data' => null ], 200);
            }
            else if( ( ( $valor_atendimento_com_divida - $valor_pagamentos )  *  ( $valor_atendimento_com_divida - $valor_pagamentos ) ) < 0.05  ){
                $this->pagamentos_fiados = $atendimento->cliente->pagamentosEmAberto ;
                foreach($this->pagamentos_fiados as $pagamentoFiado){
                    $pagamentoFiado->atendimento_da_quitacao()->associate($atendimento);
                    $pagamentoFiado->save();
                    $pagamentoFiado->delete();
                }    
                $finalizou = true ;  
                return response()->json(['erro' => false , 'msg' => 'Atendimento Cadastrado com sucesso.'   , 'data' => null ], 200);           
            }

            return response()->json(['erro' => true , 'msg' => 'Valores do Pagamento não confere com o do atendimento.' , 'data' => null ], 200);
            
        }
        catch( ServicoValorException $e ){
            return response()->json(['erro' => true , 'msg' => $e->getMessage() , 'data' => null ], 200);
        }
        catch( ProdutoValorException $e ){
            return response()->json(['erro' => true , 'msg' => $e->getMessage() , 'data' => null ], 200);
        }
        catch( PagamentoValorException $e ){
            return response()->json(['erro' => true , 'msg' => $e->getMessage() , 'data' => null ], 200);
        }
        catch( Exception $e ){
            return response()->json(['erro' => true , 'msg' => $e->getMessage() , 'data' => null ], 200);
        }
        finally {           
            if(!$finalizou){               
                foreach($this->pagamentos_fiados as $pagamentoFiado){                    
                    $pagamentoFiado->atendimento_da_quitacao()->dissociate();
                    $pagamentoFiado->save();  
                    $pagamentoFiado->restore();                  
                }
                if($atendimento){
                    $atendimento->forceDelete();     
                }                                                      
            }            
        }
        
    }




    

    private function validarServicos( $servicosJson ,  $atendimento_id ){        
        $servicos = collect([]);        
        foreach ($servicosJson as $value) {
            $array = [
                'atendimento_id' => $atendimento_id ,
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
            $atendimentoFuncionario->save();
            $servicos->push( $atendimentoFuncionario );           
        }
        return $servicos ;
    }



    private function validarProdutos( $produtosJson ,  $atendimento_id ){  
        $produtos = collect([]);
        foreach ($produtosJson as $value) {
            $array = [
                'atendimento_id' => $atendimento_id ,
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
            $produtosVendidos->save();
            $produtos->push( $produtosVendidos );            
        }


        


        return $produtos ;
    }




    private function validarPagamentos( $pagamentosJson ,  $atendimento_id ){  
        $pagamentos = collect([]);
        foreach ($pagamentosJson as $value) {
            $array = [
                'atendimento_id' => $atendimento_id ,
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
            $pagamento_temp->save();
            $pagamentos->push( $pagamento_temp  );  
        }
        return $pagamentos ;
    }







}