@extends( Config::get('app.templateMasterJson' , 'templates.templateMasterJson')  )

@section( Config::get('app.templateMasterContent' , 'content')  )
<section class="content-header">
	<h1>
		<span id="div-titulo-pagina">CLIENTES </span>		
		<small style="float: right;">
			@permissao('clientes-cadastrar')
				<button class="btn btn-success btn-sm" onclick="modelCreate( '{{ route('clientes.ajax.create') }}'   )" title="Adicionar uma novo Clientes">
					<i class="fa fa-plus"></i><b> CADASTRAR CLIENTE </b>
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
					<table class="table table-bordered table-striped table-hover table-responsive" id="datatable">
						<thead>
							<tr>		
								<th style="max-width:35px">ID</th>				
								<th>Nome</th>
								<th>Divida</th>
								<th class="align-center" style="width:180px;min-width: 160px;">Ações</th>
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
	<script src="{{ mix('js/atendimento.js') }}" type="text/javascript"></script>
	<script>

		var pagianIndex = document.getElementById("div-pagina").innerHTML;		
		function modelIndexDataTableFunction() {
			var dataTable = datatablePadrao('#datatable', {
				dom: "<'row'<'col-xs-12'<'col-xs-12'f>>>"+
            		 "<'row'<'col-xs-12't>>"+
            		 "<'row'<'col-xs-12'p>>",
				order: [[ 1, "asc" ]],
				ajax: { 
					url:'{{ route('clientes.ajax.getDatatable') }}'
				},
				columns: [
					{ data: 'id', name: 'id' ,  visible: @perfil('Admin') true @else false  @endperfil },		
					{ data: 'name', name: 'name' },				
					{ data: 'valor', name: 'valor', searchable: false,   class: "price"},
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'align-center'}
				],
			});
	
			dataTable.on('draw', function () {
				

				$('[btn-show]').click(function (){					
					modelShow($(this).data('id'), "{{ route('clientes.ajax.index') }}",
						function(data){							
							document.getElementById("div-pagina").innerHTML = data ;						
						}
					);                 
				});


				$('[btn-atender]').click(function (){					
					modelAtender($(this).data('id'), "{{ route('atendimentos.ajax.atender') }}",
						function(){							
							//comboboxFunction();						
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
