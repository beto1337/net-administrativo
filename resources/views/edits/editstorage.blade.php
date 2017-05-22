@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection


@section('main-content')

<div class="row">
	@foreach ($bodegas as $bodega)
		<div class="modal fade" id="bodega{{$bodega->id}}" role="dialog">
			<div class="modal-dialog modal-lg">
			<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Modal Header</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>Nombre</th>
						<th>Ciudad</th>
						<th>Direccion</th>
						<th>Telefono</th>
						<th>Editar</th>
					</tr>
					</thead>
					<tbody>
				<tr>
					<form role="form" enctype="multipart/form-data" method="POST" action="{{ url('editarstorage') }}">
					{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$bodega->id}}">
					<td><div class="form-group"><input class="form-control" type="text" name="nombre" value="{{$bodega->nombre}}"></div></td>
					<td><div class="form-group"><input class="form-control" type="text" name="ciudad" value="{{$bodega->ciudad}}"></div></td>
					<td><div class="form-group"><input class="form-control" type="text" name="direccion" value="{{$bodega->direccion}}"></div></td>
					<td><div class="form-group"><input class="form-control" type="text" name="telefono" value="{{$bodega->telefono}}"></div></td>
					<td><button type="submit" name="button" class="btn btn-warning btn-ms">editar</button></td>
				</tr>
				</tbody>
				</table>
			</div>
			<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
	</div>
	</div>
	</div>
@endforeach
	<div class="col-lg-10">
		<div class="col-lg-7">
			<div class="box box-primary">
			            <div class="box-header">
			              <h3 class="box-title">Bodegas</h3>
			            </div>
			            <!-- /.box-header -->
			            <div class="box-body">
			              <table id="bodegas" class="table table-bordered table-striped">
			                <thead>
			                <tr>
			                  <th>Nombre</th>
			                  <th>Ciudad</th>
			                  <th>Direccion</th>
			                  <th>Telefono</th>
			                  <th>Editar</th>
			                </tr>
			                </thead>
			                <tbody>
											@foreach ($bodegas as $bodega)
												<tr>
													<td>{{$bodega->nombre}}</td>
													<td>{{$bodega->ciudad}}</td>
													<td>{{$bodega->direccion}}</td>
													<td>{{$bodega->telefono}}</td>
													<td><a href="#" id="check{{$bodega->id}}">editar</a></td>
												</tr>

												<script type="text/javascript">
												document.getElementById('check{{$bodega->id}}').onclick = function() {
												$("#bodega{{$bodega->id}}").modal("show");
												}
												</script>
											@endforeach

											</tbody>
										  <tfoot>
										  <tr>
												<th>Nombre</th>
		 									 <th>Ciudad</th>
		 									 <th>Direccion</th>
		 									 <th>Telefono</th>
		 									 <th>Editar</th>
											 </tr>
											 </tfoot>
											 </table>
										 </div>
										 </div>
									 </div>
	</div>

</div>
<script type="text/javascript">
$(function () {
	$("#bodegas").DataTable({
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
