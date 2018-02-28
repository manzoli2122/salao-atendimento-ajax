@extends( Config::get('app.templateMasterJson' , 'templates.templateMasterJson')  )

@section( Config::get('app.templateMasterContent' , 'content')  )
<section class="content-header">
	<h1>
		<span id="div-titulo-pagina">Listagem dos Operadoras </span>		
		<small style="float: right;">
			@permissao('operadoras-cadastrar')
				<button class="btn btn-success btn-sm" onclick="modelCreate( '{{ route('operadoras.ajax.create') }}'   )" title="Adicionar uma nova Operadora">
					<i class="fa fa-plus"></i> Cadastrar Operadora 
				</button>	
			@endpermissao		
		</small>
	</h1>
</section>	
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-success" id="div-box"> 
				<div class="box-body" style="padding-top: 5px; padding-bottom: 3px;">
					<table class="table table-bordered table-striped table-hover" id="datatable">
						<thead>	
							<tr>
								<th style="max-width:20px">ID</th>
								<th pesquisavel>Nome</th>
								<th>Porc. Credito</th>
								<th>Porc. Cred. Parc.</th>
								<th>Porc. Debito</th>
								<th>Máx. de Parcelas</th>
								<th class="align-center" style="width:140px">Ações</th>
							</tr>
						</thead>
					</table>
				</div>      
			</div>
		</div>
	</div>
</section>
@endsection




@push(Config::get('app.templateMasterScript' , 'script') )
	<script src="{{ mix('js/datatables-padrao.js') }}" type="text/javascript"></script>

	<script>

		var pagianIndex = document.getElementById("div-pagina").innerHTML;		
		function modelIndexDataTableFunction() {
			var dataTable = datatablePadrao('#datatable', {
				order: [[ 1, "asc" ]],
				ajax: { 
					url:'{{ route('operadoras.ajax.getDatatable') }}'
				},
				columns: [
					{ data: 'id', name: 'id' },
					{ data: 'nome', name: 'nome' },
					{ data: 'porcentagem_credito', name: 'porcentagem_credito' },
					{ data: 'porcentagem_credito_parcelado', name: 'porcentagem_credito_parcelado' },
					{ data: 'porcentagem_debito', name: 'porcentagem_debito' },
					{ data: 'max_parcelas', name: 'max_parcelas' },					
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'align-center'}
				],
			});
	
			dataTable.on('draw', function () {
				$('[btn-excluir]').click(function (){
					excluirRecursoPeloId($(this).data('id'), "@lang('msg.conf_excluir_o', ['1' => 'Operadoras' ])", "{{ route('operadoras.ajax.index') }}", 
						function(){
							dataTable.row( $(this).parents('tr') ).remove().draw('page');
						}
					);
				});

				$('[btn-show]').click(function (){					
					modelShow($(this).data('id'), "{{ route('operadoras.ajax.index') }}",
						function(data){							
							document.getElementById("div-pagina").innerHTML = data ;						
						}
					);                 
				});

				$('[btn-editar]').click(function (){					
					modelEditar($(this).data('id'), "{{ route('operadoras.ajax.index') }}",
						function(){							
							comboboxFunction();						
						} 	
					);                 
				});

			});

		}


		$(document).ready(function() {
			modelIndexDataTableFunction();
		});
	</script>



@endpush
