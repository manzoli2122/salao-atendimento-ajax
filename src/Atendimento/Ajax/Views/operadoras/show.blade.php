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
                           
                            <div class="col-12 col-sm-4 dado">
                                <h4 style="text-align:left;"> {{ number_format($model->porcentagem_credito, 2)}}% para Credito </h4>                
                            </div> 
                            <div class="col-12 col-sm-4 dado">
                                <h4 style="text-align:left;"> {{ number_format($model->porcentagem_credito_parcelado, 2)}}% para Credito Parcelado</h4>
                            </div>
                            <div class="col-12 col-sm-4 dado">
                                <h4 style="text-align:left;">  {{ number_format($model->porcentagem_debito, 2) }}% para Debito</h4>
                            </div>
                            <div class="col-12 col-sm-4 dado">
                            <h4 style="text-align:left;"> Repasse debito: {{$model->repasse_debito_dias}} dias </h4>
                            </div>
                            <div class="col-12 col-sm-4 dado">
                                <h4 style="text-align:left;"> Máximo de parcelas: {{$model->max_parcelas}}</h4>
                            </div>
                        </section>
    
                    </div>
                    <div class="box-footer align-right">
                        @permissao('operadoras-soft-delete')
                            <button type="button" class="btn btn-danger"  onclick="modelDelete( {{$model->id}} , '{{ route('operadoras.ajax.index') }}')" remover-apos-excluir>
                                <i class="fa fa-times"></i> Excluir
                            </button>
                        @endpermissao
                        @permissao('operadoras-editar')
                            <button type="button" class="btn btn-success"  onclick="modelEditar( {{$model->id}} , '{{ route('operadoras.ajax.index') }}' )" remover-apos-excluir  title="Editar">
                                <i class="fa fa-pencil"></i> Editar
                            </button>                        
                        @endpermissao
                        <button type="button" class="btn btn-default"  onclick="modelVoltarIndex()" > <i class="fa fa-reply"></i> Voltar </button>            
                    </div>
                </div>
            </div>
        </div>
    </section>
