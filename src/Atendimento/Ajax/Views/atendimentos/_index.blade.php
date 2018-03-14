<section class="content-header">
	<h1>
		<span id="div-titulo-pagina">Relatório do dia {{ $caixa->data->format('d/m/Y')}} </span>		
		<small style="float: right;">
			<form   method="POST"  accept-charset="UTF-8">
				{{csrf_field()}}
				<div class="input-group input-group-sm" style="width: 150px; margin-left:auto;">					
                    <input class="form-control" placeholder="Pesquisar" required="" name="data" type="date" value="{{ $caixa->data->format('Y-m-d')}}">
                    <div class="input-group-btn">
                        <button onclick="atendimentoPesquisar( '{{ route('atendimentos.ajax.pesquisar') }}' , this.form  )" type="button" style="margin-right:10px;" class="btn btn-outline-success my-2 my-sm-0" >
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>	
                    </div>
				</div>									
            </form>
            
		</small>
		<small style="float: right;padding-top: 7px;">
			Buscar por Data:	
		</small>
	</h1>
</section>	
<section class="content">
	<div class="row">
		@forelse($caixa->atendimentos() as $model)	
			@include('atendimentoAjax::atendimentos.modalAterarData')
		@empty									
		@endforelse		
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">ATENDIMENTOS</a></li>
                    <li><a href="#caixa" data-toggle="tab">CAIXA</a></li>
                    <li><a href="#despesa" data-toggle="tab">DESPESAS</a></li>
                    @foreach ($caixa->funcionariosDoDia()  as $key )
                        <li><a href="#funcionario_{{$key->id}}" data-toggle="tab"> {{ $key->apelido }}</a></li>
                    @endforeach	
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <table class="table table-hover table-striped table-hover table-responsive">
                            <tr>
                                @perfil('Admin') <th>ID</th>  @endperfil
                                <th>CLIENTES</th>
                                <th>SERVIÇOS</th>
                                <th>PRODUTOS</th>	
                                <th>VALOR TOTAL</th>					
                                <th>AÇÕES</th>
                            </tr>
                            @forelse($caixa->atendimentos() as $model)				
                            <tr>
                                @perfil('Admin') <td> {{ $model->id }}  </td>	 @endperfil
                                <td> {{ $model->cliente->name }}  </td>			
                                <td> R$ {{number_format($model->valorServicos(), 2 , ',' , '' )}} </td>
                                <td> R$ {{number_format($model->valorProdutos(), 2 , ',' , '' )}} </td>			
                                <td> R$ {{number_format($model->valor, 2 , ',' , '' )}} </td>
                                <td>

                                    <button type="button" class="btn btn-success btn-xs"  onclick="modelShow( {{$model->id}} , '{{ route('atendimentos.ajax.index') }}' , function(data){ document.getElementById('div-pagina').innerHTML = data ;} )" title="Exibir" >
                                        <i class="fa fa-eye" aria-hidden="true"></i>Exibir
                                    </button>

                                    @if($model->created_at->isToday())
                                        @permissao('atendimentos')  
                                            <a class="btn btn-warning btn-xs" data-toggle="modal" data-target="#alterarDataModal{{$model->id}}" style="margin-left: 10px;" > 
                                                <i class="fa fa-pencil"></i> Alterar Data
                                            </a>							
                                        @endpermissao		
                                        @permissao('atendimentos-soft-delete')		                                            
                                            <button type="button" class="btn btn-danger btn-xs"  onclick="atendimentoExcluirPeloId( {{$model->id}} , '{{ route('atendimentos.ajax.index') }}'  )" title="Excluir" style="margin-left: 10px;" >
                                                <i class="fa fa-trash" aria-hidden="true"></i>Apagar
                                            </button>									
                                        @endpermissao



                                    @else                                       
                                        @permissao('atendimentos-mega-power')
                                            <a class="btn btn-warning btn-xs" data-toggle="modal" data-target="#alterarDataModal{{$model->id}}" style="margin-left: 10px;" > 
                                                Alterar Data
                                            </a>
                                            <button type="button" class="btn btn-danger btn-xs"  onclick="atendimentoExcluirPeloId( {{$model->id}} , '{{ route('atendimentos.ajax.index') }}'  )" title="Excluir" style="margin-left: 10px;" >
                                                <i class="fa fa-trash" aria-hidden="true"></i>Apagar
                                            </button>

                                           
                                        @endpermissao
                                    @endif	
                                    
                                    

                                </td>
                            </tr>
                            @empty					
                            @endforelse	
                            <tr style="font-size: 18px;font-weight: bold;">
                                @perfil('Admin') <td>   </td>	 @endperfil
                                <td> TOTAL </td>	
                                <td>  {{ $caixa->valor_servicos() }}   </td>	
                                <td>  {{ $caixa->valor_produtos() }}  </td>	
                                <td>  {{ $caixa->valor_atendimentos() }}  </td>	
                                <td>   </td>	
                            </tr>				
                        </table>                	
                    </div>
                    <div class="tab-pane" id="caixa">
                        <div class="row">				
                            @if( $caixa->valor_Pagamento_dinheiro() != '' )
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text" style="font-size:20px;">DINHEIRO:</span>
                                            <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
                                            <span class="info-box-number">{{ $caixa->valor_Pagamento_dinheiro() }} </span>								
                                            
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if( $caixa->valor_Pagamento_credito() != '' )					
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-red"><i class="fa fa-cc-visa"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text" style="font-size:20px;">CREDITO:</span>
                                            <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
                                            <span class="info-box-number">{{ $caixa->valor_Pagamento_credito() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if( $caixa->valor_Pagamento_debito() != '' )
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-yellow"><i class="fa fa-credit-card"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text" style="font-size:20px;"> DEBITO:</span>
                                            <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
                                            <span class="info-box-number">{{ $caixa->valor_Pagamento_debito() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if( $caixa->valor_Pagamento_pic_pay() != '' )
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-purple"><i class="fa fa-paypal"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text" style="font-size:20px;">PIC PAY:</span>
                                            <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
                                            <span class="info-box-number">{{ $caixa->valor_Pagamento_pic_pay() }}</span>
                                        </div>
                                    </div>
                                </div>			
                            @endif
                            @if( $caixa->valor_Pagamento_transferencia_bancaria() != '' )
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-blue"><i class="fa fa-bank"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text" style="font-size:15px;">TRANSF. BANCÁRIA:</span>
                                            <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
                                            <span class="info-box-number"> {{ $caixa->valor_Pagamento_transferencia_bancaria() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if( $caixa->valor_Pagamento_cheque() != '' )
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon bg-orange"><i class="fa fa-newspaper-o"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text" style="font-size:20px;" >CHEQUE:</span>
                                            <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
                                            <span class="info-box-number">  {{ $caixa->valor_Pagamento_cheque() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if( $caixa->valor_Pagamento_fiado() != '' )
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="info-box bg-gray">
                                        <span class="info-box-icon"><i class="glyphicon glyphicon-cloud"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text" style="font-size:20px;">FIADO: </span>
                                            <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
                                            <span class="info-box-number">  {{ $caixa->valor_Pagamento_fiado() }} </span>
                                        </div>
                                    </div>
                                </div>
                            @endif	
                        </div>
                    </div>

                    <div class="tab-pane" id="despesa">
                        <table class="table table-hover table-striped table-hover table-responsive">
                            <tr>
                                @perfil('Admin') <th>ID</th>  @endperfil
                                <th>TIPO</th>
                                <th>DESTINAÇÃO</th>
                                <th>DESCRIÇÃO</th>	
                                <th>VALOR</th>					
                                
                            </tr>
                            @forelse($caixa->despesas() as $model)				
                            <tr>
                                @perfil('Admin') <td> {{ $model->id }}  </td>	 @endperfil
                                <td> {{ $model->tipo }}  </td>			
                                <td> {{ $model->destinacao() }} </td>
                                <td> {{ $model->descricao }} </td>			
                                <td> R$ {{number_format($model->valor, 2 , ',' , '' )}} </td>
                                
                            </tr>
                            @empty					
                            @endforelse	
                            <tr style="font-size: 18px;font-weight: bold;">
                                @perfil('Admin') <td>   </td>	 @endperfil
                                <td> TOTAL </td>	
                                <td>     </td>	
                                <td>   </td>	
                                <td>  {{ $caixa->valor_despesas() }}  </td>	
                                    
                            </tr>				
                        </table>                	
                    </div>

                    @foreach ($caixa->funcionariosDoDia() as $key )
                    <div class="tab-pane" id="funcionario_{{$key->id}}">
                        <table class="table table-hover table-striped table-hover table-responsive">
                            <tr>
                                @perfil('Admin') <th>ID</th>  @endperfil
                                <th>SERVIÇO</th>
                                <th>CLIENTE</th>
                                <th>VALOR TOTAL</th>							
                                <th>VALOR LIQUIDO</th>
                            </tr>
                            @forelse($caixa->atendimentosFuncionario($key->id) as $model)
                                <tr>
                                    @perfil('Admin') <td> {{ $model->id }}  </td>	 @endperfil
                                    <td> {{ $model->servico->nome }} </td>
                                    <td> {{ $model->cliente->name }}  </td>		
                                    <td> R$ {{number_format($model->valor, 2 , ',' , '' )}} </td>		
                                    <td> R$ {{number_format($model->valorFuncioanrio() , 2 , ',' , '' )}} </td>			
                                </tr>
                            @empty					
                            @endforelse	
                            <tr style="font-size: 18px;font-weight: bold;">
                                @perfil('Admin') <td>   </td>	 @endperfil
                                <td>   </td>			
                                <td>TOTAL  </td>
                                <td>{{ $caixa->atendimentosFuncionarioTotal($key->id) }}  </td>			
                                <td style="color:red"> {{ $caixa->atendimentosFuncionarioLiquido($key->id) }} </td>								
                            </tr>														
                        </table>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
	</div>
</section>