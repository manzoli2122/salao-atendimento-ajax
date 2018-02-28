<div class="box-body">	
     <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('nome') ? 'has-error' : ''}}">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" placeholder="Nome do Serviço"
                    value="{{ isset( $request ) ? $request->input('nome') : $model->nome}}" {{ $model->id and false  ? 'readonly' : '' }}>
                {!! $errors->first('nome', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('valor') ? 'has-error' : ''}}">
                <label for="valor">Valor</label>
                <input type="number" step="0.01" class="form-control" name="valor" placeholder="Valor"
                    value="{{ isset( $request ) ? $request->input('valor') : $model->valor}}">
                {!! $errors->first('valor', '<p class="help-block">:message</p>') !!}
            </div>    
            <div class="form-group {{ $errors->has('porcentagem_funcionario') ? 'has-error' : ''}}">
                <label for="porcentagem_funcionario">Porc. do Funcionário</label>
                <input type="number"  class="form-control" name="porcentagem_funcionario" placeholder="porcentagem funcionario"
                    value="{{ isset( $request ) ? $request->input('porcentagem_funcionario') : $model->porcentagem_funcionario}}">
                {!! $errors->first('porcentagem_funcionario', '<p class="help-block">:message</p>') !!}
            </div>    
        </div>
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('categoria') ? 'has-error' : ''}}">
                <label  for="categoria">Categoria</label>
                 <select id="categoria" class="form-control" name="categoria"  required>
                    <option value="">Selecione a Categoria</option>
                    <option value="Cabelo" {{isset($request) ? $request->input('categoria') == 'Cabelo' ? 'selected' : '' : $model->categoria == 'Cabelo' ? 'selected' : ''}}>  Cabelo  </option>
                    <option value="Depilação" {{isset($request) ? $request->input('categoria') == 'Depilação' ? 'selected' : '' : $model->categoria == 'Depilação' ? 'selected' : ''}} >  Depilação  </option>
                    <option value="Estetica Corporal" {{isset($request) ? $request->input('categoria') == 'Estetica Corporal' ? 'selected' : '' : $model->categoria == 'Estetica Corporal' ? 'selected' : ''}} >  Estetica Corporal  </option>
                    <option value="Estetica Facial" {{isset($request) ? $request->input('categoria') == 'Estetica Facial' ? 'selected' : '' : $model->categoria == 'Estetica Facial' ? 'selected' : ''}} >  Estetica Facial  </option>
                    <option value="Manicure e Pedicure" {{isset($request) ? $request->input('categoria') == 'Manicure e Pedicure' ? 'selected' : '' : $model->categoria == 'Manicure e Pedicure' ? 'selected' : ''}} >  Manicure e Pedicure  </option>
                    <option value="Maquiagem" {{isset($request) ? $request->input('categoria') == 'Maquiagem' ? 'selected' : '' : $model->categoria == 'Maquiagem' ? 'selected' : ''}} >  Maquiagem  </option>
                    <option value="Massagem" {{isset($request) ? $request->input('categoria') == 'Massagem' ? 'selected' : '' : $model->categoria == 'Massagem' ? 'selected' : ''}}>  Massagem  </option>
                    <option value="Podologia" {{isset($request) ? $request->input('categoria') == 'Podologia' ? 'selected' : '' : $model->categoria == 'Podologia' ? 'selected' : ''}}>  Podologia  </option>
                    <option value="Outros" {{isset($request) ? $request->input('categoria') == 'Outros' ? 'selected' : '' : $model->categoria == 'Outros' ? 'selected' : ''}} >  Outros  </option>
                </select> 
                {!! $errors->first('categoria', '<p class="help-block">:message</p>') !!}
            </div> 
            <div class="form-group {{ $errors->has('duracao_aproximada') ? 'has-error' : ''}}">
                <label for="duracao_aproximada">Duração aproximada (min)</label>
                <input type="number"  class="form-control" name="duracao_aproximada" placeholder="duração aproximada (min)"
                    value="{{ isset( $request ) ? $request->input('duracao_aproximada') : $model->duracao_aproximada}}">
                {!! $errors->first('duracao_aproximada', '<p class="help-block">:message</p>') !!}
            </div> 
            <div class="form-group {{ $errors->has('desconto_maximo') ? 'has-error' : ''}}">
                <label for="desconto_maximo">Desconto máximo(%)</label>
                <input type="number" min="0" max="100" class="form-control" name="desconto_maximo" placeholder="desconto máximo(%)"
                    value="{{ isset( $request ) ? $request->input('desconto_maximo') : $model->desconto_maximo}}">
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