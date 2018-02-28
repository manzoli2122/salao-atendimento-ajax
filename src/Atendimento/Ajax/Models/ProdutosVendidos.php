<?php

namespace Manzoli2122\Salao\Atendimento\Ajax\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class ProdutosVendidos extends Model
{    
    use SoftDeletes ;

    public function newInstance($attributes = [], $exists = false)
    {
        $model = parent::newInstance($attributes, $exists);    
        $model->setTable($this->getTable());    
        return $model;
    }

    public function getTable()
    {
        return  Config::get('atendimento.atendimentos_produtos_table' , 'atendimentos_produtos') ;  
    }



    protected $fillable = [
        'quantidade', 'cliente_id', 'valor' , 'atendimento_id' , 'produto_id' , 'acrescimo' , 'desconto' , 'valor_unitario' , 
    ];
    


    
    public function cliente()
    {
        return $this->belongsTo('Manzoli2122\Salao\Atendimento\Ajax\Models\Cliente', 'cliente_id');
    }

    public function atendimento()
    {
        return $this->belongsTo('Manzoli2122\Salao\Atendimento\Ajax\Models\Atendimento', 'atendimento_id');
    }

    public function produto()
    {
        return $this->belongsTo('Manzoli2122\Salao\Cadastro\Ajax\Models\Produto', 'produto_id');
    }



}
