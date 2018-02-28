<?php

namespace Manzoli2122\Salao\Cadastro\Ajax;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AtendimentoAjaxServiceProvider extends ServiceProvider
{


    protected $defer = false;
    protected $namespace = 'Manzoli2122\Salao\Atendimento\Ajax\Http\Controllers'  ;
    
    public function boot()
    {
        // Publish config files
        $this->publishes([
            __DIR__.'/../../config/config.php' =>  config_path('atendimentoAjax.php'), 
        ], 'atendimentoAjax_config');
        $this->mapWebRoutes();     
        $this->loadViewsFrom(__DIR__.'/Views', 'atendimentoAjax');
    }


    private function mapWebRoutes()
    {                
        Route::middleware('web')
                ->namespace($this->namespace)
                ->group(__DIR__.'/Http/routes.php');
    }



    public function register()
    {
       
        $this->mergeConfig();
    }


   

    private function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php', 'atendimentoAjax'
        );
    }

   



   
}

