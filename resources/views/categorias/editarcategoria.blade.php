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
            <h3 class="box-title">Crear Categoria</h3>
          </div>
                <!-- /.box-header -->
                <!-- form start -->
          <form role="form" enctype="multipart/form-data" method="POST" action="{{ url('editarcategoria') }}">
          {{ csrf_field() }}
          <div class="box-body">
						@foreach ($categorias as $categoria)
						<input type="hidden" name="id" value="{{$categoria->valor_lista}}">
            <div class="form-group">
              <label for="exampleInput">Nombre</label>
                      <input type="text" class="form-control" value="{{$categoria->valor_item}}" name="nombre" id="exampleInputEmail1" placeholder="">
											@if ($errors->has('nombre') )
						      		<p style="color:red;margin:0px">{{ $errors->first('nombre') }}</p>
						      		@endif
						</div>
						<div class="form-group">
							<label for="exampleInput">Descripcion</label>
							<input type="text" class="form-control" value="{{$categoria->descripcion}}" name="descripcion" id="exampleInputEmail1" placeholder="">
							@if ($errors->has('ciudad') )
							<p style="color:red;margin:0px">{{ $errors->first('ciudad') }}</p>
							@endif
						</div>

						<div class="form-group">
							<label for="exampleInput">Codigo</label>
							<input type="number" class="form-control" name="codigo" value="{{$categoria->valor_lista}}" id="exampleInputEmail1" placeholder="">
							@if ($errors->has('codigo') )
							<p style="color:red;margin:0px">{{ $errors->first('codigo') }}</p>
							@endif
						</div>


                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Editar</button>
                  </div>
                </form>
							@endforeach
              </div>
            </div>
</div>



</div>

@endsection
