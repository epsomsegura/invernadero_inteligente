@extends('layouts.dashboard')
@section('page_heading','Menu Principal')
@section('section')
<style type="text/css">
	.th{
		text-align: center;
		align: center;
		color: #1c4263;
	}
	.title{
		font-size: 25px;
		color: #337ab7;
		font-family: verdana;
	}

	
</style>
<div class="content-fluid">
	<div class="row">
		<div class="col-md-12 order-md-1">
                <table class="table">
                    <tbody align="center">
                        <tr>
                            <td align="center">
							@foreach ($invernaderos as $invernadero)
                            	<div class="title">Invernadero #{{ $invernadero->id }} - {{ $invernadero->address }}</div>
                                <table class="table table-striped">
									<tbody align="center">										
											@foreach ($invernadero->rPlot as $fila)	
												@if (count($fila) > 0)			
													<tr>		
													@foreach ($fila as $columna)														
															<td class="th" scope="col">Parcela #{{ $columna->id }} - {{ $columna->plant }}</td>														
															<td>
																<button type="button" value="{{ $columna->id }}" class="btn btn-info">Detalles</button>
															</td>
													@endforeach
													</tr>
													
												@else
												<tr>
													<td scope="col">Sin Parcelas</td>																							
												</tr>
												@endif		
											@endforeach																									  																											
									</tbody>
								</table>
								<br>
								<br>
							@endforeach
							</td>
                        </tr>                        
                    </tbody>
                </table>
            </div>
	</div>	
</div>        
@stop