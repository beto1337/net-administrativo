@extends('layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection


@section('main-content')

  <div class="row">

 <div class="col-md-12">
	 @foreach ($productos as $producto)

       <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Registrar Producto</h3>
          </div>
          <form role="form" enctype="multipart/form-data" method="POST" action="{{ url('editarproducto') }}">
          {{ csrf_field() }}
					<input type="hidden" name="codigoprincipal" value="{{$producto->codigo}}">
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInput">Nombre</label>
              <input type="text" class="form-control" value="{{$producto->nombre}}" name="nombre" id="exampleInputEmail1" placeholder="">
							@if ($errors->has('nombre') )
						   <p style="color:red;margin:0px">{{ $errors->first('nombre') }}</p>
						  @endif
						</div>
						<div class="form-group">
							<label for="exampleInput">Categoria</label>
								<select class="select2 form-control" name="categoria" id="categoria">
								<option value="{{$producto->categoria}}">{{validarlista($producto->categoria,4)}}</option>
								@foreach ($categorias as $key)
								<option value="{{$key->valor_lista}}">{{$key->valor_item}}</option>
								@endforeach
								</select>
							@if ($errors->has('categoria') )
							 <p style="color:red;margin:0px">{{ $errors->first('categoria') }}</p>
							@endif
						</div>
						<div id="" class="form-group">
							<label for="exampleInput">Codigo</label>
							<label for=""  class="pull-right" class="">editar</label><input type="checkbox" name="editarcodigo" class="pull-right" id="editarcodigo" value="1">
							<input type="text" name="codigo" class="form-control" id="codigo" value="{{$producto->codigo}}" disabled="true">
							<input type="hidden" name="Codigo" value="{{$producto->codigo}}">
							@if ($errors->has('codigo') )
							 <p style="color:red;margin:0px">{{ $errors->first('codigo') }}</p>
							@endif
							@if ($errors->has('Codigo') )
							 <p style="color:red;margin:0px">{{ $errors->first('Codigo') }}</p>
							@endif
						</div>
					<div class="form-group">
				<label for="exampleInput">Descripcion</label>
				<textarea type="text" class="form-control"  rows="4" name="descripcion" id="exampleInputEmail1" placeholder="">{{$producto->descripcion}}</textarea>
			</div>
			<div class="form-group">
				<label for="exampleInput">Valor Mayorista</label>
				<input type="number" class="form-control" value="{{$producto->vl_mayorista}}" name="vrmayorista" id="exampleInputEmail1" placeholder="">

			</div>
			<div class="form-group">
				<label for="exampleInput">Valor Minorista</label>
				<input type="number" class="form-control" name="vrminorista" value="{{$producto->vl_minorista}}" id="exampleInputEmail1" placeholder="">
			</div>

			<div class="form-group">
				<label class="control-label">Seleccionar imagenes</label>
<input id="input-24" name="imagenes[]" type="file" multiple class="file-loading">
</div>

	 <div class="box-footer">
      <button type="submit" class="btn btn-primary">Registrar</button>
      </div>
      </form>

      </div>
      </div>
							@endforeach
{{buscarimagenes($producto->imagen,$producto->codigo)}}
			</div>


</div>
<script src="{{ asset('js/fileinput.min.js')}}"></script>
<script src="{{ asset('themes/explorer/theme.js')}}"></script>
<script src="{{ asset('plugins/select2/select2.full.min.js')}}"></script>

<script type="text/javascript">
$(document).on('ready', function() {
    $("#input-24").fileinput();
});


document.getElementById('editarcodigo').onclick =function() {
	check = document.getElementById("editarcodigo");
	if (check.checked) {
		document.getElementById('codigo').disabled = false;
	}else {
		document.getElementById('codigo').disabled = true;
	}

}

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
