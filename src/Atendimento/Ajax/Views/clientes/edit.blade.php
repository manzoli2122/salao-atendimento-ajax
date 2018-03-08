<section class="content-header">
        <h1>
            <span id="div-titulo-pagina">Editar Cliente</span>
        </h1>
    </section>            
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success" id="div-box">
                    <form method="post" action="{{route('clientes.ajax.update', $model->id)}}" id="form-model">            
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="PATCH">
                        @include('atendimentoAjax::clientes._form')
                    </form>
                    
                    <div class="box-footer align-right">  
                        <button type="button" class="btn btn-default"  onclick="modelShow( {{$model->id}} , '{{ route('clientes.ajax.index') }}' , function(data){document.getElementById('div-pagina').innerHTML = data;} )" > <i class="fa fa-reply"></i> Voltar </button> 
                        <button  style="margin-left: 5px;" class="btn btn-success" onclick="modelUpdateAjax( {{$model->id}}  , '{{ route('clientes.ajax.index') }}' )" ><i class="fa fa-check"></i> Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>