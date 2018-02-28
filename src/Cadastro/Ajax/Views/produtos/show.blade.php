<section class="content-header">
    <h1>
        <span id="div-titulo-pagina">{{ $model->nome }}</span>
    </h1>
</section>
        
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success" id="div-box"> 
                <div class="box-body">            
                    <div class="alert alert-default alert-dismissible align-center invisivel" id="divAlerta">
                        <label>Excluído</label>
                    </div>			
                    <section class="row text-center dados">    
                                
                        <div class="col-12 col-sm-6 dado">
                            <h4 style="text-align:left;">Valor: R$ {{number_format($model->valor , 2 ,',', '')}}</h4>
                        </div> 
                        <div class="col-12 col-sm-6 dado">
                            <h4 style="text-align:left;"> Desconto Máximo: {{$model->desconto_maximo}}% </h4>
                        </div>
                        <div class="col-12 col-sm-12 dado">
                            <h4 style="text-align:left;">Observações: {{$model->observacoes}} </h4>
                        </div>
                    </section>
                </div>
                <div class="box-footer align-right">
                    @permissao('produtos-soft-delete')
                        <button type="button" class="btn btn-danger"  onclick="modelDelete( {{$model->id}} , '{{ route('produtos.ajax.index') }}')" remover-apos-excluir>
                            <i class="fa fa-times"></i> Excluir
                        </button>
                    @endpermissao
                    @permissao('produtos-editar')
                        <button type="button" class="btn btn-success"  onclick="modelEditar( {{$model->id}} , '{{ route('produtos.ajax.index') }}' )" remover-apos-excluir  title="Editar">
                            <i class="fa fa-pencil"></i> Editar
                        </button>                        
                    @endpermissao
                    <button type="button" class="btn btn-default"  onclick="modelVoltarIndex()" > <i class="fa fa-reply"></i> Voltar </button>            
                </div>
            </div>
        </div>
    </div>
</section>
        
        
        
        