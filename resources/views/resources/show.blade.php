@extends('layout')

@section('content')

<h1>{{ $resource->initials }}</h1>

	<div class="jumbotron text-center">
		<h2></h2>
		<p>
		</p>
	</div>
	<h2>Current Tasks</h2>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<td>Task</td>
				<td>Hours Estimate</td>
				<td>&nbsp;</td>
			</tr>
		</thead>
		<tbody>
		@foreach($tasks as $key => $value)
			<tr>
				<td>{{ $value->title }}</td>
				<td>{{ $value->hours_estimate }}</td>

				<!-- we will also add show, edit, and delete buttons -->
				<td>
					<!-- delete the resources (uses the destroy method DESTROY /projects/{id} -->
					{{ Form::open(array('url' => 'tasks/' . $value->id, 'class' => 'pull-right')) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
					{{ Form::close() }}

					<!-- show the resources (uses the show method found at GET /projects/{id} -->
					<a class="btn btn-small btn-success" href="{{ URL::to('tasks/' . $value->id) }}">Show</a>

					<!-- edit this resources (uses the edit method found at GET /projects/{id}/edit -->
					<a class="btn btn-small btn-info" href="{{ URL::to('tasks/' . $value->id . '/edit') }}">Edit</a>

				</td>
			</tr>
		@endforeach
		</tbody>
	</table>

@stop