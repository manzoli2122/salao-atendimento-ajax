@extends( Config::get('app.templateMaster' , 'templates.templateMaster')  )

@section( Config::get('app.templateMasterContentTitulo' , 'titulo-page')  )
	Listagem dos Clientes			
@endsection

@section( Config::get('app.templateMasterMenuLateral' , 'menuLateral')  )	
		<li><a href="{{  route('clientes.index')}}"><i class="fa fa-circle-o text-green"></i> <span>Clientes Ativos</span></a></li>
@endsection

@section( Config::get('app.templateMasterContent' , 'content')  )

<div class="col-xs-12">
    <div class="box box-success">	
        <div class="box-body">
            <table class="table table-bordered table-striped table-hover" id="datatable">
                <thead>
                    <tr>
						<th>ID</th>
						<th pesquisavel>Nome</th>						
                        <th class="align-center" style="width:180px;">Ações</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@push(Config::get('app.templateMasterScript' , 'script') )
	<script src="{{ mix('js/datatables-padrao.js') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function() {
			var dataTable = datatablePadrao('#datatable', {
				order: [[ 1, "asc" ]],
				ajax: { 
					url:'{{ route('clientes.getDatatable.apagados') }}'
				},
				columns: [
					{ data: 'id', name: 'id' },
					{ data: 'name', name: 'name' },
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'align-center'}
				],
			});

			dataTable.on('draw', function () {
				$('[btn-excluir]').click(function (){
					excluirRecursoPeloId($(this).data('id'), "@lang('msg.conf_excluir_o', ['1' => 'clientes'])", "{{ route('clientes.index') }}", 
						function(){
							dataTable.row( $(this).parents('tr') ).remove().draw('page');
						}
					);
				});
			});
		});
	</script>
@endpush