<section class="content-header">
        <h1>
            <span id="div-titulo-pagina">Editar Operadora</span>
        </h1>
    </section>            
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success" id="div-box">
                    <form method="post" action="{{route('operadoras.ajax.update', $model->id)}}" id="form-model">            
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="PATCH">
                        @include('cadastroAjax::operadoras._form')                        
                    </form>
                    <div class="box-footer align-right">  
                        <button type="button" class="btn btn-default"  onclick="modelVoltarIndex()" > <i class="fa fa-reply"></i> Voltar </button> 
                        <button class="btn btn-success" onclick="modelUpdateAjax( {{$model->id}}  , '{{ route('operadoras.ajax.index') }}' )" ><i class="fa fa-check"></i> Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
