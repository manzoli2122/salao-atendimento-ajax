<div class="box-body">	
     <div class="row">
        <div class="col-md-6">

            <div class="form-group {{ $errors->has('nome') ? 'has-error' : ''}}">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" placeholder="Nome do Produto"
                    {{$model->id and false  ? 'readonly' : '' }}
                    value="{{ isset( $request ) ? $request->input('nome') : $model->nome}}"   >
                {!! $errors->first('nome', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('valor') ? 'has-error' : ''}}">
                <label for="valor">Valor</label>
                <input type="number" step="0.01" class="form-control" name="valor" placeholder="Valor"
                    value="{{ isset( $request ) ? $request->input('valor') : $model->valor}}">
                {!! $errors->first('valor', '<p class="help-block">:message</p>') !!}
            </div>               
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('desconto_maximo') ? 'has-error' : ''}}">
                <label for="desconto_maximo">Desconto máximo (%)</label>
                <input type="number" step="0.01" class="form-control" name="desconto_maximo" placeholder="Desconto máximo (%)"
                    value="{{ isset( $request ) ? $request->input('desconto_maximo') : $model->desconto_maximo }}">
                {!! $errors->first('desconto_maximo', '<p class="help-block">:message</p>') !!}
            </div>
        </div> 
        <div class="col-md-12">
            <div class="form-group {{ $errors->has('observacoes') ? 'has-error' : ''}}">
                <label for="observacoes">Observações</label>
                <input type="text" class="form-control" name="observacoes" placeholder="observacoes"
                    value="{{ isset( $request ) ? $request->input('observacoes') : $model->observacoes}}">
                {!! $errors->first('observacoes', '<p class="help-block">:message</p>') !!}
            </div>
        </div>                    
    </div> 
 </div>      