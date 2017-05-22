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
	@foreach ($clientes as $cliente)
		<div class="modal fade" id="cliente{{$cliente->id}}" role="dialog">
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
						<th>Apellido</th>
						<th>Cedula</th>
						<th>Telefono</th>
						<th>Celular</th>
						<th>correo</th>
						<th>Direccion</th>
						<th>Tipo</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
				<tr>
					<form role="form" enctype="multipart/form-data" method="POST" action="{{ url('editarcliente') }}">
					{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$cliente->id}}">
					<td><div class="form-group"><input class="form-control" type="text" name="nombre" value="{{$cliente->nombre}}"></div></td>
					<td><div class="form-group"><input class="form-control" type="text" name="apellido" value="{{$cliente->apellido}}"></div></td>
					<td><div class="form-group"><input class="form-control" type="text" disabled name="cedula" value="{{$cliente->cedula}}"></div></td>
					<td><div class="form-group"><input class="form-control" type="text" name="telefono" value="{{$cliente->telefono}}"></div></td>
					<td><div class="form-group"><input class="form-control" type="text" name="celular" value="{{$cliente->celular}}"></div></td>
					<td><div class="form-group"><input class="form-control" type="text" name="correo" value="{{$cliente->correo}}"></div></td>
					<td><div class="form-group"><input class="form-control" type="text" name="direccion" value="{{$cliente->direccion}}"></div></td>
					<td><div class="form-group">
							<select class="form-control" name="tipo">
								@foreach($tipos as $tipo )
								<option value="{{$tipo->valor_lista}}">{{$tipo->valor_item}}</option>
								@endforeach
							</select>
						</select>  </div></td>
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
	<div class="box box-primary">
							<div class="box-header">
								<h3 class="box-title">Clientes</h3>
							</div>
							<!-- /.box-header -->
							<div class="box-body">
								<table id="clientes" class="table table-bordered table-striped">
									<thead>
									<tr>
										<th>Nombre</th>
										<th>Cedula</th>
										<th>Telefono</th>
										<th>Celular</th>
										<th></th>
									</tr>
									</thead>
									<tbody>
									@foreach ($clientes as $cliente)
										<tr>
											<td>{{$cliente->nombre }} {{$cliente->apellido }} </td>
											<td>{{$cliente->cedula}}</td>
											<td>{{$cliente->telefono}}</td>
											<td>{{$cliente->celular}}</td>
											<td><a href="#" id="check{{$cliente->id}}" class="btn btn-primary btn-xs">editar</a></td>
										</tr>
										<script type="text/javascript">
										document.getElementById('check{{$cliente->id}}').onclick = function() {
										$("#cliente{{$cliente->id}}").modal("show");
										}

										</script>
									@endforeach

									</tbody>

									 </table>
								 </div>
								 </div>
							 </div>
</div>

<script type="text/javascript">

$(function () {
	$("#clientes").DataTable({
		"language": {
					"lengthMenu": "Mostrar _MENU_ clientes por pagina",
					"zeroRecords": "No clientes registrados",
					"info": "Pagina _PAGE_ de _PAGES_",
					"infoEmpty": "Ningun cliente encontrado",
					"infoFiltered": "(Filtrado de _MAX_ clientes )",
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
