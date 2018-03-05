@extends( Config::get('app.templateMasterJson' , 'templates.templateMasterJson')  )

@section( Config::get('app.templateMasterContent' , 'content')  ) 

<section class="content-header">
    <h1> <span id="div-titulo-pagina">Cliente : {{ $cliente->name}}  </span>  </h1>
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
                        <h3 style="text-align:right; margin:0px; margin-top:10px;" id="valor_total_pagamentos">Total de Pagamento R$ 0,00 </h3>
                    </div>    
                    <div class="col-md-12">
                        <h3 style="text-align:right; margin:0px; margin-top:10px; color:red;" id="valor_total_divida" data-nome="{{$cliente->getDivida()}}"> Dividas atrasadas R$ {{ number_format( $cliente->getDivida() , 2 ,',', '') }} </h3>
                    </div>  
                    <div class="col-md-12">
                        <h3 style="text-align:right; margin:0px; margin-top:10px;" id="valor_total"> Valor Total R$ 0,00 </h3>
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
                <div class="row">        
                    <div class="col-md-12">                   
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

    
            function finalizarSend(val) {
                var atendimento = val.elements['total_atendimento'].value
                var pagamento = val.elements['total_pagamento'].value
                var dif = atendimento - pagamento;
                if (dif > 0.09) {
                    alert('O valor total do atendimento que é R$' + atendimento +
                        ' não confere com o do pagamento que é R$' + pagamento);
                    return false;
                }
                return true;
            }
            
            window.atendimentoStore123 = function(  ) {
                document.getElementById("_servicos").value = JSON.stringify( servicos );  
                document.getElementById("_pagamentos").value = JSON.stringify( pagamentos ); 
                document.getElementById("_produtos").value = JSON.stringify( produtos );
            }
                        
            window.atendimentoStore = function(  ) {			
                alertProcessando();	
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
