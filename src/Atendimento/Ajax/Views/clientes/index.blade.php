@extends( Config::get('app.templateMaster' , 'templates.templateMaster')  )

@section( Config::get('app.templateMasterContentTitulo' , 'titulo-page')  )
	Clientes			
@endsection

@section( Config::get('app.templateMasterMenuLateral' , 'menuLateral')  )				
	@permissao('clientes-apagados')
		<li><a href="{{  route('clientes.apagados')}}"><i class="fa fa-circle-o text-red"></i> <span>Clientes Apagados</span></a></li>
	@endpermissao
@endsection

@section( Config::get('app.templateMasterContentTituloSmallRigth' , 'small-content-header-right')  )			
	@permissao('clientes-cadastrar')
        <a href="{{ route('clientes.create')}}" class="btn btn-success btn-sm" title="Adicionar um novo clientes">
			<i class="fa fa-plus"></i> Cadastrar cliente
		</a>
	@endpermissao
@endsection


@push( Config::get('app.templateMasterCss' , 'css')  )			
	<style type="text/css">
		.btn-group-sm>.btn, .btn-sm {
			padding: 1px 10px;
			font-size: 15px;		
		}
		.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
			padding: 4.8px;
		}
		label {			
			 margin-bottom: 1px; 
		}
	</style>
@endpush


@section( Config::get('app.templateMasterContent' , 'content')  )

<div class="col-xs-12">
    <div class="box box-success">	
        <div class="box-body" style="padding-top: 5px; padding-bottom: 3px;">
            <table class="table table-bordered table-striped table-hover table-responsive" id="datatable">
                <thead>
                    <tr>						
						<th>Nome</th>
						<th>Divida</th>
                        <th class="align-center" style="width:180px;min-width: 160px;">Ações</th>
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
				dom: "<'row'<'col-xs-12'<'col-xs-12'f>>>"+
            		 "<'row'<'col-xs-12't>>"+
            		 "<'row'<'col-xs-12'p>>",
				order: [[ 0, "asc" ]],
				ajax: { 
					url:'{{ route('clientes.getDatatable') }}'
				},
				columns: [
					
					{ data: 'name', name: 'name' },
				
					{ data: 'valor', name: 'valor', searchable: false,   class: "price"},
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'align-center'}
				],
			});

			dataTable.on('draw', function () {
				$('[btn-excluir]').click(function (){
					excluirRecursoPeloId($(this).data('id'), "@lang('msg.conf_excluir_o', ['1' => 'tipo de seção'])", "{{ route('clientes.apagados') }}", 
						function(){
							dataTable.row( $(this).parents('tr') ).remove().draw('page');
						}
					);
				});
			});
		});
	</script>
@endpush