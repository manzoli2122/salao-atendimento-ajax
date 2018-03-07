@extends( Config::get('app.templateMasterJson' , 'templates.templateMasterJson')  )

@section( Config::get('app.templateMasterContent' , 'content')  )

	@include('atendimentoAjax::atendimentos._index')

@endsection
		
@push( Config::get('app.templateMasterScript' , 'script')  )
    
	<script>



		var pagianIndex = document.getElementById("div-pagina").innerHTML;


		window.atendimentoExcluirPeloId = function( id , url ) {
			
			var texto = 'Você Confirma a Exclusão do Atendimento';
			alertConfimacao(texto, '',
				function() {
					alertProcessando();
					var token = document.head.querySelector('meta[name="csrf-token"]').content;
		
					$.ajax({
						url: url + "/" + id,
						type: 'post',
						data: { _method: 'delete', _token: token },
						success: function(retorno) {
							alertProcessandoHide();
							if (retorno.erro) {
								toastErro(retorno.msg);
							} else {
								toastSucesso(retorno.msg);
								document.getElementById("div-pagina").innerHTML = retorno.data ;
								
							}
						},
						error: function(erro) {
							alertProcessandoHide();
							toastErro("Ocorreu um erro");
							console.log(erro);
						}
					});
				}
			);
		}
		


        function ApagarAtendimento(val) {

			excluirRecursoPeloId($(this).data('id'), "@lang('msg.conf_excluir_o', ['1' => 'Operadoras' ])", "{{ route('operadoras.ajax.index') }}", 
				function(){
					dataTable.row( $(this).parents('tr') ).remove().draw('page');
				}
			);

            return  confirm('Deseja mesmo apagar o Atendimento?'  );                       
		}




				
		window.atendimentoPesquisar = function( url , form , funcSucesso = function() {} ) {			
			alertProcessando();
			var token = document.head.querySelector('meta[name="csrf-token"]').content;
			var data = form["data"].value ;
			
			$.ajax({
				url: url ,
				type: 'post',
				data: { _token: token , data: data } ,
				success: function(retorno) {
					alertProcessandoHide();
					if (retorno.erro) {
						toastErro(retorno.msg);
					} else {
						document.getElementById("div-pagina").innerHTML = retorno.data ;
						funcSucesso();	
					}
				},
				error: function(erro) {
					alertProcessandoHide();
					toastErro("Ocorreu um erro na requisição ajax.");
					console.log(erro);
				}
			});				
		}







		window.atendimentoAlterarData = function( id , url , form ) {			
			alertProcessando();
			var token = document.head.querySelector('meta[name="csrf-token"]').content;
			var data = form["data"].value ;
			$.ajax({
				url: url ,
				type: 'post',
				data: { _token: token , data: data , id: id } ,
				success: function(retorno) {
					alertProcessandoHide();
					$('#alterarDataModal'+ id ).modal('hide');
					if (retorno.erro) {
						toastErro(retorno.msg);
					} else {
						document.getElementById("div-pagina").innerHTML = retorno.data ;						
					}
				},
				error: function(erro) {
					alertProcessandoHide();
					toastErro("Ocorreu um erro na requisição ajax.");
					console.log(erro);
				}
			});				
		}
		



	</script>
@endpush
	