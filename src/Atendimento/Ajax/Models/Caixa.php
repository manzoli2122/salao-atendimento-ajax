<?php

namespace Manzoli2122\Salao\Atendimento\Ajax\Models;

use Manzoli2122\Salao\Atendimento\Ajax\Models\Funcionario;
use Illuminate\Database\Eloquent\Builder;
use DB;
// AQUI USA DEPENDENCIA CRUZADA
use Manzoli2122\Salao\Despesas\Models\Despesa;

class Caixa 
{
    
    public $data;

    private $valor_pic_pay = null ;
    private $valor_dinheiro = null;
    private $valor_transferencia_bancaria = null;
    private $valor_credito = null ;
    private $valor_debito  = null ;
    private $valor_cheque  = null ;
    private $valor_fiado = null ;

    private $atendimento;
    private $pagamento;
    private $despesa;
    private $atendimento_funcionario;
    private $produtos_vendidos;

    public function __construct( ){
        $this->atendimento = new Atendimento ;  
        $this->pagamento  = new Pagamento ; 
        $this->despesa  = new Despesa ; // AQUI USA DEPENDENCIA CRUZADA
        $this->atendimento_funcionario = new AtendimentoFuncionario ; 
        $this->produtos_vendidos = new ProdutosVendidos ;
    }


    public function funcionariosDoDia(){  
        $data = $this->data();
        if($data == '') return null;
        return  Funcionario::whereIn('id', function($query2) use($data) { //} use ($user){
                        $query2->distinct()->select("atendimento_funcionarios.funcionario_id");
                        $query2->from("atendimento_funcionarios");
                        $query2->whereDate('created_at', $data );         
                })->get();         
    }


    public function data(){
        return $this->data->format('Y-m-d');
    }

    public function atendimentos(){
        return $this->atendimento::whereDate('created_at', $this->data() )->get();        
    }

    // AQUI USA DEPENDENCIA CRUZADA
    public function despesas(){
        return $this->despesa::whereDate('created_at', $this->data() )->get();        
    }
    // AQUI USA DEPENDENCIA CRUZADA
    public function valor_despesas(){
        return 'R$' . number_format( $this->despesa::whereDate('created_at', $this->data() )->sum('valor'), 2 , ',' , '' ) ;          
    }



    public function atendimentosFuncionario($funcionarioId){
        return $this->atendimento_funcionario::whereDate('created_at', $this->data() )->where('funcionario_id',$funcionarioId )->get();        
    }


    public function atendimentosFuncionarioTotal($funcionarioId){
        return 'R$' . number_format( $this->atendimento_funcionario::whereDate('created_at', $this->data() )->where('funcionario_id',$funcionarioId )->sum('valor'), 2 , ',' , '' ) ;          
    }

    public function atendimentosFuncionarioLiquido($funcionarioId){
        return 'R$' . number_format( $this->atendimento_funcionario::whereDate('created_at', $this->data() )->where('funcionario_id',$funcionarioId )->sum( DB::raw('valor * porcentagem_funcionario / 100 ') ), 2 , ',' , '' ) ;          
    }


    public function valor_servicos(){
        return 'R$' . number_format( $this->atendimento_funcionario::whereDate('created_at', $this->data() )->sum('valor'), 2 , ',' , '' ) ;          
    }

    public function valor_produtos(){
        return 'R$' . number_format( $this->produtos_vendidos::whereDate('created_at', $this->data() )->sum('valor'), 2 , ',' , '' ) ;          
    }


    public function valor_atendimentos(){
        return 'R$' . number_format( $this->atendimento::whereDate('created_at',$this->data() )->sum('valor') , 2 , ',' , '' ) ;        
    }

    

    public function valor_Pagamento_dinheiro(){
        if( $this->valor_dinheiro === null){
            $this->valor_dinheiro =  $this->pagamento::whereDate('created_at',$this->data() )->where('formaPagamento', 'dinheiro' )->sum('valor');
        }
        if(!$this->valor_dinheiro > 0 ) return 0;
        return 'R$' . number_format( $this->valor_dinheiro , 2 , ',' , '' ) ;        
    }
    
    public function valor_Pagamento_pic_pay(){
        if( $this->valor_pic_pay === null){
            $this->valor_pic_pay = $this->pagamento::whereDate('created_at',$this->data() )->where('formaPagamento', 'Pic Pay' )->sum('valor') ;
        } 
        if(!$this->valor_pic_pay > 0 ) return 0;
        return 'R$' . number_format($this->valor_pic_pay , 2 , ',' , '' ) ; 
    }


    public function valor_Pagamento_transferencia_bancaria(){
        if( $this->valor_transferencia_bancaria === null){
            $this->valor_transferencia_bancaria =  $this->pagamento::whereDate('created_at',$this->data() )->where('formaPagamento', 'Transferência Bancária' )->sum('valor') ;
        }
        if(!$this->valor_transferencia_bancaria > 0 ) return 0;
        return 'R$' . number_format($this->valor_transferencia_bancaria , 2 , ',' , '' ) ;        
    }


   

    public function valor_Pagamento_credito(){
        if( $this->valor_credito === null){
            $this->valor_credito =  $this->pagamento::whereDate('created_at',$this->data() )->where('formaPagamento', 'credito' )->sum('valor') ;
        }
        if(!$this->valor_credito > 0 ) return 0;
        return 'R$' . number_format($this->valor_credito , 2 , ',' , '' ) ;        
    }


    public function valor_Pagamento_debito(){
        if( $this->valor_debito === null){
            $this->valor_debito =  $this->pagamento::whereDate('created_at',$this->data() )->where('formaPagamento', 'debito' )->sum('valor') ;
        }
        if(!$this->valor_debito > 0 ) return 0;
        return 'R$' . number_format($this->valor_debito , 2 , ',' , '' ) ;  

               
    }


    public function valor_Pagamento_cheque(){
        if( $this->valor_cheque === null){
            $this->valor_cheque =  $this->pagamento::whereDate('created_at',$this->data() )->where('formaPagamento', 'cheque' )->sum('valor') ;
        }
        if(!$this->valor_cheque > 0 ) return 0;
        return 'R$' . number_format($this->valor_cheque , 2 , ',' , '' ) ;        
    }


    
    public function valor_Pagamento_fiado(){
        if( $this->valor_fiado === null){
            $this->valor_fiado =  $this->pagamento::whereDate('created_at',$this->data() )->where('formaPagamento', 'fiado' )->sum('valor') ;
        }
        if(!$this->valor_fiado > 0 ) return 0;
        return 'R$' . number_format($this->valor_fiado , 2 , ',' , '' ) ;        
    }


    
}
