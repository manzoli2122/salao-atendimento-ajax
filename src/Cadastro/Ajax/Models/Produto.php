<?php

namespace Manzoli2122\Salao\Cadastro\Ajax\Models;

use Manzoli2122\Pacotes\Contracts\Models\DataTableJson;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use DB;


class Produto extends Model implements DataTableJson
{
    use SoftDeletes;


    public function newInstance($attributes = [], $exists = false){
        $model = parent::newInstance($attributes, $exists);    
        $model->setTable($this->getTable());    
        return $model;
    }


    public function getTable(){
        return  Config::get('cadastro.produtos_table' , 'produtos');
    }
     
    protected $fillable = ['nome', 'valor', 'descricao', 'ativo' , 'observacoes' , 'desconto_maximo' , 'desconto_promocional' , ];
    

    public function scopeAtivo($query){
        return $query->where('ativo', 1);
    }


    public function scopeInativo($query){
        return $query->where('ativo', 0);
    }


    public function rules($id = ''){
        return [
            'nome' => 'required|between:2,100',    
            'valor' => 'required|numeric|min:0',
            'desconto_maximo' => 'required|numeric|min:0|max:100',
            'observacoes' => 'nullable|alpha_num',                            
        ];
    }


    public function findModelJson($id){
         return $this->find($id);
    }

    
    public function findModelSoftDeleteJson($id){
        return $this->onlyTrashed()->find($id);
    }

    
    public function getDatatable(){
        return $this->select(['id', 'nome',  DB::raw(  " concat('R$', ROUND  (valor , 2 ) ) as valor" )  ,
        'observacoes' , DB::raw(  " concat( desconto_maximo , '%' ) as desconto_maximo" )  ]);        
    }
    

    public function getDatatableApagados(){
        return $this->onlyTrashed()->select(['id', 'nome',  DB::raw(  " concat('R$', ROUND  (valor , 2 ) ) as valor" )  ,
        'observacoes' , DB::raw(  " concat( desconto_maximo , '%' ) as desconto_maximo" )   ]);        
    }

}
