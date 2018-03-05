<div class="modal fade" id="produtoModal"  role="dialog" aria-labelledby="produtoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title text-center"><b>ADICIONAR PRODUTO</b></h2>
            </div>
            <div class="modal-body">   
                <form id="form-produto" name="form-produto" class="form form-search form-ds form-produto ui-front" method="post" action="#" >
                                     
                    <input name="cliente_id" value="{{$cliente->id}}" type="hidden">                     
                    <div class="row">
                        <div class="col-md-6">
                            <div id="div-form-produto-produto" class="form-group" >
                                <h4><label  for="produto_id" style="display: block;" >Produto:</label></h4>
                                <select id="produto_id" class="form-control produto_id_select" name="produto_id" required style="width: 100%"> 
                                        <option    value="">Selecione o Produto</option>                                      
                                        @foreach ($produtos as $key )
                                        <option data-nome="{{$key->nome}}" data-valor="{{ $key->valor }}" data-maximo="{{$key->desconto_maximo}}"  value="{{ $key->id }}">
                                            {{ $key->nome }}  R${{ number_format($key->valor, 2 ,',', '') }}  
                                        </option>
                                        @endforeach
                                </select>                                 
                            </div>

                            <div class="form-group">
                                <h4><label for="desconto" style="display: block;" >Desconto/Unid.:</label></h4>
                                <input placeholder="desconto" step="0.01" class="form-control" required="" min="0" onchange="produtoFunction()" name="desconto" value="0" type="number">
                            </div>
                            <div class="form-group">                        
                                <h4><label for="quantidade" style="display: block;" >Quantidade:</label></h4>
                                <input placeholder="quantidade" class="form-control" required="" min="1" max="10" onchange="produtoFunction()" name="quantidade" value="1" type="number">
                            </div>
                        </div>
                        <div class="col-md-6">                           
                            <div class="form-group">                        
                                <h4><label for="acrescimo" style="display: block;" >Acrescimo/Unid:</label></h4>
                                <input placeholder="acrescimo" step="0.01" class="form-control" required="" min="0" onchange="produtoFunction()" name="acrescimo" value="0" type="number">
                            </div>
                            <div class="form-group">
                                <h4><label for="valor_produto_unitario" style="display: block;" >Valor Unitário</label></h4>
                                <input disabled="" class="form-control" step="0.01" name="valor_produto_unitario" value="0.0" type="number">
                            </div>
                             <div class="form-group">                        
                                <h4><label for="valor_produto_total" style="display: block;" >Valor Total</label></h4>
                                <input style="color:red; font-size:20px; font-weight: bold;" disabled="" class="form-control" step="0.01" name="valor_produto_total" value="0.0" type="number">
                            </div>
                         </div>                    
                    </div>
                                                       
                </form>   
                <div class="form-group align-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin-right:60px;" >
                        <i class="fa fa-times"></i> FECHAR
                    </button>
                    <button class="btn btn-success" onclick="AdicionarProduto()" >
                        <i class="fa fa-check"></i> ADICIONAR PRODUTO 
                    </button> 
                </div>                       
            </div>            
        </div>
    </div>
</div>