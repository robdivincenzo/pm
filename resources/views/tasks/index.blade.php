@extends('layout')

@section('content')
	<h1>All the Tasks</h1>

	<!-- will be used to show any messages -->
	@if (Session::has('message'))
		<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif

	<table class="table table-striped table-bordered data-table">
		<thead>
			<tr>
				<td>Title</td>
				<td>Description</td>
				<td>Project</td>
				<td>Assigned To</td>
				<td>Hours Estimate</td>
				<td>Due At</td>
				<td>Completed</td>
				<td>&nbsp;</td>
			</tr>
		</thead>
		<tbody>
		@foreach($tasks as $key => $value)
			<tr>
				<!-- show the tasks (uses the show method found at GET /tasks/{id} -->
				<td><a href="{{ URL::to('tasks/' . $value->id) }}">{{ $value->title }}</a></td>
				<td>{{ $value->description }}</td>
				<td>{{ $value->project_title }}
				<td>{{ $value->resource_initials }}</td>
				<td>{{ $value->hours_estimate }}</td>
				<td>{{ $value->due_at }}</td>
				<td>{{ $value->completed }}</td>
				<!-- we will also add show, edit, and delete buttons -->
				<td>

					<!-- delete the tasks (uses the destroy method DESTROY /tasks/{id} -->
					{{ Form::open(array('url' => 'tasks/' . $value->id, 'class' => 'pull-right')) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
					{{ Form::close() }}

					<!-- edit this task (uses the edit method found at GET /tasks/{id}/edit -->
					<a class="btn btn-small btn-info" href="{{ URL::to('tasks/' . $value->id . '/edit') }}">Edit</a>

				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@stop