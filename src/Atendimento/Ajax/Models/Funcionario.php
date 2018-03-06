<?php

namespace Manzoli2122\Salao\Atendimento\Ajax\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funcionario extends Model 
{

    use SoftDeletes;

    public function newInstance($attributes = [], $exists = false){
        $model = parent::newInstance($attributes, $exists);    
        $model->setTable($this->getTable());    
        return $model;
    }

    public function getTable() {
        return  Config::get('atendimento.funcionario_table' , 'users') ;  
    }



      
    protected $fillable = [
        'name', 'email',   'apelido' , 'ativo'
    ];

    
    public static function funcionarios(){       
        return  Funcionario::where('ativo', 1)->whereIn('id', function($query2) { //} use ($user){
                        $query2->select("perfils_users.user_id");
                        $query2->from("perfils_users");
                        $query2->whereIn("perfils_users.perfil_id" , function($query3) {
                            $query3->select("perfils.id");
                            $query3->from("perfils");
                            $query3->where('nome' , 'Funcionario');
                        } );                                                            
            })->get();         
    }



    public static function funcionariosDoDia($data){  
        if($data == '') return null;
        return  Funcionario::withTrashed()->whereIn('id', function($query2) use($data) { //} use ($user){
                        $query2->distinct()->select("atendimento_funcionarios.funcionario_id");
                        $query2->from("atendimento_funcionarios");
                        $query2->whereDate('created_at', $data );         
                })->get();         
    }

    
}
