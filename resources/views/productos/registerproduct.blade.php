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
 <div class="col-md-4">
       <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Registrar Producto</h3>
          </div>
          <form role="form" enctype="multipart/form-data" method="POST" action="{{ url('registrarproducto') }}">
          {{ csrf_field() }}
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInput">Nombre</label>
              <input type="text" class="form-control" name="nombre" id="exampleInputEmail1" placeholder="">
							@if ($errors->has('nombre') )
						   <p style="color:red;margin:0px">{{ $errors->first('nombre') }}</p>
						  @endif
						</div>
						<div class="form-group">
							<label for="exampleInput">Categoria</label>
							<select class="select2 form-control" name="categoria">
								<option value="">sin categoria</option>
								@foreach ($categorias as $key)
								<option value="{{$key->valor_lista}}">{{$key->valor_item}}</option>
								@endforeach
								</select>
							@if ($errors->has('categoria') )
							 <p style="color:red;margin:0px">{{ $errors->first('categoria') }}</p>
							@endif
						</div>
					<div class="form-group">
				<label for="exampleInput">Descripcion</label>
				<textarea type="text" class="form-control" rows="4" name="descripcion" id="exampleInputEmail1" placeholder=""></textarea>
			</div>
			<div class="form-group">
				<label for="exampleInput">Valor Mayorista</label>
				<input type="number" class="form-control" name="vrmayorista" id="exampleInputEmail1" placeholder="">

			</div>
			<div class="form-group">
				<label for="exampleInput">Valor Minorista</label>
				<input type="number" class="form-control" name="vrminorista" id="exampleInputEmail1" placeholder="">
			</div>
	 <div class="box-footer">
      <button type="submit" class="btn btn-primary">Registrar</button>
      </div>
      </form>
      </div>
      </div>
			</div>

						<div class="col-sm-8">
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
																<th>Descripcion</th>
							                  <th>Valor Minorista</th>
							                  <th>Valor Mayorista</th>
							                </tr>
							                </thead>
							                <tbody>
															@foreach ($productos as $producto)
																<tr>
																	<td>{{$producto->nombre}}</td>
																	<td>{{$producto->codigo}}</td>
																	<td>{{$producto->descripcion}}</td>
																	<td>{{$producto->vl_minorista}}</td>
																	<td>{{$producto->vl_minorista}}</td>
																</tr>
															@endforeach

															</tbody>
														  <tfoot>
														  <tr>
																<th>Nombre</th>
 															 <th>Codigo</th>
 															 <th>Descripcion</th>
 															 <th>Valor Minorista</th>
 															 <th>Valor Mayorista</th>
															 </tr>
															 </tfoot>
															 </table>
														 </div>
														 </div>
													 </div>


</div>
<script type="text/javascript">
$(function () {
	$(".select2").select2({
		placeholder: "Seleccione una categoria",
		allowClear: true,
		 language: "es"
	});
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
