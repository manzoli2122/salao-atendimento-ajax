<?php

namespace Manzoli2122\Salao\Cadastro\Ajax\Models;

use Manzoli2122\Pacotes\Contracts\Models\DataTableJson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use DB;

class Operadora extends Model implements DataTableJson
{
    use SoftDeletes;


    public function newInstance($attributes = [], $exists = false){
        $model = parent::newInstance($attributes, $exists);    
        $model->setTable($this->getTable());    
        return $model;
    }


    public function getTable(){
        return  Config::get('cadastro.operadoras_table' , 'operadoras');
    }
    
    
    protected $fillable = [
        'nome', 'porcentagem_credito', 'porcentagem_credito_parcelado' , 'porcentagem_debito', 'ativo' ,
        'max_parcelas' , 'repasse_debito_dias' ,
    ];
    
    

    public function rules($id = '')
    {
        return [
            'nome' => 'required|min:3|max:100',
            'porcentagem_credito' => "required|numeric|min:0|max:100",
            'porcentagem_debito' => "required|numeric|min:0|max:100", 
            'max_parcelas' => 'required|numeric|min:1|max:3',
            'porcentagem_credito_parcelado' => "required|numeric|min:0|max:100",
            'repasse_debito_dias' => "required|numeric|min:0|max:100",            
        ];
    }



    public function findModelJson($id){
        return $this->find($id);
    }

    public function findModelSoftDeleteJson($id){
        return $this->onlyTrashed()->find($id);
    }



    public function getDatatable(){
        return $this->select(['id', 'nome', 
                        DB::raw(  " concat( porcentagem_credito , '%' ) as porcentagem_credito" )  , 
                        DB::raw(  " concat( porcentagem_credito_parcelado , '%' ) as porcentagem_credito_parcelado" )  ,
                        DB::raw(  " concat( porcentagem_debito , '%' ) as porcentagem_debito" ) , 
                        DB::raw(  " concat( max_parcelas , 'X' ) as max_parcelas" )   ]);        
    }
    

    public function getDatatableApagados(){
        return $this->onlyTrashed()->select(['id', 'nome', 
                        DB::raw(  " concat( porcentagem_credito , '%' ) as porcentagem_credito" )  , 
                        DB::raw(  " concat( porcentagem_credito_parcelado , '%' ) as porcentagem_credito_parcelado" )  ,
                        DB::raw(  " concat( porcentagem_debito , '%' ) as porcentagem_debito" ) , 
                        DB::raw(  " concat( max_parcelas , 'X' ) as max_parcelas" )  ]);        
    }
   

    //protected $dates = ['deleted_at'];
    
}
