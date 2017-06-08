@extends('layouts.app')

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
            <h3 class="box-title">Registrar Bodega</h3>
          </div>
                <!-- /.box-header -->
                <!-- form start -->
          <form role="form" enctype="multipart/form-data" method="POST" action="{{ url('registerstorage') }}">
          {{ csrf_field() }}
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInput">Nombre</label>
                      <input type="text" class="form-control" value="{{ old('nombre')}}" name="nombre" id="exampleInputEmail1" placeholder="">
											@if ($errors->has('nombre') )
						      		<p style="color:red;margin:0px">{{ $errors->first('nombre') }}</p>
						      		@endif
						</div>
						<div class="form-group">
							<label for="exampleInput">Ciudad</label>
							<input type="text" class="form-control" value="{{ old('ciudad')}}" name="ciudad" id="exampleInputEmail1" placeholder="">
							@if ($errors->has('ciudad') )
							<p style="color:red;margin:0px">{{ $errors->first('ciudad') }}</p>
							@endif
						</div>

						<div class="form-group">
							<label for="exampleInput">Direccion</label>
							<input type="text" class="form-control" name="direccion" value="{{ old('direccion')}}" id="exampleInputEmail1" placeholder="">
							@if ($errors->has('direccion') )
							<p style="color:red;margin:0px">{{ $errors->first('direccion') }}</p>
							@endif
						</div>

						<div class="form-group">
							<label for="exampleInput">Telefono</label>
							<input type="text" class="form-control" name="telefono" value="{{ old('telefono')}}" id="exampleInputEmail1" placeholder="">
							@if ($errors->has('telefono') )
							<p style="color:red;margin:0px">{{ $errors->first('telefono') }}</p>
							@endif
						</div>

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                  </div>
                </form>
              </div>
            </div>
</div>
<div class="col-md-7">
	<div class="box box-primary">
	            <div class="box-header">
	              <h3 class="box-title">Bodegas</h3>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	              <table id="bodegas" class="table table-bordered table-striped">
	                <thead>
	                <tr>
	                  <th>Id</th>
	                  <th>Nombre</th>
	                  <th>Ciudad</th>
	                  <th>Direccion</th>
	                  <th>Telefono</th>
	                </tr>
	                </thead>
	                <tbody>
									@foreach ($bodegas as $bodega)
										<tr>
											<td>{{$bodega->id}}</td>
											<td>{{$bodega->nombre}}</td>
											<td>{{$bodega->ciudad}}</td>
											<td>{{$bodega->direccion}}</td>
											<td>{{$bodega->telefono}}</td>
										</tr>
									@endforeach

									</tbody>
								  <tfoot>
								  <tr>
											 <th>Id</th>
										<th>Nombre</th>
 									 <th>Ciudad</th>
 									 <th>Direccion</th>
 									 <th>Telefono</th>

									 </tr>
									 </tfoot>
									 </table>
								 </div>
								 </div>
							 </div>


</div>
<script type="text/javascript">
$(function () {
	$("#bodegas").DataTable({
		"language": {
					"lengthMenu": "Mostrar _MENU_ bodegas por pagina",
					"zeroRecords": "No hay bodegas registrados",
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
