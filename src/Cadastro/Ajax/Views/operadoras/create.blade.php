    <section class="content-header">
        <h1>
            <span id="div-titulo-pagina">Adicionar Operadora</span>
        </h1>
    </section>            
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success" id="div-box">
                    <form method="post" action="{{route('operadoras.ajax.store')}}" id="form-model">            
                        {{csrf_field()}}
                        @include('cadastroAjax::operadoras._form')
                    </form>
    
                    <div class="box-footer align-right">
                        <button type="button" class="btn btn-default"  onclick="modelVoltarIndex()" > <i class="fa fa-reply"></i> Voltar </button>
                        <button class="btn btn-success" onclick="modelStore( '{{ route('operadoras.ajax.store') }}' , null  )" ><i class="fa fa-check"></i> Salvar</button> 
                    </div>
    
                </div>
            </div>
        </div>
    </section>