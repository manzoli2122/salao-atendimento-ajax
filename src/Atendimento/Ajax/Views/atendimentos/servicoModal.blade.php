<div class="modal fade" id="servicoModal" role="dialog" aria-labelledby="servicoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title text-center"><b>ADICIONAR SERVIÇO</b></h2>
            </div>
            <div class="modal-body">                     
                <form id="form-servico" id="form-servico" name="form-servico" method="POST" action="#"  class="form form-search form-ds form-servico ui-front">     
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4><label for="funcionario_id" style="display: block;">FUNCIONÁRIO:</label></h4>
                                <select id="funcionario_id" class="form-control" style="width: 100%" name="funcionario_id" required>
                                    <option value="">Selecione o Funcionário</option>
                                    @foreach ($funcionarios as $key )
                                    <option  data-nome="{{$key->apelido}}"  value="{{ $key->id }}">  {{ $key->name }}  </option>
                                    @endforeach
                                </select> 
                            </div>

                            <div id="div-form-servico-servico" class="form-group">
                                <h4><label for="servico_id" style="display: block;">SERVIÇO:</label></h4>
                                <select id="servico_id" class="form-control" name="servico_id" style="width: 100%" required >                                   
                                    <option    value="">Selecione o Serviço</option>  
                                    @foreach ($servicos as $key )
                                        <option data-nome="{{$key->nome}}" data-valor="{{$key->valor}}" data-maximo="{{$key->desconto_maximo}}" value="{{$key->id}}">
                                            {{ $key->nome }}  R$ {{  number_format( $key->valor , 2 ,',', '') }}
                                        </option>
                                    @endforeach
                                </select> 
                            </div>

                            <div class="form-group">                                
                                <h4><label for="desconto" style="display: block;">DESCONTO/UNID.:</label></h4>
                                <input placeholder="desconto" step="0.01" class="form-control" onchange="servicoFunction()" required="" min="0" name="desconto" value="0" type="number">
                            </div>
                            <div class="form-group">
                                <h4><label for="quantidade" style="display: block;">QUANTIDADE:</label></h4>
                                <input placeholder="quantidade" onchange="servicoFunction()" class="form-control" required="" min="1" max="10" name="quantidade" value="1" type="number">
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="form-group">
                                <h4><label for="cliente_id"  style="display: block;" >CLIENTE:</label></h4>
                                <select class="form-control" name="cliente_id" required>
                                    <option value="">Selecione o Cliente</option>
                                    @foreach ($clientes as $key )
                                        <option value="{{ $key->id }}"  {{$key->id == $cliente->id ? 'selected' : ''}}>  {{ $key->name }}   </option>
                                    @endforeach
                                </select> 
                            </div>
                            <div class="form-group">                        
                                <h4><label for="acrescimo"  style="display: block;" >ACRESCIMO/UNID:</label></h4>
                                <input placeholder="acrescimo" onchange="servicoFunction()" step="0.01" class="form-control" required="" min="0" name="acrescimo" value="0" type="number">
                            </div>
                            <div class="form-group">
                                <h4><label for="valor-servico-unitario"  style="display: block;">VALOR UNITÁRIO</label></h4>
                                <input disabled="" class="form-control col-2" step="0.01" name="valor_servico_unitario" value="0.0" type="number">
                            </div>
                            <div class="form-group">
                                <h4><label for="valor-servico-total"  style="display: block;">VALOR TOTAL</label></h4>
                                <input style="color:red; font-size:20px; font-weight: bold;" disabled="" class="form-control" step="0.01" name="valor_servico_total" value="0.0" type="number" >
                            </div>
                        </div>
                    </div>                         
                </form>  
                <div class="form-group align-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin-right:60px;" >
                        <i class="fa fa-times"> FECHAR </i>
                    </button>
                    <button class="btn btn-success" onclick="AdicionarServico()" >
                        <i class="fa fa-check"></i> ADICIONAR SERVIÇO  
                    </button>
                </div>                
            </div>           
        </div>
    </div>
</div>