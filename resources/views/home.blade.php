@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection


@section('main-content')
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Home</div>

					<div class="panel-body">
						{{ quehace(5)}}
					</div>
				</div>
			</div>
		</div>
@endsection
