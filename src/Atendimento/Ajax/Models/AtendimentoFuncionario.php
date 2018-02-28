<?php

namespace Manzoli2122\Salao\Atendimento\Ajax\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class AtendimentoFuncionario extends Model
{
    use SoftDeletes;

    public function newInstance($attributes = [], $exists = false)
    {
        $model = parent::newInstance($attributes, $exists);    
        $model->setTable($this->getTable());    
        return $model;
    }

    public function getTable(){
        return   Config::get('atendimento.atendimento_funcionarios_table' , 'atendimento_funcionarios') ;
    }

    
    protected $fillable = [
        'valor', 'cliente_id', 'funcionario_id' , 'atendimento_id' , 'servico_id' , 'salario_id' , 
        'quantidade' , 'acrescimo' , 'valor_unitario' , 'desconto' , 'porcentagem_funcionario',
    ];


    public function cliente(){
        return $this->belongsTo('Manzoli2122\Salao\Atendimento\Ajax\Models\Cliente', 'cliente_id');
    }


    public function funcionario(){
        return $this->belongsTo('Manzoli2122\Salao\Atendimento\Ajax\Models\Funcionario', 'funcionario_id');
    }


    public function atendimento(){
        return $this->belongsTo('Manzoli2122\Salao\Atendimento\Ajax\Models\Atendimento', 'atendimento_id');
    }


    public function servico(){
        return $this->belongsTo('Manzoli2122\Salao\Cadastro\Ajax\Models\Servico', 'servico_id');
    }



    public function AtendimentosSemSalario($funcionarioId){
        return $this->whereNull('salario_id')->where('funcionario_id' , $funcionarioId)->get();
    }


    public function salario(){
        return $this->belongsTo('Manzoli2122\Salao\Despesas\Models\Salario', 'salario_id');
    }


    public function valorFuncioanrio(){
        return  $this->valor * $this->porcentagem_funcionario / 100 ;        
    }

}
