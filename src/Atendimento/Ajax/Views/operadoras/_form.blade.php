<div class="box-body">	
     <div class="row">
        <div class="col-md-6">

            <div class="form-group {{ $errors->has('nome') ? 'has-error' : ''}}">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" placeholder="Nome da Operadora de cartão"
                    value="{{ isset( $request ) ? $request->input('nome') : $model->nome}}">
                {!! $errors->first('nome', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group {{ $errors->has('porcentagem_credito') ? 'has-error' : ''}}">
                <label for="porcentagem_credito">Taxa credito</label>
                <input type="number" step="0.01" class="form-control" name="porcentagem_credito" placeholder="Taxa credito"
                    value="{{ isset( $request ) ? $request->input('porcentagem_credito') : $model->porcentagem_credito}}">
                {!! $errors->first('porcentagem_credito', '<p class="help-block">:message</p>') !!}
            </div>  

            <div class="form-group {{ $errors->has('max_parcelas') ? 'has-error' : ''}}">
                <label for="max_parcelas">Nº max. de parcelas</label>
                <input type="number" min="1" max="12" class="form-control" name="max_parcelas" placeholder="Nº max. de parcelas"
                    value="{{ isset( $request ) ? $request->input('max_parcelas') : $model->max_parcelas}}">
                {!! $errors->first('max_parcelas', '<p class="help-block">:message</p>') !!}
            </div>

        </div>
        <div class="col-md-6">

            <div class="form-group {{ $errors->has('porcentagem_credito_parcelado') ? 'has-error' : ''}}">
                <label for="porcentagem_credito_parcelado">Taxa credito parcelado</label>
                <input type="number" step="0.01" class="form-control" name="porcentagem_credito_parcelado" placeholder="Taxa credito parcelado"
                    value="{{ isset( $request ) ? $request->input('porcentagem_credito_parcelado') : $model->porcentagem_credito_parcelado}}">
                {!! $errors->first('porcentagem_credito_parcelado', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group {{ $errors->has('porcentagem_debito') ? 'has-error' : ''}}">
                <label for="porcentagem_debito">Taxa debito</label>
                <input type="number" step="0.01" class="form-control" name="porcentagem_debito" placeholder="Taxa debito"
                    value="{{ isset( $request ) ? $request->input('porcentagem_debito') : $model->porcentagem_debito}}">
                {!! $errors->first('porcentagem_debito', '<p class="help-block">:message</p>') !!}
            </div>     

            <div class="form-group {{ $errors->has('repasse_debito_dias') ? 'has-error' : ''}}">
                <label for="repasse_debito_dias">Repasse debito</label>
                <input type="number" min="0" max="31" class="form-control" name="repasse_debito_dias" placeholder="Quantidade de dias para o repasse"
                    value="{{ isset( $request ) ? $request->input('repasse_debito_dias') : $model->repasse_debito_dias}}">
                {!! $errors->first('repasse_debito_dias', '<p class="help-block">:message</p>') !!}
            </div>
            
        </div> 
    </div> 
 </div>      