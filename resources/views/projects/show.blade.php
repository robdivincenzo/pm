@extends('layout')

@section('content')

<h1>{{ $project->title }}</h1>

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<td>Title</td>
				<td>Hours Estimate</td>
				<td>Due At</td>
				<td>&nbsp;</td>
			</tr>
		</thead>
		<tbody>
		@foreach($tasks as $key => $value)
			<tr>
				<td>{{ $value->title }}</td>
				<td>{{ $value->hours_estimate }}</td>
				<td>{{ $value->due_at }}</td>
				<!-- we will also add show, edit, and delete buttons -->
				<td>

					<!-- delete the tasks (uses the destroy method DESTROY /projects/{id} -->
					{{ Form::open(array('url' => 'tasks/' . $value->id, 'class' => 'pull-right')) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
					{{ Form::close() }}

					<!-- show the tasks (uses the show method found at GET /projects/{id} -->
					<a class="btn btn-small btn-success" href="{{ URL::to('tasks/' . $value->id) }}">Show</a>

					<!-- edit this tasks (uses the edit method found at GET /projects/{id}/edit -->
					<a class="btn btn-small btn-info" href="{{ URL::to('tasks/' . $value->id . '/edit') }}">Edit</a>

				</td>
			</tr>
		@endforeach
		</tbody>
	</table>

@stop