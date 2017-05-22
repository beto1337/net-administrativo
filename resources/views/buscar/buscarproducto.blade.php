@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection


@section('main-content')

  <div class="row">
		@if(Session::has('flash_message'))
		<div class="alert alert-success alert-dismissable fade in">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  <strong>Grandioso!</strong> {{Session::get('flash_message')}}
		</div>
		@endif


						<div class="col-lg-12">
							<div class="box box-primary">
							            <div class="box-header">
							              <h3 class="box-title">productos</h3>
							            </div>
							            <!-- /.box-header -->
							            <div class="box-body">
							              <table id="productos" class="table table-bordered table-striped">
							                <thead>
							                <tr>
							                  <th>Nombre</th>
							                  <th>Codigo</th>
							                  <th>Valor Mayorista</th>
                                <th>Valor Minorista</th>
                                  <th>MAS</th>
							                </tr>
							                </thead>
							                <tbody>
															@foreach ($productos as $producto)
																<tr>
																	<td>{{$producto->nombre}}</td>
																	<td>{{$producto->codigo}}</td>
																	<td>{{$producto->vl_mayorista}}</td>
																	<td>{{$producto->vl_minorista}}</td>
																	<td><a href="./producto?id={{$producto->codigo}}">mas</a></td>
																</tr>
															@endforeach

															</tbody>
														  <tfoot>
														  <tr>
                                <th>Nombre</th>
							                  <th>Codigo</th>
							                  <th>Valor Mayorista</th>
                                <th>Valor Minorista</th>
                                  <th>MAS</th>
															 </tr>
															 </tfoot>
															 </table>
														 </div>
														 </div>
													 </div>


</div>
<script type="text/javascript">
$(function () {
	$("#productos").DataTable({
		"language": {
					"lengthMenu": "Mostrar _MENU_ productos por pagina",
					"zeroRecords": "No hay productos registrados",
					"info": "Pagina _PAGE_ de _PAGES_",
					"infoEmpty": "Ninguna bodega encontrada",
					"infoFiltered": "(Filtrado de _MAX_ bodegas )",
					"search":         "Buscar:",
					"paginate": {
			"first":      "Primero",
			"last":       "Ultimo",
			"next":       "Siguiente",
			"previous":   "Anterior"
	}
			}
	});
});

</script>
@endsection
