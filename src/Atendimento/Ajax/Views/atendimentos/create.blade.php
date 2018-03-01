@extends( Config::get('app.templateMaster' , 'templates.templateMaster')  )

@section( Config::get('app.templateMasterContentTitulo' , 'titulo-page')  )			
	Cliente : {{ $atendimento->cliente->name}} 
@endsection

@push( Config::get('app.templateMasterCss' , 'styles')  )
    <style type="text/css">    
        .ui-autocomplete {
            z-index:2147483647;
            /*position: fixed;*/
        }
    </style>
@endpush

@section( Config::get('app.templateMasterContent' , 'content')  )  
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
        <div class="col-12 col-sm-4 servicos" style="margin-bottom:10px;" id="todos-servicos">  
            
            
            @forelse($atendimento->servicos as $servico) 
                <div class="row">        
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{$servico->servico->nome}}</h3>
                                <div class="box-tools pull-right">
                                    <a class="btn btn-box-tool" href="{{ route('atendimentos.removerServico',$servico->id) }}"><i class="fa fa-times"></i> </a>                            
                                </div>                            
                            </div>                        
                            <div class="box-body">                               
                                <div class="direct-chat-msg">
                                    <div class="direct-chat-info clearfix">                               
                                        <span class="pull-right">Funcionário: {{$servico->funcionario->apelido}}</span>
                                        <span class="pull-left">R${{   number_format(  $servico->valorUnitario() , 2 ,',', '')  }} / Unid.</span>
                                    </div>
                                    <div class="direct-chat-info clearfix">                               
                                        <span class="pull-left"> quant.: {{$servico->quantidade}} </span>
                                        <span class="pull-right badge bg-green"> Total R${{ number_format($servico->valor() , 2 ,',', '')}} </span>
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
            @forelse($atendimento->produtos as $produto)
                <div class="row">        
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{$produto->produto->nome}}</h3>
                                <div class="box-tools pull-right">
                                    <a class="btn btn-box-tool" href="{{ route('atendimentos.removerProduto',$produto->id) }}"><i class="fa fa-times"></i> </a>                            
                                </div>                            
                            </div>                        
                            <div class="box-body">                               
                                <div class="direct-chat-msg">
                                    <div class="direct-chat-info clearfix">                               
                                        <span class="pull-left"> R${{   number_format(  $produto->valorUnitario() , 2 ,',', '')  }} / Unid. </span>
                                        <span class="pull-right"></span>
                                    </div>
                                    <div class="direct-chat-info clearfix">                               
                                        <span class="pull-left"> quant.: {{$produto->quantidade}} </span>
                                        <span class="pull-right badge bg-blue"> Total R${{ number_format($produto->valor() , 2 ,',', '')}} </span>
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
            @forelse($atendimento->pagamentos as $pagamento)
                <div class="row">        
                    <div class="col-md-12">
                        <div class="box box-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{$pagamento->formaPagamento}}</h3>
                                <div class="box-tools pull-right">
                                    <a class="btn btn-box-tool" href="{{ route('atendimentos.removerPagamento',$pagamento->id) }}"><i class="fa fa-times"></i> </a>                            
                                </div>                            
                            </div>                        
                            <div class="box-body">                               
                                    <div class="direct-chat-msg"> 
                                        @if($pagamento->formaPagamento == 'credito' or $pagamento->formaPagamento == 'debito')                                       
                                            <div class="direct-chat-info clearfix">                               
                                                <span class="pull-left"> {{ $pagamento->operadora->nome }}  </span>
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
            <div class="row">        
                <div class="col-md-12">
                    <hr style="margin-top:15px;"> 
                    <h3 style="text-align:right;">Total de Pagamento R$ {{number_format($atendimento->valorPagamentos(), 2 ,',', '') }} </h3>
                </div>    
                <div class="col-md-12">
                    <h3 style="text-align:right; margin:0px; margin-top:25px; color:red;"> Dividas atrasadas R$ {{number_format($atendimento->servicoAnterioresFiados(), 2 ,',', '') }} </h3>
                </div>  
                <div class="col-md-12">
                    <h3 style="text-align:right; margin:0px; margin-top:25px;"> Valor Total R$ {{number_format($atendimento->valor, 2 ,',', '') }} </h3>
                </div>
                <div class="col-md-12">
                    <p style="margin-bottom:20px; margin-top:10px">
                        <form class="form form-search form-ds" method="post" action="{{route('atendimentos.finalizar', $atendimento->id)}}" onsubmit="return  finalizarSend(this)">
                            {{csrf_field()}}                        
                            <input name="total_atendimento" value="{{$atendimento->valor}}" type="hidden">
                            <input name="total_pagamento" value="{{$atendimento->valorPagamentos()}}" type="hidden">
                            <button type="submit" class="btn btn-success" style="width: 100%;" >
                                <i class="fa fa-check"></i> Finalizar
                            </button>
                        </form>
                    </p>
                </div>
                <div class="col-md-12">
                    <a style="width: 100%;" class="btn btn-warning" href='{{route("atendimentos.cancelar", $atendimento->id)}}'>
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

                    
    @include('atendimentoAjax::atendimentos.produtoModal') 
    @include('atendimentoAjax::atendimentos.servicoModal')                
    @include('atendimentoAjax::atendimentos.pagamentoModal')

