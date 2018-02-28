    <?php $title = $model->apelido   ?>
    <section class="content-header">
        <h1>
            <span id="div-titulo-pagina">{{$model->name}}</span>
            <small id="div-small-content-header" > {{$model->email}} | Celular: {{$model->celular}} | Telefone: {{$model->telefone}} | Endereço: {{$model->endereco}} </small>
        </h1>
    </section>
                
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success" id="div-box"> 
                    <div class="box-body" style="background:#ecf0f5">            
                        <div class="alert alert-default alert-dismissible align-center invisivel" id="divAlerta">
                            <label>Excluído</label>
                        </div>
                        <div class="align-right">

                            <a href="{{route('clientes.atender', $model->id)}}" class="btn btn-success" title="Atender" remover-apos-excluir> 
                                <i class="fa fa-money"></i> Atender
                            </a>   

                            @permissao('clientes-soft-delete')
                                <button type="button" class="btn btn-danger"  onclick="modelDelete( {{$model->id}} , '{{ route('clientes.ajax.index') }}')" remover-apos-excluir>
                                    <i class="fa fa-times"></i> Excluir
                                </button>
                            @endpermissao

                            @permissao('clientes-editar')
                                <button type="button" class="btn btn-info"  onclick="modelEditar( {{$model->id}} , '{{ route('clientes.ajax.index') }}' )" remover-apos-excluir  title="Editar">
                                    <i class="fa fa-pencil"></i> Editar
                                </button>                        
                            @endpermissao

                            <button type="button" class="btn btn-default"  onclick="modelVoltarIndex()" > <i class="fa fa-reply"></i> Voltar </button> 
                
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
        </div>
    </section>

    @forelse($model->atendimentosLast as $atendimento)
        @include('atendimento::clientes.atendimentoModal')				
    @empty
    @endforelse
