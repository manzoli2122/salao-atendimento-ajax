<?php

namespace Manzoli2122\Salao\Atendimento\Ajax\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use DB;

use Illuminate\Database\Eloquent\SoftDeletes;

use Manzoli2122\Pacotes\Contracts\Models\DataTableJson;

class Cliente extends Model implements DataTableJson
{


    use SoftDeletes;


    public function newInstance($attributes = [], $exists = false){
        $model = parent::newInstance($attributes, $exists);    
        $model->setTable($this->getTable());    
        return $model;
    }


    public function getTable(){
        return Config::get('atendimento.cliente_table' , 'users') ;
    }

    

    public function findModelJson($id){
        return $this->find($id);
    }

    public function findModelSoftDeleteJson($id){
        return $this->onlyTrashed()->find($id);
    }


    protected $fillable = [
        'name', 'email',  'image' , 'endereco', 'ativo' , 'apelido' , 'nascimento' , 'celular', 'telefone' , 'password'
    ];

    
   
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    protected $dates = [
        'created_at',
        'updated_at',
        'nascimento' ,
        
    ];

    public function scopeAtivo($query)
    {
        return $query->where('ativo', 1);
    }

    
    public function scopeInativo($query)
    {
        return $query->where('ativo', 0);
    }


    public function index($totalPage)
    {
        return $this->ativo()->orderBy('name', 'asc')->paginate($totalPage);        
    }



    public function atendimentos()
    {        
        return $this->hasMany('Manzoli2122\Salao\Atendimento\Ajax\Models\Atendimento', 'cliente_id')->orderBy('created_at', 'desc');
    }


    public function atendimentosLast()
    {        
        return $this->hasMany('Manzoli2122\Salao\Atendimento\Ajax\Models\Atendimento', 'cliente_id')->orderBy('created_at', 'desc')->take(6);
    }




    public function rules($id = '')
    {
        return [
            'name' => 'required|min:3|max:100',
            'email' => "required|min:3|max:100|email|unique:users,email,{$id},id",
            'image' => 'image' , 
        ];
    }



    
    
    public function getDatatable() {
        $teste =DB::table('users')
        ->where('ativo', 1)       
        ->groupBy('id' , 'name')

        ->leftJoin('pagamentos', function ($join) {
            $join->on('users.id', '=', 'pagamentos.cliente_id')
                 ->where('pagamentos.formaPagamento', '=', 'fiado')
                 ->whereNull('pagamentos.deleted_at');
        })
        
        ->select('users.id', 'users.name', DB::raw(  "  concat('R$ ', ROUND  ( SUM( pagamentos.valor) , 2 ) ) as valor" )  )
        ;
        return $teste;

        //return $this->ativo()->select(['id', 'name',   ]);           
        //Manzoli2122\Salao\Atendimento\Models\Pagamento::where("cliente_id", $linha->id )->where("formaPagamento", "fiado" )->count() > 0 
    }


    
    public function getDatatableApagados()
    {
        return $this->inativo()->select(['id', 'name',  ]);        
    }
    
}
