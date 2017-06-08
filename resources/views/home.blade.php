@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection


@section('main-content')
		<div class="row">
			<div class="col-md-10 col-md-offset-1">

				<div class="box">
					<div class="box-header">
						<h3>ENTREGAS</h3></div>
					<div class="box-body no-padding">
						<table class="table table-responsive table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>CLIENTE</th>
									<th>ENTREGA</th>
									<th>RECOGIDA</th>
									<th>BODEGA</th>
									<th>DETALLES</th>
								</tr>
							</thead>
							<tbody>
								@foreach($entregas as $entrega)
								<tr>
									<td>{{$entrega->id}}</td>
									<td>{{cliente($entrega->cliente,1)}}</td>
									<td>{{formatofecha($entrega->desde)}}</td>
									<td>{{formatofecha($entrega->hasta)}}</td>
									<td>{{validarbodega($entrega->bodega)}}</td>
									<td><a href="{{url('orden/'.$entrega->id)}}">detalle</a></td>
								</tr>
									@endforeach

							</tbody>
						</table>
					</div>


					<div class="panel-body">

					</div>
				</div>

				<div class="box">
					<div class="box-header">
						<h3>RECOGER</h3></div>
					<div class="box-body no-padding">
					<table class="table table-responsive table-hover table-striped">
						<thead>
								<tr>
									<th>ID</th>
									<th>CLIENTE</th>
									<th>ENTREGA</th>
									<th>RECOGIDA</th>
									<th>BODEGA</th>
									<th>DETALLES</th>
							</tr>
						</thead>
						<tbody>

							@foreach($devoluciones as $devolucion)
								<tr>
									<td>{{$devolucion->id}}</td>
									<td>{{cliente($devolucion->cliente,1)}}</td>
									<td>{{formatofecha($devolucion->desde)}}</td>
									<td>{{formatofecha($devolucion->hasta)}}</td>
									<td>{{validarbodega($devolucion->bodega)}}</td>
									<td><a href="{{url('orden/'.$devolucion->id)}}">detalle</a></td>

								</tr>
								@endforeach
						</tbody>
					</table>

					</div>
				</div>

				<div class="box">
					<div class="box-header">
						<h3>PENDIENTES</h3></div>
					<div class="box-body no-padding">
					<table class="table table-responsive table-hover table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>CLIENTE</th>
								<th>ENTREGA</th>
								<th>RECOGIDA</th>
								<th>BODEGA</th>
								<th>DETALLES</th>
							</tr>
						</thead>
						<tbody>

							@foreach($pendientes as $pendiente)
								<tr>
									<td>{{$pendiente->id}}</td>
									<td>{{cliente($pendiente->cliente,1)}}</td>
									<td>{{formatofecha($pendiente->desde)}}</td>
									<td>{{formatofecha($pendiente->hasta)}}</td>
									<td>{{validarbodega($pendiente->bodega)}}</td>
									<td><a href="{{url('orden/'.$pendiente->id)}}">detalle</a></td>

								</tr>
								@endforeach
						</tbody>
					</table>
					</div>
				</div>


			</div>
		</div>
@endsection
