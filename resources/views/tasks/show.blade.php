@extends('layout')

@section('content')

<h1>{{ $task->title }}</h1>

	<div class="jumbotron text-center">
		<h2>{{ $task->description }}</h2>
		<p>
			<strong>Hours Estimate:</strong> {{ $task->hours_estimate }}<br>
			<!-- delete the resources (uses the destroy method DESTROY /projects/{id} -->
			{{ Form::open(array('url' => 'tasks/' . $task->id, 'class' => 'pull-right')) }}
				{{ Form::hidden('_method', 'DELETE') }}
				{{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
			{{ Form::close() }}

			<!-- edit this resources (uses the edit method found at GET /projects/{id}/edit -->
			<a class="btn btn-small btn-info" href="{{ URL::to('tasks/' . $task->id . '/edit') }}">Edit</a>
		</p>
	</div>

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<td>Initials</td>
				<td>Hours Estimate</td>
				<td>Due At</td>
				<td>Completed</td>
			</tr>
		</thead>
		<tbody>
		@foreach($resources as $key => $value)
			<tr>
				<td>{{ $value->initials }}</td>
				<td>{{ $value->hours_estimate }}</td>
				<td>{{ $value->due_at }}</td>
				<td>{{ $value->completed }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>


@stop