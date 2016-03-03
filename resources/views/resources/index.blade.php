@extends('layout')

@section('content')
	<h1>All the Resources</h1>

	<!-- will be used to show any messages -->
	@if (Session::has('message'))
		<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif

	<table class="table table-striped table-bordered data-table">
		<thead>
			<tr>
				<td>Initials</td>
				<td>&nbsp;</td>
			</tr>
		</thead>
		<tbody>
		@foreach($resources as $key => $value)
			<tr>
				<td>{{ $value->initials }}</td>
				<!-- we will also add show, edit, and delete buttons -->
				<td>

					<!-- delete the resources (uses the destroy method DESTROY /tasks/{id} -->
					{{ Form::open(array('url' => 'resources/' . $value->id, 'class' => 'pull-right')) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
					{{ Form::close() }}

					<!-- show the resource (uses the show method found at GET /tasks/{id} -->
					<a class="btn btn-small btn-success" href="{{ URL::to('resources/' . $value->id) }}">Show</a>

					<!-- edit this resource (uses the edit method found at GET /tasks/{id}/edit -->
					<a class="btn btn-small btn-info" href="{{ URL::to('resources/' . $value->id . '/edit') }}">Edit</a>

				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@stop