@endsection
  
@push( Config::get('app.templateMasterScript' , 'script')  )
        


    
<script>


        var servicos = [];


        function AdicionarServico() {  
            
            var novoServico = {};
            
            var elements = document.forms["form-servico"].querySelectorAll( "input, select, textarea" );
			for( var i = 0; i < elements.length; ++i ) {
				var element = elements[i];
				var name = element.name;
				var value = element.value;	
				if( name ) {
					novoServico[ name ] = value;
				}
            }
            
            if(novoServico.servico_id == ''){
                alert('Serviço nao selecionado');
            }


            if(novoServico.funcionario_id == ''){
                alert('Funcionario nao selecionado');
            }



            
            



            servicos.push(novoServico);

            var html = '';
            for(i in servicos) {           
                var item = servicos[i];



                html = html + '<div class="row"> ';       
                html = html + '     <div class="col-md-12">';
                html = html + '         <div class="box box-success">';
                html = html + '             <div class="box-header with-border">';
                html = html + '                 <h3 class="box-title">' + item.servico_id + '</h3>';
                html = html + '                 <div class="box-tools pull-right">';
                html = html + '                     <a class="btn btn-box-tool" href="#"><i class="fa fa-times"></i> </a>';                            
                html = html + '                 </div>  ';                          
                html = html + '             </div>   ';                     
                html = html + '             <div class="box-body">    ';                           
                html = html + '                 <div class="direct-chat-msg">';
                html = html + '                     <div class="direct-chat-info clearfix">  ';                             
                html = html + '                         <span class="pull-right">Funcionário: ' + item.funcionario_id + '</span>';
                html = html + '                         <span class="pull-left">R$ ' + item.valor_servico_unitario + ' / Unid.</span>';
                html = html + '                     </div>';
                html = html + '                     <div class="direct-chat-info clearfix"> ';                              
                html = html + '                         <span class="pull-left"> quant.: ' + item.quantidade + ' </span>';
                html = html + '                         <span class="pull-right badge bg-green"> Total R$  ' + item.valor_servico_total + ' </span>';
                html = html + '                     </div>';
                html = html + '                  </div>';
                html = html + '              </div>';
                html = html + '         </div>';
                html = html + '     </div>   ';    
                html = html + '</div>';


                //html = html + JSON.stringify( item ) ;
                console.log(JSON.stringify( item ));
            }

            document.getElementById("todos-servicos").innerHTML = html  ;



            //console.log(servicos);

            
        }





        //--------------------------------------------------------------------------------------------------------------------------------------
        //      COMBO BOX DO PRODUTO
        //--------------------------------------------------------------------------------------------------------------------------------------
        
        $( function() {
            $.widget( "custom.combobox", {
                
                _create: function() {
                    this.wrapper = $( "<span>" ).addClass( "custom-combobox" ).insertAfter( this.element );  
                    this.element.hide();
                    this._createAutocomplete();
                    this._createShowAllButton();
                },
  
                _createAutocomplete: function() {
                    var selected = this.element.children( ":selected" ),
                    value = selected.val() ? selected.text() : "";
                    this.input = $( "<input>" ).appendTo( this.wrapper ).val( value ).attr( "title", "" )
                        .attr( "style", "width: 85%;     display: inline;" )
                        .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left form-control" )
                        .autocomplete({
                            delay: 0,      minLength: 0,      source: $.proxy( this, "_source" )
                        })
                        .tooltip({       classes: {"ui-tooltip": "ui-state-highlight"}        });
  
                    this._on( this.input, {
                        autocompleteselect: function( event, ui ) {
                            ui.item.option.selected = true;
                            this._trigger( "select", event, {item: ui.item.option});
                        },  
                        autocompletechange: "_removeIfInvalid"  
                    });
                },
  
                _createShowAllButton: function() {
                    var input = this.input,    wasOpen = false;
                    $( "<a>" )
                        .attr( "tabIndex", -1 ).attr( "title", "Show All Items" ).tooltip().appendTo( this.wrapper )
                        .button({
                            icons: {primary: "ui-icon-triangle-1-s"},
                            text: false
                        })
                        .removeClass( "ui-corner-all" ).addClass( "custom-combobox-toggle ui-corner-right form-control" )
                        .on( "mousedown", function() {   wasOpen = input.autocomplete( "widget" ).is( ":visible" );     })
                        .on( "click", function() {
                            input.trigger( "focus" );  
                            // Close if already visible
                            if ( wasOpen ) {return;}  
                            // Pass empty string as value to search for, displaying all results
                            input.autocomplete( "search", "" );
                        });
                },
  
                _source: function( request, response ) {
                    var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                    response( this.element.children( "option" ).map(function() {
                        var text = $( this ).text();
                        if ( this.value && ( !request.term || matcher.test(text) ) )
                            return {    label: text,      value: text,          option: this    };
                    }) );
                },

                _produtoFunction: function( event, ui ) {                   
                    var form = document.forms["form-produto"] ;                
                    var produto =  form["produto_id"].options[form["produto_id"].selectedIndex] ;                                 
                    var quantidade = parseInt( form["quantidade"].value );                              
                    var desconto_maximo = parseInt(  produto.dataset.maximo );                                        
                    var valor = parseFloat(  produto.getAttribute('label') );                          
                    form["desconto"].max = ( desconto_maximo * valor / 100); 
                    if( valor != 0.0 ){form["acrescimo"].max = valor ;} 
                    if( form["desconto"].value == ''){form["desconto"].value = 0.0;}                   
                    var desconto =  parseFloat( form["desconto"].value) ;                           
                    if(form["acrescimo"].value == ''){form["acrescimo"].value = 0.0;}
                    var acrescimo = parseFloat(  form["acrescimo"].value );
                    var valor_unitario = valor - desconto + acrescimo ;  
                    var valor_total = valor_unitario * quantidade;  
                    console.log('iniciou produto , quantidade: ' + quantidade + ', desconto_maximo ' + desconto_maximo 
                    + ', valor: ' + valor + ', acrescimo: ' + acrescimo + ', valor_unitario: ' + valor_unitario + ', valor_total: ' + valor_total   );        
                    form["valor-produto-unitario"].value = valor_unitario;
                    form["valor-produto-total"].value = valor_total;

                },

                
                _produtoClearFunction: function( event, ui ) {                   
                    var form = document.forms["form-produto"] ;
                    form["quantidade"].value = 1 ;                       
                    form["desconto"].max = 0; 
                    form["acrescimo"].max = 0 ;                      
                    form["desconto"].value = 0.0;                           
                    form["acrescimo"].value = 0.0;                            
                    form["valor-servico-unitario"].value =  0.0 ;
                    form["valor-servico-total"].value =  0.0 ;
                },


                _removeIfInvalid: function( event, ui ) {
                    // Selected an item, nothing to do
                    if ( ui.item ) {
                        this._produtoFunction();
                        return;
                    } 
                    // Search for a match (case-insensitive)
                    var value = this.input.val(),
                    valueLowerCase = value.toLowerCase(),
                    valid = false;
                    this.element.children( "option" ).each(function() {
                        if ( $( this ).text().toLowerCase() === valueLowerCase ) {
                            this.selected = valid = true;
                            return false;
                        }
                    });  
                    // Found a match, nothing to do
                    if ( valid ) {
                        this._produtoFunction();
                        return;
                    }  
                    // Remove invalid value
                    this.input
                        .val( "" )
                        .attr( "title", value + " didn't match any item" )
                        .tooltip( "open" );
                    this.element.val( "" );
                    this._delay(function() {
                        this.input.tooltip( "close" ).attr( "title", "" );
                    }, 2500 );
                    this.input.autocomplete( "instance" ).term = "";
                    //limpa os campos 
                    this._produtoClearFunction();
                },
  
                _destroy: function() {
                    this.wrapper.remove();
                    this.element.show();
                }
            });
  
            $( "#produto_id" ).combobox();
            
        } );
     </script>


     <script>
            function produtoFunction() {  

                    var form = document.forms["form-produto"] ;                
                    var produto =  form["produto_id"].options[form["produto_id"].selectedIndex] ;                                 
                    var quantidade = parseInt( form["quantidade"].value );                              
                    var desconto_maximo = parseInt(  produto.dataset.maximo );                                        
                    var valor = parseFloat(  produto.getAttribute('label') );                          
                    form["desconto"].max = ( desconto_maximo * valor / 100); 
                    if( valor != 0.0 ){form["acrescimo"].max = valor ;} 
                    if( form["desconto"].value == ''){form["desconto"].value = 0.0;}                   
                    var desconto =  parseFloat( form["desconto"].value) ;                           
                    if(form["acrescimo"].value == ''){form["acrescimo"].value = 0.0;}
                    var acrescimo = parseFloat(  form["acrescimo"].value );
                    var valor_unitario = valor - desconto + acrescimo ;  
                    var valor_total = valor_unitario * quantidade;  
                    console.log('iniciou produto , quantidade: ' + quantidade + ', desconto_maximo ' + desconto_maximo 
                    + ', valor: ' + valor + ', acrescimo: ' + acrescimo + ', valor_unitario: ' + valor_unitario + ', valor_total: ' + valor_total   );        
                    form["valor-produto-unitario"].value = valor_unitario;
                    form["valor-produto-total"].value = valor_total;

                
            }
        </script>


















        

    <script>
        //--------------------------------------------------------------------------------------------------------------------------------------
        //      COMBO BOX DO SERVICO
        //--------------------------------------------------------------------------------------------------------------------------------------
        
        $( function() {
            $.widget( "custom.combobox", {
                
                _create: function() {
                    this.wrapper = $( "<span>" ).addClass( "custom-combobox" ).insertAfter( this.element );  
                    this.element.hide();
                    this._createAutocomplete();
                    this._createShowAllButton();
                },
  
                _createAutocomplete: function() {
                    var selected = this.element.children( ":selected" ),
                    value = selected.val() ? selected.text() : "";
                    this.input = $( "<input>" ).appendTo( this.wrapper ).val( value ).attr( "title", "" )
                        .attr( "style", "width: 85%;     display: inline;" )
                        .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left form-control" )
                        .autocomplete({
                            delay: 0,      minLength: 0,      source: $.proxy( this, "_source" )
                        })
                        .tooltip({       classes: {"ui-tooltip": "ui-state-highlight"}        });
  
                    this._on( this.input, {
                        autocompleteselect: function( event, ui ) {
                            ui.item.option.selected = true;
                            this._trigger( "select", event, {item: ui.item.option});
                        },  
                        autocompletechange: "_removeIfInvalid"  
                    });
                },
  
                _createShowAllButton: function() {
                    var input = this.input,    wasOpen = false;
                    $( "<a>" )
                        .attr( "tabIndex", -1 ).attr( "title", "Show All Items" ).tooltip().appendTo( this.wrapper )
                        .button({
                            icons: {primary: "ui-icon-triangle-1-s"},
                            text: false
                        })
                        .removeClass( "ui-corner-all" ).addClass( "custom-combobox-toggle ui-corner-right form-control" )
                        .on( "mousedown", function() {   wasOpen = input.autocomplete( "widget" ).is( ":visible" );     })
                        .on( "click", function() {
                            input.trigger( "focus" );  
                            // Close if already visible
                            if ( wasOpen ) {return;}  
                            // Pass empty string as value to search for, displaying all results
                            input.autocomplete( "search", "" );
                        });
                },
  
                _source: function( request, response ) {
                    var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                    response( this.element.children( "option" ).map(function() {
                        var text = $( this ).text();
                        if ( this.value && ( !request.term || matcher.test(text) ) )
                            return {    label: text,      value: text,          option: this    };
                    }) );
                },

                _servicoFunction: function( event, ui ) {                   
                    var form = document.forms["form-servico"] ;                
                    var servico =  form["servico_id"].options[form["servico_id"].selectedIndex] ;                                 
                    var quantidade = parseInt( form["quantidade"].value );                              
                    var desconto_maximo = parseInt(  servico.dataset.maximo );                                        
                    var valor = parseFloat(  servico.getAttribute('label') );                          
                    form["desconto"].max = ( desconto_maximo * valor / 100); 
                    form["acrescimo"].max = valor ;   
                    //form["servico_id"].value = servico.value ; 
                    if( form["desconto"].value == ''){form["desconto"].value = 0.0;}                   
                    var desconto =  parseFloat( form["desconto"].value) ;                           
                    if(form["acrescimo"].value == ''){form["acrescimo"].value = 0.0;}
                    var acrescimo = parseFloat(  form["acrescimo"].value );
                    var valor_unitario = valor - desconto + acrescimo ;  
                    var valor_total = valor_unitario * quantidade;  
                    console.log('iniciou servico , quantidade: ' + quantidade + ', desconto_maximo ' + desconto_maximo 
                    + ', valor: ' + valor + ', acrescimo: ' + acrescimo + ', valor_unitario: ' + valor_unitario + ', valor_total: ' + valor_total   );        
                    form["valor_servico_unitario"].value = valor_unitario;
                    form["valor_servico_total"].value = valor_total;
                },

                
                _servicoClearFunction: function( event, ui ) {                   
                    var form = document.forms["form-servico"] ;
                    form["quantidade"].value = 1 ;                       
                    form["desconto"].max = 0; 
                    form["acrescimo"].max = 0 ;                      
                    form["desconto"].value = 0.0;                           
                    form["acrescimo"].value = 0.0;                            
                    form["valor_servico_unitario"].value =  0.0 ;
                    form["valor_servico_total"].value =  0.0 ;
                },


                _removeIfInvalid: function( event, ui ) {
                    // Selected an item, nothing to do
                    if ( ui.item ) {
                        this._servicoFunction();
                        return;
                    } 
                    // Search for a match (case-insensitive)
                    var value = this.input.val(),
                    valueLowerCase = value.toLowerCase(),
                    valid = false;
                    this.element.children( "option" ).each(function() {
                        if ( $( this ).text().toLowerCase() === valueLowerCase ) {
                            this.selected = valid = true;
                            return false;
                        }
                    });  
                    // Found a match, nothing to do
                    if ( valid ) {
                        this._servicoFunction();
                        return;
                    }  
                    // Remove invalid value
                    this.input
                        .val( "" )
                        .attr( "title", value + " didn't match any item" )
                        .tooltip( "open" );
                    this.element.val( "" );
                    this._delay(function() {
                        this.input.tooltip( "close" ).attr( "title", "" );
                    }, 2500 );
                    this.input.autocomplete( "instance" ).term = "";
                    //limpa os campos 
                    this._servicoClearFunction();
                },
  
                _destroy: function() {
                    this.wrapper.remove();
                    this.element.show();
                }
            });
  
            $( "#servico_id" ).combobox();
            
        } );
     </script>


    

    <script>
            
            function finalizarSend(val) {                
                var atendimento = val.elements['total_atendimento'].value
                var pagamento = val.elements['total_pagamento'].value
                var dif = atendimento - pagamento ;                
                if(dif > 0.09) {
                    alert('O valor total do atendimento que é R$' + atendimento + 
                    ' não confere com o do pagamento que é R$' + pagamento  );
                    return false;
                }
                return true;
            }

            function servicoFunction() {
 
                var form = document.forms["form-servico"] ;                
                var servico =  form["servico_id"].options[form["servico_id"].selectedIndex] ;            
                var quantidade = parseInt( form["quantidade"].value );                
                var desconto_maximo = parseInt(  servico.dataset.maximo );                
                var valor = parseFloat(  servico.getAttribute('label') );
                form["desconto"].max = ( desconto_maximo * valor / 100); 
                form["acrescimo"].max = valor ;   
                //form["servico_id"].value = servico.value ; 
                if( form["desconto"].value == ''){form["desconto"].value = 0.0;}                   
                var desconto =  parseFloat( form["desconto"].value) ;                           
                if(form["acrescimo"].value == ''){form["acrescimo"].value = 0.0;} 
                var acrescimo = parseFloat(  form["acrescimo"].value );
                var valor_unitario = valor - desconto + acrescimo ;  
                var valor_total = valor_unitario * quantidade; 
                console.log('iniciou servico , quantidade: ' + quantidade + ', desconto_maximo ' + desconto_maximo 
                + ', valor: ' + valor + ', acrescimo: ' + acrescimo + ', valor_unitario: ' + valor_unitario + ', valor_total: ' + valor_total   );          
                form["valor_servico_unitario"].value = valor_unitario;
                form["valor_servico_total"].value = valor_total;





  /*              
                var form = document.forms["form-servico"] ;
                var servico = document.getElementById('div-form-servico-servico').getElementsByClassName("es-visible selected")[0] ;                 
                var quantidade = parseInt( form["quantidade"].value );                
                var desconto_maximo = parseInt(  servico.dataset.maximo );                
                var valor = parseFloat(  servico.getAttribute('label') );
                form["desconto"].max = ( desconto_maximo * valor / 100); 
                form["acrescimo"].max = valor ;   
                form["servico_id"].value = servico.value ; 

                if( form["desconto"].value == ''){form["desconto"].value = 0.0;}                   
                var desconto =  parseFloat( form["desconto"].value) ;                           
                if(form["acrescimo"].value == ''){form["acrescimo"].value = 0.0;}  

                var acrescimo = parseFloat(  form["acrescimo"].value );
                var valor_unitario = valor - desconto + acrescimo ;  
                var valor_total = valor_unitario * quantidade;          
                form["valor-servico-unitario"].value = valor_unitario;
                form["valor-servico-total"].value = valor_total;

                //var max = parseFloat( form.elements['servico_id'].options[form.elements['servico_id'].selectedIndex].text );            
                //var quantidade = parseInt(form.elements['quantidade'].value);
                //alert(quantidade);
                //var desconto_maximo =  parseInt(form.elements['servico_id'].options[form.elements['servico_id'].selectedIndex].dataset['maximo']);
                
            
                //form.elements['desconto'].max = ( desconto_maximo * max / 100); 
               // form.elements['acrescimo'].max = max ;   
                //if(form.elements['desconto'].value == '')
                    //form.elements['desconto'].value = 0.0;
                //var desconto =  parseFloat( form.elements['desconto'].value) ;            
                //if(form.elements['acrescimo'].value == '')
                    //form.elements['acrescimo'].value = 0.0;

                //var acrescimo = parseFloat( form.elements['acrescimo'].value );
                //var valor_unitario = max - desconto + acrescimo ;  
                //var valor_total = valor_unitario * quantidade;           
                //form.elements['valor-servico-unitario'].value = valor_unitario;
                //form.elements['valor-produto-total'].value = valor_total;
                //var max = val.options[val.selectedIndex].text;
                //val.form.elements['desconto'].max = (4 * max / 5 ); 

*/



 //var max = parseFloat( produto.getAttribute('label') );
               // var max =  document.getElementsByClassName("es-visible")[0].dataset.maximo;
               // alert(max);
               // var max =  document.getElementsByClassName("es-visible")[0].getAttribute('label');
               // alert(max);                
                //var max = parseFloat( form.attr('label') );
                //var max = parseFloat(  document.getElementsByClassName("es-visible")[0].attr('label') );
                //var quantidade = parseInt( document.forms["form-produto"]["quantidade"].value );
                //var max = parseFloat(  document.getElementsByClassName("es-visible")[0].attr('data-maximo') );
                //var desconto_maximo = parseInt( form.attr('data-maximo') );
                //document.forms["form-produto"]["desconto"].max = ( desconto_maximo * max / 100); 
                //var max = parseFloat( form.elements['produto_id'].options[form.elements['produto_id'].selectedIndex].text );            
                //var quantidade = parseInt(form.elements['quantidade'].value);
                //var desconto_maximo =  parseInt(form.elements['produto_id'].options[form.elements['produto_id'].selectedIndex].dataset['maximo']);
                //form.elements['desconto'].max = ( desconto_maximo * max / 100); 





            }








            function myFunction(val) {                            
                if(val == 'credito'){
                                document.getElementById("form-operadora").hidden = false ;
                                document.getElementById("form-parcelas").hidden = false ;
                                document.getElementById("parcelas").selectedIndex = 1 ;
                                document.getElementById("form-bandeira").hidden = false ;
                                document.getElementById("operadora_id").required = true ;
                                document.getElementById("parcelas").required = true ;
                                document.getElementById("bandeira").required = true ;
                }
                if(val == 'debito'){
                                document.getElementById("form-operadora").hidden = false ;
                                document.getElementById("form-parcelas").hidden = true ;
                                document.getElementById("form-bandeira").hidden = false ;
                                document.getElementById("operadora_id").required = true ;
                                document.getElementById("parcelas").required = false ;
                                document.getElementById("bandeira").required = true ;
                }                           
                if(val == 'dinheiro' ){
                                document.getElementById("form-operadora").hidden = true ;
                                document.getElementById("form-parcelas").hidden = true ;
                                document.getElementById("form-bandeira").hidden = true ;
                                document.getElementById("operadora_id").required = false ;
                                document.getElementById("parcelas").required = false ;
                                document.getElementById("bandeira").required = false ;
                }
                if(val == 'Transferência Bancária' ){
                                document.getElementById("form-operadora").hidden = true ;
                                document.getElementById("form-parcelas").hidden = true ;
                                document.getElementById("form-bandeira").hidden = true ;

                                document.getElementById("operadora_id").required = false ;
                                document.getElementById("parcelas").required = false ;
                                document.getElementById("bandeira").required = false ;
                }
                if( val == 'Pic Pay'){
                                document.getElementById("form-operadora").hidden = true ;
                                document.getElementById("form-parcelas").hidden = true ;
                                document.getElementById("form-bandeira").hidden = true ;

                                document.getElementById("operadora_id").required = false ;
                                document.getElementById("parcelas").required = false ;
                                document.getElementById("bandeira").required = false ;
                }
                if(val == 'cheque'){
                                document.getElementById("form-operadora").hidden = true ;
                                document.getElementById("form-parcelas").hidden = true ;
                                document.getElementById("form-bandeira").hidden = true ;

                                document.getElementById("operadora_id").required = false ;
                                document.getElementById("parcelas").required = false ;
                                document.getElementById("bandeira").required = false ;
                }
                if(val == 'fiado'){
                                document.getElementById("form-operadora").hidden = true ;
                                document.getElementById("form-parcelas").hidden = true ;
                                document.getElementById("form-bandeira").hidden = true ;

                                document.getElementById("operadora_id").required = false ;
                                document.getElementById("parcelas").required = false ;
                                document.getElementById("bandeira").required = false ;
                }            
            }	
            
        </script>	

















        

    <script>
         //--------------------------------------------------------------------------------------------------------------------------------------
        //      COMBO BOX DO FUNCIONARIO
        //--------------------------------------------------------------------------------------------------------------------------------------
        
        $( function() {
            $.widget( "custom.combobox", {
                
                _create: function() {
                    this.wrapper = $( "<span>" )
                        .addClass( "custom-combobox" )
                        .insertAfter( this.element );  
                    this.element.hide();
                    this._createAutocomplete();
                    this._createShowAllButton();
                },
  
                _createAutocomplete: function() {
                    var selected = this.element.children( ":selected" ),
                    value = selected.val() ? selected.text() : "";
                    this.input = $( "<input>" )
                        .appendTo( this.wrapper )
                        .val( value )
                        .attr( "title", "" )
                        .attr( "style", "width: 85%;     display: inline;" )
                        .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left form-control" )
                        .autocomplete({
                            delay: 0,
                            minLength: 0,
                            source: $.proxy( this, "_source" )
                        })
                        .tooltip({
                            classes: {
                                "ui-tooltip": "ui-state-highlight"
                            }
                        });
  
                    this._on( this.input, {
                        autocompleteselect: function( event, ui ) {
                            ui.item.option.selected = true;
                            this._trigger( "select", event, {
                                item: ui.item.option
                            });
                        },  
                        autocompletechange: "_removeIfInvalid"  
                    });
                },
  
                _createShowAllButton: function() {
                    var input = this.input,
                        wasOpen = false;
                    $( "<a>" )
                        .attr( "tabIndex", -1 )
                        .attr( "title", "Show All Items" )
                        .tooltip()
                        .appendTo( this.wrapper )
                        .button({
                            icons: {
                                primary: "ui-icon-triangle-1-s"
                            },
                            text: false
                        })
                        .removeClass( "ui-corner-all" )
                        .addClass( "custom-combobox-toggle ui-corner-right form-control" )
                        .on( "mousedown", function() {
                             wasOpen = input.autocomplete( "widget" ).is( ":visible" );
                        })
                        .on( "click", function() {
                            input.trigger( "focus" );  
                            // Close if already visible
                            if ( wasOpen ) {
                                return;
                            }  
                            // Pass empty string as value to search for, displaying all results
                            input.autocomplete( "search", "" );
                        });
                },
  
                _source: function( request, response ) {
                    var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                    response( this.element.children( "option" ).map(function() {
                        var text = $( this ).text();
                        if ( this.value && ( !request.term || matcher.test(text) ) )
                            return {
                                label: text,
                                value: text,
                                option: this
                            };
                    }) );
                },

        

                _removeIfInvalid: function( event, ui ) {
                    // Selected an item, nothing to do
                    if ( ui.item ) {
                        return;
                    } 
                    // Search for a match (case-insensitive)
                    var value = this.input.val(),
                    valueLowerCase = value.toLowerCase(),
                    valid = false;
                    this.element.children( "option" ).each(function() {
                        if ( $( this ).text().toLowerCase() === valueLowerCase ) {
                            this.selected = valid = true;
                            return false;
                        }
                    });  
                    // Found a match, nothing to do
                    if ( valid ) {
                        return;
                    }  
                    // Remove invalid value
                    this.input
                        .val( "" )
                        .attr( "title", value + " didn't match any item" )
                        .tooltip( "open" );
                    this.element.val( "" );
                    this._delay(function() {
                        this.input.tooltip( "close" ).attr( "title", "" );
                    }, 2500 );
                    this.input.autocomplete( "instance" ).term = "";
                },
  
                _destroy: function() {
                    this.wrapper.remove();
                    this.element.show();
                }
            });
  
           
            $( "#funcionario_id" ).combobox();
            
        } );
     </script>






@endpush
