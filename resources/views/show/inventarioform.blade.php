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

    <div class="col-lg-8">
      <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Inventario</h3>
      </div>
     <div class="box-body">
    <form id="form1" name="form1" role="form" enctype="multipart/form-data" method="POST" action="{{ url('buscarinventario') }}">
    {{ csrf_field() }}
<div class="form-group">
	<label >Bodega</label>
	<label class="checkbox-inline"><input type="checkbox" name="todasb" id="bodegacheck" value="1">Todas las bodegas</label>
</div>
    <div class="form-group" id="bodegas" >
	<select class="form-control select2" id="bodega" multiple style="width: 100%;" name="bodega[]">
		@foreach ($bodegas as $bodega)
		<option value="{{$bodega->id}}">{{$bodega->nombre}}</option>
		@endforeach
	</select>
				 @if ($errors->has('bodega') )
				 <p style="color:red;margin:0px">{{ $errors->first('bodega') }}</p>
				 @endif
    </div>
    <div class="form-group" id="producto">
      <label >Productos</label>
			<label class="checkbox-inline"><input type="checkbox" name="todasp" id="productocheck" value="1">Todas las bodegas</label>
</div>
	<div class="form-group" id="productos">
			<select class="form-control select2" id="producto" multiple style="width: 100%;" name="producto[]">
        @foreach ($productos as $producto)
        <option value="{{$producto->codigo}}">{{$producto->codigo}} - {{$producto->nombre}}</option>
        @endforeach
         </select>
				 @if ($errors->has('producto') )
					<p style="color:red;margin:0px">{{ $errors->first('producto') }}</p>
					@endif
    </div>

		<div class="form-group">
							 <label>Fecha:</label>

							 <div class="input-group date">
								 <div class="input-group-addon">
									 <i class="fa fa-calendar"></i>
								 </div>
								 <input type="text" class="form-control pull-right" id="datepicker" name="fecha">
							 </div>
							 @if ($errors->has('fecha') )
								<p style="color:red;margin:0px">{{ $errors->first('fecha') }}</p>
								@endif
							 <!-- /.input group -->
						 </div>
    <div class="form-group" id="productos">
      <button type="submit" class="btn btn-primary" name="button">Buscar</button>
    </div>



    </form>

    </div>

    </div>

    </div>


</div>
<script type="text/javascript">
$(document).ready(function() {
  $('.select2').select2({
language: {
noResults: function() {
return "No hay resultado";
},
searching: function() {return "Buscando..";}
}
});
document.getElementById('bodegacheck').onclick = function() {
element = document.getElementById("bodegas");
check = document.getElementById("bodegacheck");
	if (check.checked) {
			element.style.display='none';
	}
	else {
			element.style.display='block';
	}
}
document.getElementById('productocheck').onclick = function() {
element = document.getElementById("productos");
check = document.getElementById("productocheck");
	if (check.checked) {
			element.style.display='none';
	}
	else {
			element.style.display='block';
	}
}
$('#datepicker').datepicker({
	format: 'dd-mm-yyyy',
	 autoclose: true,
	 language: "es"
});


});
</script>

@endsection
