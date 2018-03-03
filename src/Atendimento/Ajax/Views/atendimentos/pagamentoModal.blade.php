<div class="modal fade" id="pagamentoModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title text-center"> <b> ADICIONAR PAGAMENTO </b></h2>                
            </div>
            <div class="modal-body">   
                <form id="form-pagamento" name="form-pagamento" class="form form-search form-ds" method="post" action="#" >
                       
                    <input name="cliente_id" value="{{$cliente->id}}" type="hidden">                 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4><label for="formaPagamento" style="display: block;">FORMA DE PAGAMENTO:</label></h4>
                                <select class="form-control" name="formaPagamento" required onchange="formaPagamentoDisplay(this.value)">
                                        <option value="">Selecione a forma de pagamento</option>                               
                                        <option value="dinheiro"> Dinheiro  </option>
                                        <option value="Pic Pay"> Pic Pay  </option>
                                        <option value="Transferência Bancária"> Transferência Bancária  </option>
                                        <option value="credito"> Credito  </option>
                                        <option value="debito"> Debito  </option>
                                        <option value="cheque"> Cheque  </option>    
                                        <option value="fiado"> Fiado  </option>                           
                                </select> 
                            </div>
                            <div class="form-group" id="form-operadora" hidden>
                                <h4> <label for="operadora_id" style="display: block;">OPERADORA:</label> </h4>
                                <select class="form-control" id="operadora_id" name="operadora_id" >
                                        <option value="">Selecione o Operadora</option>
                                        @foreach (Manzoli2122\Salao\Cadastro\Models\Operadora::get() as $key )
                                        <option value="{{ $key->id }}">  {{ $key->nome }}  </option>
                                        @endforeach
                                </select> 
                            </div>
                            <div class="form-group" id="form-parcelas" hidden>
                                <h4><label for="parcelas" style="display: block;">PARCELAS:</label></h4>
                                <select class="form-control" id="parcelas" name="parcelas" >
                                        <option value="">Selecione as parcelas</option>                               
                                        <option value="1"> 1  </option>
                                        <option value="2"> 2  </option>
                                        <option value="3"> 3  </option>                               
                                </select> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"  >
                                <h4><label for="valor" class="col-form-label" style="display: block;">VALOR:</label></h4>
                                <input style="color:red; font-size:20px; font-weight: bold;" placeholder="valor" id="valor_pagamento" step="0.01" class="form-control" required="" min="0" name="valor" value="0" type="number">
                            </div>
                            <div class="form-group" id="form-bandeira" hidden>
                                <h4><label for="bandeira" style="display: block;">BANDEIRA:</label></h4>
                                <select class="form-control"  id="bandeira" name="bandeira" >
                                        <option value="">Selecione o bandeira</option>
                                        <option value="banescard">  Banescard </option>
                                        <option value="visa">  Visa </option>
                                        <option value="mastercard">  MasterCard </option>
                                        <option value="Maestro">  Maestro </option>
                                        <option value="Elo">  Elo </option>
                                        <option value="outras">  Outras </option>                                    
                                </select> 
                            </div>
                            <div class="form-group">
                                <h4><label for="observacoes" style="display: block;">OBSERVAÇÕES:</label></h4>
                                <input placeholder="observacoes" class="form-control" name="observacoes" type="text">                                
                            </div>
                        </div>
                    </div>
                     
                </form>
                <div class="form-group align-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin-right:60px;" >
                        <i class="fa fa-times"></i> FECHAR
                    </button>
                    <button class="btn btn-success" onclick="AdicionarPagamento()" >
                        <i class="fa fa-check"></i> ADICIONAR PAGAMENTO 
                    </button>
                </div>      
            </div>            
        </div>
    </div>
</div>
