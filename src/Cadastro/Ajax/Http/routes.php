<?php
use Illuminate\Support\Facades\Route;

    Route::group(['prefix' => 'cadastro/ajax', 'middleware' => 'auth' ], function(){



        // OPERADORAS
        Route::post('operadoras/getDatatable', 'OperadoraController@getDatatable')->name('operadoras.ajax.getDatatable');        
        Route::resource('operadoras', 'OperadoraController' , ['names' => [
            'create' => 'operadoras.ajax.create' ,
            'index' => 'operadoras.ajax.index' ,
            'edit' => 'operadoras.ajax.edit' ,
            'update' => 'operadoras.ajax.update' ,
            'store' => 'operadoras.ajax.store' ,
            'show' => 'operadoras.ajax.show' ,
            'destroy' => 'operadoras.ajax.destroy' ,
        ]]); 





        // PRODUTOS
        Route::post('produtos/getDatatable', 'ProdutoController@getDatatable')->name('produtos.ajax.getDatatable');        
        Route::resource('produtos', 'ProdutoController', ['names' => [
            'create' => 'produtos.ajax.create' ,
            'index' => 'produtos.ajax.index' ,
            'edit' => 'produtos.ajax.edit' ,
            'update' => 'produtos.ajax.update' ,
            'store' => 'produtos.ajax.store' ,
            'show' => 'produtos.ajax.show' ,
            'destroy' => 'produtos.ajax.destroy' ,
        ]]); 
        





        // SERVIÇOS
        Route::post('servicos/getDatatable', 'ServicoController@getDatatable')->name('servicos.ajax.getDatatable');        
        Route::resource('servicos', 'ServicoController' , ['names' => [
            'create' => 'servicos.ajax.create' ,
            'index' => 'servicos.ajax.index' ,
            'edit' => 'servicos.ajax.edit' ,
            'update' => 'servicos.ajax.update' ,
            'store' => 'servicos.ajax.store' ,
            'show' => 'servicos.ajax.show' ,
            'destroy' => 'servicos.ajax.destroy' ,
        ]]);




        
        
  
        




        //----------------------------------------------------------------------------------------------------------------------
        //  APAGADOS
        //----------------------------------------------------------------------------------------------------------------------

        Route::group(['prefix' => 'apagados', 'middleware' => 'auth' ], function(){
            
            
            // OPERADORAS
            Route::post('operadoras/restore/{id}', 'OperadoraSoftDeleteController@restore')->name('operadoras.ajax.apagados.restore');        
            Route::post('operadoras/getDatatable', 'OperadoraSoftDeleteController@getDatatable')->name('operadoras.ajax.apagados.getDatatable');        
            Route::resource('operadoras', 'OperadoraSoftDeleteController', ['only' => [
                    'index', 'show' , 'destroy'
                ] ,
                'names' => [                
                    'index' => 'operadoras.ajax.apagados.index' ,   
                    'show' => 'operadoras.ajax.apagados.show' ,
                    'destroy' => 'operadoras.ajax.apagados.destroy' ,
                ]
            ]); 






            // PRODUTOS
            Route::post('produtos/restore/{id}', 'ProdutoSoftDeleteController@restore')->name('produtos.ajax.apagados.restore');        
            Route::post('produtos/getDatatable', 'ProdutoSoftDeleteController@getDatatable')->name('produtos.ajax.apagados.getDatatable');        
            Route::resource('produtos', 'ProdutoSoftDeleteController', ['only' => [
                    'index', 'show' , 'destroy'
                ] ,
                'names' => [                
                    'index' => 'produtos.ajax.apagados.index' ,   
                    'show' => 'produtos.ajax.apagados.show' ,
                    'destroy' => 'produtos.ajax.apagados.destroy' ,
                ]
            ]); 




            // SERVIÇOS
            Route::post('servicos/restore/{id}', 'ServicoSoftDeleteController@restore')->name('servicos.ajax.apagados.restore');        
            Route::post('servicos/getDatatable', 'ServicoSoftDeleteController@getDatatable')->name('servicos.ajax.apagados.getDatatable');        
            Route::resource('servicos', 'ServicoSoftDeleteController', ['only' => [
                    'index', 'show' , 'destroy'
                ] ,
                'names' => [                
                    'index' => 'servicos.ajax.apagados.index' ,   
                    'show' => 'servicos.ajax.apagados.show' ,
                    'destroy' => 'servicos.ajax.apagados.destroy' ,
                ]
            ]); 



        });

    });