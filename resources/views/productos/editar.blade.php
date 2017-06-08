@extends('layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection


@section('main-content')
<div class="row">
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
											<td><a href="{{url('editarproducto/'.$producto->codigo)}}" >editar</a></td>
										</tr>
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
