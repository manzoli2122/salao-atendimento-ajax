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
            
            <div class="alert alert-default alert-dismissible align-center invisivel" id="divAlerta">
                <label>Excluído</label>
            </div>
            <div class="align-right">
                <a href="{{route('clientes.atender', $model->id)}}" class="btn btn-success" title="Atender" remover-apos-excluir> 
                    <i class="fa fa-money"></i> Atender
                </a>                    
                <button type="button" class="btn btn-danger" id='btnExcluir' remover-apos-excluir>
                    <i class="fa fa-times"></i> Excluir
                </button>
                @permissao('clientes-editar')
                    <a href="{{route('clientes.edit', $model->id)}}" class="btn btn-info" title="Editar" remover-apos-excluir> 
                        <i class="fa fa-pencil"></i> Editar
                    </a>
                @endpermissao
                <a class="btn btn-default" href="{{ URL::previous() }}"><i class="fa fa-reply"></i> Voltar</a>

            </div> 

            <div class="box-header">			
				<h2>Últimos Atendimentos</h2>
        	</div>           		
			
        </div>
        

        <div class="box-footer" style="background:#ecf0f5">
                <section class="row text-center dados">            
                        @forelse($model->atendimentosLast as $atendimento)
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


    </div>
</div>

@forelse($model->atendimentosLast as $atendimento)
	@include('atendimento::clientes.atendimentoModal')				
@empty
@endforelse

@endsection

@push(Config::get('app.templateMasterScript' , 'script'))
<script>
    $(document).ready(function() {
        $('#btnExcluir').click(function (){
            excluirRecursoPeloId({{$model->id}}, "@lang('msg.conf_excluir_o', ['1' => 'tipo de seção'])", "{{route('clientes.apagados')}}", 
                function(){
                    $('[remover-apos-excluir]').remove();
                    $('#divAlerta').slideDown();
                }
            );
        });
    });
</script>
@endpush