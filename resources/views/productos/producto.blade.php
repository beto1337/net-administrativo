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
@foreach ($productos as $producto)
						<div class="col-lg-6">
							<div class="box box-primary">
							            <div class="box-header">
							              <h3 class="box-title">producto {{$producto->codigo}}</h3>
							            </div>
							            <!-- /.box-header -->
							            <div class="box-body">
                            <div class="table-responsive">
                              <table class="table  table-hover table-bordered table-striped">
                                <thead>
                                <tr>
                                  <th>item</th>
                                  <th>valor</th>
                                </tr>
                                </thead>
                                <tbody>

                                  <tr>
                                    <td>Nombre</td>
                                    <td>{{$producto->nombre}}</td>
                                  </tr>
                                  <tr>
                                    <td>Codigo</td>
                                    <td>{{$producto->codigo}}</td>
                                  </tr>
																	<tr>
																		<td>Categoria</td>
																		<td>{{validarlista($producto->categoria,4)}}</td>
																	</tr>
                                  <tr>
                                    <td>descripcion</td>
                                    <td>{{$producto->descripcion}}</td>
                                  </tr>
                                  <tr>
                                    <td>Valor Mayorista</td>
                                    <td>{{$producto->vl_mayorista}}</td>
                                  </tr>

                                  <tr>
                                    <td>Valor Minorista</td>
                                    <td>{{$producto->vl_minorista}}</td>
                                  </tr>


                                </tbody>
                                 </table>

                            </div>
														 </div>
														 </div>
														 													 <a href="{{url('editarproducto/'.$producto->codigo)}}">editar</a>
													 </div>


   {{buscarimagenes($producto->imagen,$producto->codigo)}}

@endforeach
</div>
@endsection
