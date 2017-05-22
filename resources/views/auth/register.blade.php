@extends('layouts.app')

@section('htmlheader_title')
registro
@endsection

@section('main-content')
  <body class="hold-transition register-page">
@if(Session::has('flash_message'))
<div style="width:200px" class="alert alert-success alert-dismissable fade in">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Grandioso!</strong> {{Session::get('flash_message')}}
</div>
@endif
@if(Session::has('error_message'))
<div style="width:200px" class="alert alert-danger alert-dismissable fade in">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error! </strong> {{Session::get('error_message')}}
</div>
@endif
        <div class="register-logo">
            <label style="font-size:20px !important">REGISTRAR USUARIO</label>
        </div>


        <div class="register-box" style="margin-top:0px !important;margin-bottom:0px !important">
        <div class="register-box-body">
            <form action="{{ url('/registrarusuario') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="{{ trans('adminlte_lang::message.fullname') }}" name="name" value="{{ old('name') }}"/>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Telefono" name="telefono" value="{{ old('telefono') }}"/>
                    <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="{{ trans('adminlte_lang::message.email') }}" name="email" value="{{ old('email') }}"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.password') }}" name="password"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.retrypepassword') }}" name="password_confirmation"/>
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
                <div class="form-group">
                  <label for="">perfil de usuario</label>
                <select class="form-control select2" data-placeholder="Seleccione perfil de usuario" style="width:100%" tabindex="-1" aria-hidden="true"
                onchange="capturar()" id="id_perfil" name="id_perfil">
                    @foreach($perfiles as $perfil)
                      <option title="{{$perfil->descripcion}}" value="{{ $perfil->valor_lista}}">{{$perfil->valor_item}}</option>
                    @endforeach
                </select>
                </div>
                <div class="form-group" id="bodega" style="display:none">
                  <label for="">Bodega</label>
                <select class="form-control select2" data-placeholder="Seleccione perfil de usuario" style="width:100%" tabindex="-1"
                id="id_bodega"  aria-hidden="true" name="bodega">
                <option value="0">Seleccione una bodega</option>
                    @foreach($bodegas as $bodega)
                      <option title="{{$bodega->ciudad}}" value="{{$bodega->id}}">{{$bodega->nombre}}</option>
                    @endforeach
                </select>
                </div>

                <div class="row">
                    <div class="col-xs-10 col-xs-push-1">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Registrar</button>
                    </div>
                </div>
            </form>


        </div><!-- /.form-box -->
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> {{ trans('adminlte_lang::message.someproblems') }}<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div><!-- /.register-box  if(bodega.options[bodega.selectedIndex].value>1)-->

</body>
<script type="text/javascript">
function capturar() {
  verbodega = document.getElementById("bodega");
  var bodega = document.getElementById('id_perfil');
  if(bodega.options[bodega.selectedIndex].value>1)
verbodega.style.display='block';
  else
verbodega.style.display='none';
}
</script>



@endsection
