<section class="content-header">
    <h1>
        <span id="div-titulo-pagina">Adicionar Serviço   </span>
    </h1>
</section>            
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success" id="div-box">
                <form method="post" action="{{route('servicos.ajax.store')}}" id="form-model">            
                    {{csrf_field()}}
                    @include('cadastroAjax::servicos._form')
                </form>

                <div class="box-footer align-right">
                    <button type="button" class="btn btn-default"  onclick="modelVoltarIndex()" > <i class="fa fa-reply"></i> Voltar </button>
                    <button class="btn btn-success" onclick="modelStore( '{{ route('servicos.ajax.store') }}' , null , function(){comboboxFunction();} )" ><i class="fa fa-check"></i> Salvar</button> 
                </div>

            </div>
        </div>
    </div>
</section>