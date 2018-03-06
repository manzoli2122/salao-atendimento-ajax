@extends( Config::get('app.templateMasterJson' , 'templates.templateMasterJson')  )

@section( Config::get('app.templateMasterContent' , 'content')  ) 

<section class="content-header">
    <h1> <span id="div-titulo-pagina">Cliente : {{ $cliente->name}}  </span>  
        <small style="float: right;">
            @if($cliente->getDivida() > 0)
                <div class="checkbox" style="text-align: right; margin:0px;">
                    <label id="valor_total_divida" data-valor="{{$cliente->getDivida()}}" style="text-align:right; margin:0px; margin-top:0px; color:red; font-size: 24px;">
                        <input onchange="alterardivida()" type="checkbox" style="margin-top: 5px;"> Dividas atrasadas R$ {{ number_format( $cliente->getDivida() , 2 ,',', '') }}
                    </label>
                </div>
            @endif	
        </small>
    </h1>
</section>	

<section class="content">
    <div class="row">           
        <section class=" text-center buttons" style="margin-bottom:1px;">        
            <div class="col-12 col-sm-4 button" style="margin-bottom:10px;">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#servicoModal" style="width: 100%;">
                    <b>Adicionar Serviço</b>
                </button>
            </div>
            <div class="col-12 col-sm-4 button" style="margin-bottom:10px;">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#produtoModal" style="width: 100%;">
                    <b>Adicionar Produto</b>
                </button>
            </div>
            <div class="col-12 col-sm-4 button" style="margin-bottom:10px;">
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#pagamentoModal" style="width: 100%;">
                    <b>Adicionar Pagamento</b>
                </button>           
            </div>       
        </section>

        <section class=" text-center atendimentos"> 
            <div class="col-12 col-sm-4 servicos" style="margin-bottom:10px;" id="todos-servicos">  </div>
        
            <div class="col-12 col-sm-4 produtos" style="margin-bottom:0px;" id="todos-produtos">   </div>

            <div class="col-12 col-sm-4 pagamentos">    
                <div  id="todos-pagamentos"></div>

                <div class="row">        
                    <div class="col-md-12">
                        <hr style="margin:5px;"> 
                        <h3 data-valor="0" style="text-align:right;  margin:0px; margin-top:10px;" id="valor_total_pagamentos">Total dos Pagamentos R$ 0,00 </h3>
                    </div>    
                    
                    <div class="col-md-12">
                        <h3 data-valor="0" style="text-align:right; margin:0px; margin-top:10px;" id="valor_total"> Valor Total R$ 0,00 </h3>
                    </div>
                    <div class="col-md-12">
                        <p style="margin-bottom:10px; margin-top:10px">                                
                            <button class="btn btn-success" onclick="atendimentoStore()" style="width: 100%;">
                                <i class="fa fa-check"></i> FINALIZAR 
                            </button> 
                        </p>
                    </div>
                    <div class="col-md-12">
                        <a style="width: 100%;" class="btn btn-warning" href='{{route("atendimentos.ajax.index")}}'>
                            <i class="fa fa-times" aria-hidden="true"></i>
                            CANCELAR
                        </a>      
                    </div>
                </div>    
            </div>            
        </section>
    </div>
</section>
                    
    @include('atendimentoAjax::atendimentos.servicoModal')  
    @include('atendimentoAjax::atendimentos.produtoModal')
    @include('atendimentoAjax::atendimentos.pagamentoModal')
    
@endsection
 





@push( Config::get('app.templateMasterScript' , 'script')  )        
    <script src="{{ mix('js/atendimento.js') }}" type="text/javascript"></script>

    <script>

                        
            window.atendimentoStore = function(  ) {			
                alertProcessando();	
                
                var valorPagamentos =   parseFloat( document.getElementById("valor_total_pagamentos").dataset.valor  ) ;
                var valorAtendimentos =  parseFloat( document.getElementById("valor_total").dataset.valor  ) ;
                var diferenca = valorAtendimentos - valorPagamentos ;
                
                if( ( diferenca * diferenca ) > 0  ){      
                    toastErro("Valor total não confere com valor dos Pagamentos");                    
                    alertProcessandoHide();	
                    return ;
                }
                var token = document.head.querySelector('meta[name="csrf-token"]').content;			
                var url = "{{route('atendimentos.ajax.finalizar')}}" ;
                $.ajax({
                    url: url ,
                    type: 'post',
                    data: { _token: token , _servicos: JSON.stringify( servicos ) , _pagamentos: JSON.stringify( pagamentos )  ,
                            _produtos: JSON.stringify( produtos )  , cliente_id: {{ $cliente->id}}  } ,
                    success: function(retorno) {
                        alertProcessandoHide();							
                        if (retorno.erro) {	                            
                            toastErro(retorno.msg);
                           	  
                        } 
                        else {
                            toastSucesso(retorno.msg);
                            window.location = "{{ route('atendimentos.ajax.index') }}";                           	
                        }											
                    },
                    error: function(erro) {
                        alertProcessandoHide();
                        toastErro("Ocorreu um erro");
                        console.log(erro);
                    }
                });		
            }
    </script>

@endpush
