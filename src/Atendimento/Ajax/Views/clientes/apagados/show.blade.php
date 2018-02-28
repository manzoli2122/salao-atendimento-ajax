@extends( Config::get('app.templateMaster' , 'templates.templateMaster')  )

@section( Config::get('app.templateMasterContentTitulo' , 'titulo-page')  )			
	{{$model->name}}
@endsection

@section( Config::get('app.templateMasterContentTituloSmall' , 'small-titulo-page')  )			
	{{$model->email}} | Celular: {{$model->celular}} | Telefone: {{$model->telefone}} | Endereço: {{$model->endereco}}
@endsection

@section( Config::get('app.templateMasterContent' , 'contentMaster')  )

<?php $title = $model->apelido   ?>

<div class="col-md-12">
    <div class="box box-success">
        <div class="box-body" style="background:#ecf0f5">
            <div class="box-header">			
				<h2>Atendimentos</h2>
        	</div>           		
			<section class="row text-center dados">            
                @forelse($model->atendimentos as $atendimento)
                    <div class="col-12 col-sm-4 servicos" style="margin-bottom:10px; ">
                        <div class="row">        
                            <div class="col-md-12">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title" style="width: 100%;"> 
                                            {{ $atendimento->created_at->format('d/m/Y') }}
                                            <a class="btn btn-warning pull-right btn-sm" data-toggle="modal" data-target="#{{$atendimento->id}}atendimentoModal" > 
                                                Visualizar
                                            </a>									
                                        </h3>  								                                                       
                                    </div>                        
                                    <div class="box-body">                               
                                        <div class="direct-chat-msg">                                        
                                            <div class="direct-chat-info clearfix">                               
                                                <span class="pull-left">Valor: </span>
                                                <span class="pull-right badge bg-green"> R$ {{number_format($atendimento->valor, 2)}} </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                    
                        </div>
                    </div>
                @empty			
                @endforelse        
            </section>
        </div>
        <div class="box-footer align-right" style="background:#ecf0f5">
            <a class="btn btn-default" href="{{ URL::previous() }}"><i class="fa fa-reply"></i> Voltar</a>
        </div>
    </div>
</div>

@forelse($model->atendimentos as $atendimento)
	@include('atendimento::clientes.atendimentoModal')				
@empty
@endforelse
@endsection