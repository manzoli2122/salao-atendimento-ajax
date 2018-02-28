<?php

namespace Manzoli2122\Salao\Atendimento\Ajax\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use DB;

class Pagamento extends Model
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
        return  Config::get('atendimento.pagamentos_table' , 'pagamentos') ;  
    }


    
    
    protected $fillable = [
        'valor',  'atendimento_id' , 'compensado' , 'parcelas' , 'operadora_confirm', 'na_conta_at' , 'operadora_id' ,
         'porcentagem_cartao' , 'operadora_id', 'formaPagamento' , 'caiu_conta' , 'valor_liquido' , 'bandeira' ,
         'observacoes' , 'cliente_id'
    ];


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    public function atendimento()
    {
        return $this->belongsTo('Manzoli2122\Salao\Atendimento\Ajax\Models\Atendimento', 'atendimento_id');
    }


    public function atendimento_da_quitacao()
    {
        return $this->belongsTo('Manzoli2122\Salao\Atendimento\Ajax\Models\Atendimento', 'atendimento_quitacao_id');
    }


    public function operadora()
    {
        return $this->belongsTo('Manzoli2122\Salao\Cadastro\Ajax\Models\Operadora', 'operadora_id');
    }


    public function cliente()
    {
        return $this->belongsTo('Manzoli2122\Salao\Atendimento\Ajax\Models\Cliente', 'cliente_id');
    }



    public function getValor()
    {
        return "R$ " .  number_format($this->valor, 2 , ',' , '' ) ;
    }

    public function getDatatable()
    {
        return DB::table('pagamentos_view')->whereNull('deleted_at') //->where('operadora_confirm', false )
         ->select(['id', 'cliente', 'created_at' ,  'valor' , 'formaPagamento', 'bandeira' , 'nome' , 'operadora_confirm' , 'operado', 'caiu_conta', 'na_conta' ]); 
        //return $this->where('operadora_confirm', false )->select(['id',   DB::raw(  " date_format( created_at , '%d-%m-%Y' ) as created_atd" )   ,  'operadora_confirm' , 'formaPagamento' , 
                        //DB::raw(  " concat('R$', ROUND  (valor , 2 ) ) as valor" )   ]);        
    }   

    public function getDatatable1()
    {
        return $this->ativo()->select(['id', 'nome',  DB::raw(  " concat('R$', ROUND  (valor , 2 ) ) as valor" )  ,
        'observacoes' , DB::raw(  " concat( desconto_maximo , '%' ) as desconto_maximo" )  ]);        
    }
    

}
