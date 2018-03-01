<div class="modal fade" id="servicoModal" tabindex="-1" role="dialog" aria-labelledby="servicoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Adicionar Serviço</h4>
            </div>
            <div class="modal-body">                     
                <form id="form-servico" id="form-servico" name="form-servico" method="POST" action="{{route('atendimentos.adicionarServico')}}"  class="form form-search form-ds form-servico ui-front">
                    {{csrf_field()}}              
                    <input name="atendimento_id" value="{{ $atendimento->id }}" type="hidden">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="funcionario_id" style="display: block;">Funcionário:</label>
                                <select id="funcionario_id" class="form-control" name="funcionario_id" required>
                                    <option value="">Selecione o Funcionário</option>
                                    @foreach (Manzoli2122\Salao\Atendimento\Models\Funcionario::funcionarios() as $key )
                                    <option value="{{ $key->id }}">  {{ $key->name }}  </option>
                                    @endforeach
                                </select> 
                            </div>

                            <div id="div-form-servico-servico" class="form-group">
                                <label for="servico_id" style="display: block;">Serviço:</label>
                                <select id="servico_id" class="form-control" name="servico_id" required >                                   
                                    <option    value="">Selecione o Serviço</option>  
                                    @foreach (Manzoli2122\Salao\Cadastro\Models\Servico::ativo()->orderBy('nome', 'asc')->get() as $key )
                                    <option label="{{$key->valor}}" data-maximo="{{$key->desconto_maximo}}" value="{{$key->id}}">{{ $key->nome }} R$ {{number_format($key->valor, 2 ,',', '')}}</option>
                                    @endforeach
                                </select> 
                            </div>

                            <div class="form-group">                                
                                <label for="desconto">Desconto/Unid.:</label>
                                <input placeholder="desconto" step="0.01" class="form-control" onchange="servicoFunction()" required="" min="0" name="desconto" value="0" type="number">
                            </div>
                            <div class="form-group">
                                <label for="quantidade">Quantidade:</label>
                                <input placeholder="quantidade" onchange="servicoFunction()" class="form-control" required="" min="1" max="10" name="quantidade" value="1" type="number">
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="form-group">
                                <label for="cliente_id">Cliente:</label>
                                <select class="form-control" name="cliente_id" required>
                                        <option value="">Selecione o Cliente</option>
                                        @foreach (Manzoli2122\Salao\Atendimento\Models\Cliente::ativo()->orderBy('name', 'asc')->get() as $key )
                                        <option value="{{ $key->id }}"  {{$key->id == $atendimento->cliente->id ? 'selected' : ''}}>  {{ $key->name }}   </option>
                                        @endforeach
                                </select> 
                            </div>
                            <div class="form-group">                        
                                <label for="acrescimo">Acrescimo/Unid:</label>
                                <input placeholder="acrescimo" onchange="servicoFunction()" step="0.01" class="form-control" required="" min="0" name="acrescimo" value="0" type="number">
                            </div>
                            <div class="form-group">
                                <label for="valor-servico-unitario">Valor Unitário</label>
                                <input disabled="" class="form-control col-2" step="0.01" name="valor_servico_unitario" value="0.0" type="number">
                            </div>
                            <div class="form-group">
                                <label for="valor-servico-total">Valor Total</label>
                                <input disabled="" class="form-control" step="0.01" name="valor_servico_total" value="0.0" type="number">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-md-6">   
                            <!--button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button-->
                        </div>
                        <div class="col-6 col-md-6 ml-auto">
                            <div class="form-group align-right">
                                
                                
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin-right:60px;" >Fechar</button>
                                
                                <input type="submit" value="Enviar" class="btn btn-success">
                            
                            </div>
                        </div>
                    </div>                            
                </form>  
                
                <button class="btn btn-success" onclick="AdicionarServico()" ><i class="fa fa-check"></i> Adicionar Serviço </button>

                
            </div>           
        </div>
    </div>
</div>