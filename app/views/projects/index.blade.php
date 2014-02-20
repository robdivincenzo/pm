@extends('layout')

@section('content')
	<h1>All the Projects</h1>

	<!-- will be used to show any messages -->
	@if (Session::has('message'))
		<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<td>Title</td>
				<td>Description</td>
				<td>Hours Estimate</td>
				<td>&nbsp;</td>
			</tr>
		</thead>
		<tbody>
		@foreach($projects as $key => $value)
			<tr>
				<td>{{ $value->title }}</td>
				<td>{{ $value->description }}</td>
				<td>{{ $value->hours_estimate }}</td>
				<!-- we will also add show, edit, and delete buttons -->
				<td>

					<!-- delete the project (uses the destroy method DESTROY /projects/{id} -->
					{{ Form::open(array('url' => 'projects/' . $value->id, 'class' => 'pull-right')) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
					{{ Form::close() }}

					<!-- show the project (uses the show method found at GET /projects/{id} -->
					<a class="btn btn-small btn-success" href="{{ URL::to('projects/' . $value->id) }}">Show</a>

					<!-- edit this project (uses the edit method found at GET /projects/{id}/edit -->
					<a class="btn btn-small btn-info" href="{{ URL::to('projects/' . $value->id . '/edit') }}">Edit</a>

				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@stop