@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection


@section('main-content')
<script src="js/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
<script src="js/plugins/sortable.min.js" type="text/javascript"></script>
<script src="js/plugins/purify.min.js" type="text/javascript"></script>
<script src="js/fileinput.min.js"></script>
<script src="js/locales/es.js"></script>

<div class="row">
	@foreach($productos as $producto)
		<div class="modal fade" id="producto{{$producto->id}}" role="dialog">
			<div class="modal-dialog modal-lg">
			<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Modal Header</h4>
			</div>
			<div class="modal-body">
				<form role="form" enctype="multipart/form-data" method="POST" action="{{ url('editproducts') }}">
				{{ csrf_field() }}
				<table class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>Nombre</th>
						<th>Descripcion</th>
						<th>Vr Mayorista</th>
						<th>VR Minorista</th>
					</tr>
					</thead>
					<tbody>
				<tr>

					<input type="hidden" name="id" value="{{$producto->id}}">
					<td><div class="form-group"><input class="form-control" type="text" name="nombre" value="{{$producto->nombre}}"></div></td>
					<td><div class="form-group"><textarea class="form-control" type="text" name="descripcion">{{$producto->descripcion}}</textarea></div></td>
					<td><div class="form-group"><input class="form-control" type="text" name="vrmayorista" value="{{$producto->vl_mayorista}}"></div></td>
					<td><div class="form-group"><input class="form-control" type="text" name="vrminorista" value="{{$producto->vl_minorista}}"></div></td>
				</tr>
				</tbody>
				</table>
				<div class="form-group">
				<input id="input-700{{$producto->id}}" name="kartik-input-700[]" type="file" multiple class="file-loading">
				<button type="submit" name="button" class="btn btn-warning btn-ms">editar</button>
				</div>
</form>
			</div>
			<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
	</div>
	</div>
	</div>
	<script type="text/javascript">
		$("#input-700{{$producto->id}}").fileinput({
				language: "es",
				uploadUrl: "http://localhost/file-upload-single/1", // server upload action
				uploadAsync: true,
				maxFileCount: 10
		});;
	</script>
@endforeach

<div class="col-lg-12">
	<div class="box box-primary">
							<div class="box-header">
								<h3 class="box-title">Productos</h3>
							</div>
							<!-- /.box-header -->
							<div class="box-body">
								<table id="productos" class="table table-bordered table-striped">
									<thead>
									<tr>
										<th>Nombre</th>
										<th>Codigo</th>
										<th>Vr mayorista</th>
										<th>Vr minorista</th>
										<th></th>
									</tr>
									</thead>
									<tbody>
									@foreach ($productos as $producto)
										<tr>
											<td>{{$producto->nombre}}</td>
											<td>{{$producto->codigo}}</td>
											<td>{{$producto->vl_mayorista}}</td>
											<td>{{$producto->vl_minorista}}</td>
											<td><a href="#" id="check{{$producto->id}}">editar</a></td>
										</tr>

										<script type="text/javascript">
										document.getElementById('check{{$producto->id}}').onclick = function() {
										$("#producto{{$producto->id}}").modal("show");
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
		<!-- /.box-header -->
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
