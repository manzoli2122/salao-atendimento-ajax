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
                        <hr style="margin-top:15px;"> 
                        <h3 style="text-align:right;">Total de Pagamento R$ 12 </h3>
                    </div>    
                    <div class="col-md-12">
                        <h3 style="text-align:right; margin:0px; margin-top:25px; color:red;"> Dividas atrasadas R$ 12 </h3>
                    </div>  
                    <div class="col-md-12">
                        <h3 style="text-align:right; margin:0px; margin-top:25px;" id="valor_total"> Valor Total R$ 12</h3>
                    </div>
                    <div class="col-md-12">
                        <p style="margin-bottom:20px; margin-top:10px">
                                
                            <button class="btn btn-success" onclick="atendimentoStore123()" style="width: 100%;">
                                <i class="fa fa-check"></i> Finalizar 
                            </button> 


                            <form class="form form-search form-ds" method="post" action="{{route('atendimentos.ajax.finalizar')}}" >
                                {{csrf_field()}}                        
                                <input name="_servicos" id="_servicos" value="" type="hidden">
                                <input name="_produtos" id="_produtos" value="" type="hidden">
                                <input name="_pagamentos" id="_pagamentos" value="" type="hidden">
                                <button type="submit" class="btn btn-success" style="width: 100%;" >
                                    <i class="fa fa-check"></i> Finalizar
                                </button>
                            </form>
                        </p>
                    </div>
                    <div class="col-md-12">
                        <a style="width: 100%;" class="btn btn-warning" href='{{route("atendimentos.ajax.cancelar")}}'>
                            <i class="fa fa-delete" aria-hidden="true"></i>
                            Cancelar
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

             

        
window.AdicionarPagamento = function () {

    var novoPagamento = {};
    var form = document.forms["form-pagamento"];

    var elements = form.querySelectorAll("input, select, textarea");
    for (var i = 0; i < elements.length; ++i) {
        var element = elements[i];
        var name = element.name;
        var value = element.value;
        if (name) {
            novoPagamento[name] = value;
        }
    }

    if (novoPagamento.formaPagamento == '') {
        toastErro('Selecione a Forma de Pagamento.');
        return;
    }
    
    pagamentos.push(novoPagamento);

    
    restartModalPagamento();
    desenharPagamento();
    calculaValorTotal();
    alertSucesso("Pagamento Adicionado Com sucesso!!");
}




window.removerPagamento = function (posicao) {
    pagamentos.splice(posicao, 1);    
    desenharServico();
    calculaValorTotal();
}



window.restartModalPagamento = function () {
    
    //$('#servico_id').val(null).trigger('change');
    var form = document.forms["form-pagamento"];
    
    form["formaPagamento"].value = '';
    form["operadora_id"].value = '';
    form["parcelas"].value = '1';
    form["valor"].value = '0';
    form["bandeira"].value = '';
    form["observacoes"].value = '';

   

    document.getElementById("form-operadora").hidden = true;
    document.getElementById("form-parcelas").hidden = true;
    document.getElementById("form-bandeira").hidden = true;
    document.getElementById("operadora_id").required = false;
    document.getElementById("parcelas").required = false;
    document.getElementById("bandeira").required = false;
    
}





window.desenharPagamento = function () {

    var html = '';
    for (i in pagamentos) {

        var item = pagamentos[i];

        html = html + '<div class="row"> ';
        html = html + '     <div class="col-md-12">';
        html = html + '         <div class="box box-warning">';
        html = html + '             <div class="box-header with-border">';
        html = html + '                 <h3 class="box-title">' + item.formaPagamento + '</h3>';
        html = html + '                 <div class="box-tools pull-right">';
        html = html + '                     <button class="btn btn-box-tool "type="button" onclick="removerPagamento( ' + i + ' )" > <i class="fa fa-times"> </i> </button>';
        html = html + '                 </div>  ';
        html = html + '             </div>   ';
        html = html + '             <div class="box-body">    ';
        html = html + '                 <div class="direct-chat-msg">';      
        html = html + '                     <div class="direct-chat-info clearfix">  ';
        html = html + '                         <span class="pull-right  badge bg-orange">Valor R$ ' + item.valor + '</span>';
        html = html + '                         <span class="pull-left"></span>';
        html = html + '                     </div>';
        html = html + '                  </div>';
        html = html + '              </div>';
        html = html + '         </div>';
        html = html + '     </div>   ';
        html = html + '</div>';

    }

    document.getElementById("todos-pagamentos").innerHTML = html;

}

























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
                    data: {_token: token , _servicos: JSON.stringify( servicos ) } ,
                    success: function(retorno) {
                        alertProcessandoHide();							
                        if (retorno.erro) {	                            
                            toastErro(retorno.msg);
                           	  
                        } 
                        else {
                            toastSucesso(retorno.msg);                           	
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
