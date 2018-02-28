<div class="modal fade  bd-example-modal-lg" id="{{$atendimento->id}}atendimentoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" style="min-width:90%;" role="document">
        <div class="modal-content ">
            <div class="modal-header " style="background:green; color:white;">
                <button style="color:white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span style="color:white;" aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cliente : <b> {{ $atendimento->cliente->name}} - {{ $atendimento->created_at->format('d/m/Y') }}</h4>
            </div>
            <div class="modal-body">               
                <section class="row text-center atendimentos"> 
                    <div class="col-12 col-sm-4 servicos" style="margin-bottom:10px; ">
                        <h3 style=" background:green; color:white;" >Serviços</h3>
                        @forelse($atendimento->servicos as $servico) 
                            <div class="row">        
                                <div class="col-md-12">
                                    <div class="box box-success">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{$servico->servico->nome}}</h3>                                                          
                                        </div>                        
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
                        <h3 style=" background:blue; color:white;" >Produtos</h3>
                        @forelse($atendimento->produtos as $produto)
                            <div class="row">        
                                <div class="col-md-12">
                                    <div class="box box-info">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{$produto->produto->nome}}</h3>                                                          
                                        </div>                        
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
                        <h3 style=" background:orange; color:white;">Pagamentos</h3>
                        @forelse($atendimento->pagamentos as $pagamento)
                            <div class="row">        
                                <div class="col-md-12">
                                    <div class="box box-warning">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{$pagamento->formaPagamento}}</h3>                                                          
                                        </div>                        
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
                        @forelse($atendimento->pagamentosFiadosQuitados as $pagamento) 
                            <div class="row">        
                                <div class="col-md-12">
                                    <div class="box box-danger">
                                        <div class="box-header  with-border">
                                            <h3 class="box-title">{{$pagamento->formaPagamento}}</h3>                                                          
                                        </div>                        
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
                        <hr style="margin-top:15px;"> 
                        <h3 style="text-align:right;">Total R$ {{number_format($atendimento->valor, 2 ,',', '') }} </h3>
                    </div>            
                </section>
            </div> 
        </div>
    </div>
</div>