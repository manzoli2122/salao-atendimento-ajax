<?php
use Illuminate\Support\Facades\Route;


    
Route::group(['prefix' => 'atendimento/ajax', 'middleware' => 'auth' ], function(){


    //--------------------------------------------------------------------------------------------------------------------------
    //  CLIENTES
    //--------------------------------------------------------------------------------------------------------------------------
    Route::get('clientes/apagados/{id}', 'ClienteController@showApagado')->name('clientes.showapagado');        
    Route::get('clientes/apagados', 'ClienteController@indexApagados')->name('clientes.apagados');
    Route::delete('clientes/apagados/{id}', 'ClienteController@destroySoft')->name('clientes.destroySoft');        
    //Route::post('clientes/getDatatable/apagados', 'ClienteController@getDatatableApagados')->name('clientes.getDatatable.apagados');        
    
    //Route::post('clientes/getDatatable', 'ClienteController@getDatatable')->name('clientes.getDatatable');             
    //Route::get('clientes/restore/{id}', 'ClienteController@restore')->name('clientes.restore');
    //Route::resource('clientes', 'ClienteController');
    
    Route::post('clientes/getDatatable', 'ClienteController@getDatatable')->name('clientes.ajax.getDatatable');
    Route::resource('clientes', 'ClienteController' , ['names' => [
        'create' => 'clientes.ajax.create' ,
        'index' => 'clientes.ajax.index' ,
        'edit' => 'clientes.ajax.edit' ,
        'update' => 'clientes.ajax.update' ,
        'store' => 'clientes.ajax.store' ,
        'show' => 'clientes.ajax.show' ,
        'destroy' => 'clientes.ajax.destroy' ,
    ]]); 
    










    Route::get('clientes/{id}/atendendo', 'AtendimentoController@create')->name('clientes.ajax.atender');




    Route::resource('atendimentos', 'AtendimentoController' , ['except' => [
        'create', 'store' , 'edit' , 'update' , 
    ]] ); 




    Route::get('atendimentos/cancelar', 'AtendimentoController@cancelar')->name('atendimentos.ajax.cancelar');
    Route::post('atendimentos/finalizar', 'AtendimentoController@finalizar')->name('atendimentos.ajax.finalizar');
    Route::get('atendimentos/cadastrar/{id}', 'AtendimentoController@adicionarItens_temp')->name('atendimentos.ajax.adicionarItens');
    Route::post('atendimentos/cadastrar/servico', 'AtendimentoController@adicionarServico')->name('atendimentos.ajax.adicionarServico');
    Route::get('atendimentos/remover/servico/{id}', 'AtendimentoController@removerServico')->name('atendimentos.ajax.removerServico');
    //Route::post('atendimentos/cadastrar/pagamento', 'AtendimentoController@adicionarPagamento')->name('atendimentos.ajax.adicionarPagamento');
    //Route::get('atendimentos/remover/pagamento/{id}', 'AtendimentoController@removerPagamento')->name('atendimentos.ajax.removerPagamento');
    Route::post('atendimentos/cadastrar/produto', 'AtendimentoController@adicionarProduto')->name('atendimentos.ajax.adicionarProduto');
    Route::get('atendimentos/remover/produto/{id}', 'AtendimentoController@removerProduto')->name('atendimentos.ajax.removerProduto');
    //Route::post('atendimentos/{id}/alterar/data', 'AtendimentoController@alterarData')->name('atendimentos.ajax.alterarData');
    

/*
    Route::delete('atendimentos/apagados/{id}', 'AtendimentoController@destroySoft')->name('atendimentos.destroySoft');
    Route::resource('atendimentos', 'AtendimentoController' , ['except' => [
        'create', 'store' , 'edit' , 'update' , 
    ]] ); 
    Route::post('atendimentos/pesquisar', 'AtendimentoController@pesquisar')->name('atendimentos.pesquisar');  
*/




        //----------------------------------------------------------------------------------------------------------------------
        //  APAGADOS
        //----------------------------------------------------------------------------------------------------------------------

        Route::group(['prefix' => 'apagados', 'middleware' => 'auth' ], function(){
            
            
            // OPERADORAS
            Route::post('clientes/restore/{id}', 'ClienteSoftDeleteController@restore')->name('clientes.ajax.apagados.restore');        
            Route::post('clientes/getDatatable', 'ClienteSoftDeleteController@getDatatable')->name('clientes.ajax.apagados.getDatatable');        
            Route::resource('clientes', 'ClienteSoftDeleteController', ['only' => [
                    'index', 'show' , 'destroy'
                ] ,
                'names' => [                
                    'index' => 'clientes.ajax.apagados.index' ,   
                    'show' => 'clientes.ajax.apagados.show' ,
                    'destroy' => 'clientes.ajax.apagados.destroy' ,
                ]
            ]); 


        });
    


});