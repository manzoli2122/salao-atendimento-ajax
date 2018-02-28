@extends( Config::get('app.templateMasterJson' , 'templates.templateMasterJson')  )

@section( Config::get('app.templateMasterContent' , 'content')  )
<section class="content-header">
	<h1>
		<span id="div-titulo-pagina">Listagem dos Serviços	</span>
		<small style="float: right;">
			@permissao('servicos-cadastrar')
				<button class="btn btn-success btn-sm" onclick="modelCreate( '{{ route('servicos.ajax.create') }}' , function(){comboboxFunction();}  )" title="Adicionar um novo Serviço">
					<i class="fa fa-plus"></i> Cadastrar Serviço 
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
								<th  style="max-width:20px">ID</th>
								<th pesquisavel>Nome</th>
								<th>Valor</th>						
								<th>Duração</th>										
								<th>Porc. Func.</th>
								<th>Categoria</th>
								<th style="max-width:70px">Desconto Máx.</th>												
								<th class="align-center" style="width:120px">Ações</th>
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
					url:'{{ route('servicos.ajax.getDatatable') }}'
				},
				columns: [
					{ data: 'id', name: 'id' },
					{ data: 'nome', name: 'nome' },
					{ data: 'valor', name: 'valor' },
					{ data: 'duracao_aproximada', name: 'duracao_aproximada' },					
					{ data: 'porcentagem_funcionario', name: 'porcentagem_funcionario' },
					{ data: 'categoria', name: 'categoria' },
					{ data: 'desconto_maximo', name: 'desconto_maximo' ,  visible: false },
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'align-center'}
				],
			});
	
			dataTable.on('draw', function () {
				$('[btn-excluir]').click(function (){
					excluirRecursoPeloId($(this).data('id'), "@lang('msg.conf_excluir_o', ['1' => 'servicos' ])", "{{ route('servicos.ajax.index') }}", 
						function(){
							dataTable.row( $(this).parents('tr') ).remove().draw('page');
						}
					);
				});

				$('[btn-show]').click(function (){					
					modelShow($(this).data('id'), "{{ route('servicos.ajax.index') }}",
						function(data){							
							document.getElementById("div-pagina").innerHTML = data ;						
						}
					);                 
				});

				$('[btn-editar]').click(function (){					
					modelEditar($(this).data('id'), "{{ route('servicos.ajax.index') }}",
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





	<script>
		function comboboxFunction() {
			$.widget( "custom.combobox", {
				_create: function() {
					this.wrapper = $( "<span>" )
					.addClass( "custom-combobox" )
					.insertAfter( this.element );			
					this.element.hide();
					this._createAutocomplete();
					this._createShowAllButton();
				},
	  
				_createAutocomplete: function() {
					var selected = this.element.children( ":selected" ),
					value = selected.val() ? selected.text() : "";			
					this.input = $( "<input>" )
					.appendTo( this.wrapper )
					.val( value )
					.attr( "title", "" )
					.attr( "style", "width: 90%;     display: inline;" )					
					.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left form-control" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: $.proxy( this, "_source" )
					})
					.tooltip({
						classes: {
						"ui-tooltip": "ui-state-highlight"
						}
					});			
					this._on( this.input, {
					autocompleteselect: function( event, ui ) {
						ui.item.option.selected = true;
						this._trigger( "select", event, {
						item: ui.item.option
						});
					},			
					autocompletechange: "_removeIfInvalid"
					});
				},
	  
				_createShowAllButton: function() {
					var input = this.input,
					wasOpen = false;			
					$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.tooltip()
					.appendTo( this.wrapper )
					.button({
						icons: {
						primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "custom-combobox-toggle ui-corner-right form-control" )
					.on( "mousedown", function() {
						wasOpen = input.autocomplete( "widget" ).is( ":visible" );
					})
					.on( "click", function() {
						input.trigger( "focus" );			
						// Close if already visible
						if ( wasOpen ) {
						return;
						}			
						// Pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
					});
				},
			
				_source: function( request, response ) {
					var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
					response( this.element.children( "option" ).map(function() {
					var text = $( this ).text();
					if ( this.value && ( !request.term || matcher.test(text) ) )
						return {
						label: text,
						value: text,
						option: this
						};
					}) );
				},
	  
		   		_removeIfInvalid: function( event, ui ) {	  
					// Selected an item, nothing to do
					if ( ui.item ) {
						return;
					}	  
					// Search for a match (case-insensitive)
					var value = this.input.val(),
					valueLowerCase = value.toLowerCase(),
					valid = false;
					this.element.children( "option" ).each(function() {
					if ( $( this ).text().toLowerCase() === valueLowerCase ) {
						this.selected = valid = true;
						return false;
					}
					});	  
					// Found a match, nothing to do
					if ( valid ) {
						return;
					}	  
					// Remove invalid value
					this.input
					.val( "" )
					.attr( "title", value + " didn't match any item" )
					.tooltip( "open" );
					this.element.val( "" );
					this._delay(function() {
						this.input.tooltip( "close" ).attr( "title", "" );
					}, 2500 );
					this.input.autocomplete( "instance" ).term = "";
				},
	  
				_destroy: function() {
					this.wrapper.remove();
					this.element.show();
				}
		 	});	  
		 	$( "#categoria" ).combobox();		 
		} 		   
	</script>
@endpush