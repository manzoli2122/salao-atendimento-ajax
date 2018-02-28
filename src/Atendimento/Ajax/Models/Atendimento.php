<?php

namespace Manzoli2122\Salao\Atendimento\Ajax\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Manzoli2122\Salao\Atendimento\Models\Pagamento;
use Config;

use DB ; 

class Atendimento extends Model
{
    use SoftDeletes;
    
    public function newInstance($attributes = [], $exists = false)
    {
        $model = parent::newInstance($attributes, $exists);    
        $model->setTable($this->getTable());    
        return $model;
    }

    public function getTable()
    {
        return  Config::get('atendimento.atendimentos_table' , 'atendimentos') ; 
    }

    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    
    protected $fillable = [
        'cliente_id', 'valor', 'arquivado' , 
    ];


    public function cliente()
    {
        return $this->belongsTo('Manzoli2122\Salao\Atendimento\Models\Cliente', 'cliente_id');
    }

    public function servicos()
    {     
        if($this->deleted_at){
            return $this->hasMany('Manzoli2122\Salao\Atendimento\Models\AtendimentoFuncionario', 'atendimento_id')->onlyTrashed();
        } 
        else {
            return $this->hasMany('Manzoli2122\Salao\Atendimento\Models\AtendimentoFuncionario', 'atendimento_id');
        }   
        
    }

    public function pagamentos()
    {      
        if($this->deleted_at){
            return $this->hasMany('Manzoli2122\Salao\Atendimento\Models\Pagamento', 'atendimento_id')->onlyTrashed();
        } 
        else {
            return $this->hasMany('Manzoli2122\Salao\Atendimento\Models\Pagamento', 'atendimento_id');
        }
    }


    public function produtos()
    {       
        if($this->deleted_at){
            return $this->hasMany('Manzoli2122\Salao\Atendimento\Models\ProdutosVendidos', 'atendimento_id')->onlyTrashed();
        } 
        else {
            return $this->hasMany('Manzoli2122\Salao\Atendimento\Models\ProdutosVendidos', 'atendimento_id');
        }
        
    }







    public function pagamentosFiadosQuitados()
    {        
        //dd( $this->hasMany('Manzoli2122\Salao\Atendimento\Models\Pagamento', 'atendimento_id')->whereNotNull('deleted_at')->where('formaPagamento','fiado')->whereNotNull('atendimento_quitacao_id') );
        return $this->hasMany('Manzoli2122\Salao\Atendimento\Models\Pagamento', 'atendimento_id')->withTrashed()->whereNotNull('deleted_at')->where('formaPagamento','fiado')->whereNotNull('atendimento_quitacao_id');
        //return Pagamento::where('formaPagamento', 'fiado')->where('atendimento_id', $this->id)->onlyTrashed()->whereNotNull('atendimento_quitacao_id')->get();
    }



    public function pagamentosQuitadosAquiValor()
    {        
        return Pagamento::where('formaPagamento', 'fiado')->where('atendimento_quitacao_id', $this->id)->onlyTrashed()->get();
    }


    public function pagamentosQuitadosAqui()
    {        
        return  $this->hasMany('Manzoli2122\Salao\Atendimento\Models\Pagamento', 'atendimento_quitacao_id')->withTrashed()->where('formaPagamento','fiado')->whereNotNull('deleted_at') ;  //->onlyTrashed();
        //return  $this->hasMany('Manzoli2122\Salao\Atendimento\Models\Pagamento', 'atendimento_quitacao_id')->where('formaPagamento','fiado')->onlyTrashed();
    }




    public function valorAtrasados(){
        $valor = 0.0;
        foreach($this->pagamentosQuitadosAquiValor() as $pagamento){
            $valor = $valor + $pagamento->valor;
        }
        return  $valor;       
    }
   

    public function valorServicos(){
        $valor = 0.0;
        foreach($this->servicos as $servico){
            $valor = $valor + $servico->valor;
        }
        return  $valor;       
    }


    public function valorPagamentos(){
        $valor = 0.0;
        foreach($this->pagamentos as $pagamento){
            $valor = $valor + $pagamento->valor;
        }
        return  $valor;       
    }


    public function valorProdutos(){
        $valor = 0.0;        
        foreach($this->produtos as $produto){
            $valor =  $valor + $produto->valor ;
        }
        return  $valor;
    }



    public function atualizarValor(){
        $this->valor = $this->valorProdutos() + $this->valorServicos() ; 
        $teste =   $this->valor  + $this->valorAtrasados() - $this->valorPagamentos();
        
        if( ( $teste < 0.09) and ($teste > -0.09) ){
            $this->arquivado = true;
        }
        else{
            $this->arquivado = false;
        }        
        $this->save();
        
    }







    
    public function getDatatable()
    {
        return DB::table('atendimentos_view')->whereNull('deleted_at')
         ->select(['id', 'cliente', 'created_at' ,  'valor'   ]);        
    }
    



    public function getDatatableApagados()
    {
        return DB::table('atendimentos_view')->whereNotNull('deleted_at')
        ->select(['id', 'cliente', 'created_at' ,  'valor'   ]);
    }


    
}
