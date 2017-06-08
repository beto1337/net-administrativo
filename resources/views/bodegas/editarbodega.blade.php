@extends('layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection


@section('main-content')

<div class="row">
  @foreach($bodega as $bodega)
  <div class="col-lg-8">
    <form role="form" enctype="multipart/form-data" method="POST" action="{{ url('editarstorage') }}">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$bodega->id}}">
     <div class="form-group">
       <input class="form-control" type="text" name="nombre" value="{{$bodega->nombre}}">
     </div>
     <div class="form-group">
       <input class="form-control" type="text" name="ciudad" value="{{$bodega->ciudad}}">
     </div>
     <div class="form-group">
       <input class="form-control" type="text" name="direccion" value="{{$bodega->direccion}}">
     </div>
     <div class="form-group">
       <input class="form-control" type="text" name="telefono" value="{{$bodega->telefono}}">
     </div>
     <button type="submit" name="button" class="btn btn-warning btn-ms">editar</button>

</form>
  </div>
@endforeach
</div>



@endsection
