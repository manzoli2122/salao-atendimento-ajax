<section class="content-header">
    <h1>
        <span id="div-titulo-pagina">Cliente : {{ $model->cliente->name}} </span>
        <small style="float: right;" > Data : <b> {{ $model->created_at->format('d/m/Y')}} </b> </small>
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-12 col-sm-4 servicos" style="margin-bottom:10px;">
            <h3>Serviços</h3>
            @forelse($model->servicos as $servico)
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border"><h3 class="box-title">{{$servico->servico->nome}}</h3></div>
                            <div class="box-body">
                                <div class="direct-chat-msg">
                                    <div class="direct-chat-info clearfix">
                                        <span class="pull-left">Funcionário: {{$servico->funcionario->apelido}} </span>
                                        <span class="pull-right badge bg-green"> Total R${{ number_format($servico->valor , 2 ,',', '')}} </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
        <div class="col-12 col-sm-4 produtos" style="margin-bottom:0px;">
            <h3>Produtos</h3>
            @forelse($model->produtos as $produto)
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border"><h3 class="box-title">{{$produto->produto->nome}}</h3></div>
                            <div class="box-body">
                                <div class="direct-chat-msg">
                                    <div class="direct-chat-info clearfix">
                                        <span class="pull-left"> quant.: {{$produto->quantidade}} </span>
                                        <span class="pull-right badge bg-blue"> Total R${{ number_format($produto->valor , 2 ,',', '')}} </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse
            <hr style="margin-top:15px;">
        </div>
        <div class="col-12 col-sm-4 pagamentos">
            <h3>Pagamentos</h3>
            @forelse($model->pagamentos as $pagamento)
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-warning">
                            <div class="box-header with-border"><h3 class="box-title">{{$pagamento->formaPagamento}}</h3></div>                        
                            <div class="box-body">                               
                                <div class="direct-chat-msg"> 
                                    @if($pagamento->formaPagamento == 'credito' or $pagamento->formaPagamento == 'debito')                                       
                                        <div class="direct-chat-info clearfix">                               
                                            <span class="pull-left"> @if(isset($pagamento->operadora)) {{ $pagamento->operadora->nome }} @endif </span>
                                            <span class="pull-right"> {{ $pagamento->bandeira }}  </span>
                                        </div>
                                        <div class="direct-chat-info clearfix">                               
                                            <span class="pull-left">  {{ $pagamento->parcelas }}X </span>
                                            <span class="pull-right badge bg-orange"> Valor R${{ number_format($pagamento->valor , 2 ,',', '') }} </span>
                                        </div>
                                    @else
                                        <div class="direct-chat-info clearfix">                               
                                            <span class="pull-left">  </span>
                                            <span class="pull-right badge bg-orange"> Valor R${{ number_format($pagamento->valor , 2 ,',', '') }} </span>
                                        </div>
                                    @endif                                       
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>                     	
            @empty			
            @endforelse 
            @forelse($model->pagamentosFiadosQuitados as $pagamento) 
                <div class="row">        
                        <div class="col-md-12">
                            <div class="box box-danger">
                                <div class="box-header  with-border"><h3 class="box-title">{{$pagamento->formaPagamento}}</h3></div>                        
                                <div class="box-body">                               
                                    <div class="direct-chat-msg">                                                                             
                                        <div class="direct-chat-info clearfix">                               
                                            <span class="pull-left badge bg-red"> Quitado em:  </span>
                                            <span class="pull-right badge bg-red"> {{$pagamento->deleted_at->format('d/m/Y')}}  </span>
                                        </div>
                                        <div class="direct-chat-info clearfix">                               
                                            <span class="pull-left">   </span>
                                            <span class="pull-right badge bg-orange"> Valor R${{ number_format($pagamento->valor , 2 ,',', '') }} </span>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>    
                @empty
                @endforelse            
                <h3 style="text-align:right;">Total R$ {{number_format($model->valor, 2 ,',', '') }} </h3>
                
                <form method="POST"   accept-charset="UTF-8">
                        {{csrf_field()}}
                        <input class="form-control" value="{{$model->created_at->format('Y-m-d')}}"  name="data" type="hidden">
                        
                        <button onclick="atendimentoPesquisar( '{{ route('atendimentos.ajax.pesquisar') }}' , this.form )" style="margin-right:10px; width:100% ; " type="button"  class="btn btn-warning btn-sm" >
                            Voltar
                        </button>
                        	                       									
                </form>  

            </div>
        </div>
    </section>
         