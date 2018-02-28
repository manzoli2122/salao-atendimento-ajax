@extends( Config::get('app.templateMaster' , 'templates.templateMaster')  )
	
@section( Config::get('app.templateMasterContentTitulo' , 'titulo-page')  )
	Atendimentos do dia {{ today()->format('d/m/Y')}} 
@endsection

@section( Config::get('app.templateMasterContent' , 'content')  )
 	
	<!--div class="col-xs-12">
		<div class="box">									
			<div class="box-body table-responsive no-padding"-->

	<!--div class="col-xs-12">
		<div class="box box-success">	
			<div class="box-body">

				<table class="table table-hover table-striped table-hover table-responsive">
					<tr>
						<th>Cliente</th>
						<th>Valor dos Serviços</th>
						<th>Valor dos Produtos</th>	
						<th>Valor Total</th>					
						<th>Ações</th>
					</tr>
					@forelse($models as $model)				
					<tr>
						<td> {{ $model->cliente->name }}  </td>			
						<td> R$ {{number_format($model->valorServicos(), 2 , ',' , '' )}} </td>
						<td> R$ {{number_format($model->valorProdutos(), 2 , ',' , '' )}} </td>			
						<td> R$ {{number_format($model->valor, 2 , ',' , '' )}} </td>
						<td>
							@permissao('atendimentos')								
								<a class="btn btn-success btn-sm" href='{{route("atendimentos.show", $model->id)}}'>
									<i class="fa fa-eye" aria-hidden="true"></i>Exibir</a>	
								 <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#alterarDataModal{{$model->id}}" > 
									Alterar Data
								</a>							
							@endpermissao																
											
							@permissao('atendimentos-soft-delete')			
								<a class="btn btn-danger btn-sm"  href="javascript:void(0);" onclick="$(this).find('form').submit();" >
									<form  method="post" action="{{route('atendimentos.destroySoft', $model->id)}}" onsubmit="return  ApagarAtendimento(this)">
										{{csrf_field()}}    
										<input name="_method" value="DELETE" type="hidden">                    
									</form>  
									<i class="fa fa-trash" aria-hidden="true"></i>Apagar</a>													
							@endpermissao											
						</td>
					</tr>
					@empty					
					@endforelse					
				</table>
			</div>					
		</div>				
	</div-->
	@forelse($models as $model)	
			@include('atendimento::atendimentos.modalAterarData')
	@empty									
	@endforelse


</div>
<!--h2 class="page-header">AdminLTE Custom Tabs</h2-->
<div class="row">

<div class="col-md-12">
    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
			<li class="active"><a href="#tab_1" data-toggle="tab">Atendimentos</a></li>
			@foreach (Manzoli2122\Salao\Atendimento\Models\Funcionario::funcionarios() as $key )
				<li><a href="#funcionario_{{$key->id}}" data-toggle="tab"> {{ $key->apelido }}</a></li>
			@endforeach			

            <!--li><a href="#tab_2" data-toggle="tab">Serviços Realizados</a></li-->
            
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
				<table class="table table-hover table-striped table-hover table-responsive">
					<tr>
						<th>Cliente</th>
						<th>Valor dos Serviços</th>
						<th>Valor dos Produtos</th>	
						<th>Valor Total</th>					
					<th>Ações</th>
					</tr>
					@forelse($caixa->atendimentos as $model)				
					<tr>
						<td> {{ $model->cliente->name }}  </td>			
						<td> R$ {{number_format($model->valorServicos(), 2 , ',' , '' )}} </td>
						<td> R$ {{number_format($model->valorProdutos(), 2 , ',' , '' )}} </td>			
						<td> R$ {{number_format($model->valor, 2 , ',' , '' )}} </td>
						<td>
							@permissao('atendimentos')								
								<a class="btn btn-success btn-sm" href='{{route("atendimentos.show", $model->id)}}'>
									<i class="fa fa-eye" aria-hidden="true"></i>Exibir</a>	
								 <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#alterarDataModal{{$model->id}}" > 
									Alterar Data
								</a>							
							@endpermissao																
													
							@permissao('atendimentos-soft-delete')			
								<a class="btn btn-danger btn-sm"  href="javascript:void(0);" onclick="$(this).find('form').submit();" >
									<form  method="post" action="{{route('atendimentos.destroySoft', $model->id)}}" onsubmit="return  ApagarAtendimento(this)">
										{{csrf_field()}}    
										<input name="_method" value="DELETE" type="hidden">                    
									</form>  
									<i class="fa fa-trash" aria-hidden="true"></i>Apagar</a>													
							@endpermissao											
						</td>
					</tr>
					@empty					
					@endforelse					
				</table>
                	
			</div>
			


			@foreach (Manzoli2122\Salao\Atendimento\Models\Funcionario::funcionarios() as $key )
			<div class="tab-pane" id="funcionario_{{$key->id}}">
				

					<table class="table table-hover table-striped table-hover table-responsive">
							<tr>
								<th>Cliente</th>
								<th>Funcionário</th>
								<th>Valor dos Produtos</th>	
								<th>Valor Total</th>
							</tr>
							@forelse($caixa->atendimentosFuncionario($key->id) as $model)
								<tr>
									<td> {{ $model->cliente->name }}  </td>			
									<td> {{ $model->funcionario->name }} </td>
									<td> {{ $model->servico->nome }} </td>			
									<td> R$ {{number_format($model->valor, 2 , ',' , '' )}} </td>								
								</tr>
							@empty					
							@endforelse										
						</table>
			</div>
			@endforeach











            <!-- /.tab-pane -->
            <!--div class="tab-pane" id="tab_2">	
					<table class="table table-hover table-striped table-hover table-responsive">
							<tr>
								<th>Cliente</th>
								<th>Funcionário</th>
								<th>Valor dos Produtos</th>	
								<th>Valor Total</th>
							</tr>
							@forelse($models as $model1)							
								@forelse($model1->servicos as $model)
									<tr>
										<td> {{ $model->cliente->name }}  </td>			
										<td> {{ $model->funcionario->name }} </td>
										<td> {{ $model->servico->nome }} </td>			
										<td> R$ {{number_format($model->valor, 2 , ',' , '' )}} </td>								
									</tr>
								@empty					
								@endforelse
							
							@empty					
							@endforelse					
						</table>
			</div-->
			

        <!-- /.tab-pane -->
        </div>
    <!-- /.tab-content -->
    </div>
<!-- nav-tabs-custom -->
</div>




@endsection
		
@push( Config::get('app.templateMasterScript' , 'script')  )
        	<script>$(function(){setTimeout("$('.hide-msg').fadeOut();",5000)});</script>
			<script>
            function ApagarAtendimento(val) {
                return  confirm('Deseja mesmo apagar o Atendimento?'  );                       
            }
		</script>
@endpush
		
@push( Config::get('app.templateMasterCss' , 'css')  )			
			<style type="text/css">
					.btn-sm{
						padding: 1px 10px;
					}
					.pagination{
						margin:0px;
						display: unset;
						font-size:12px;
					}
			</style>
@endpush