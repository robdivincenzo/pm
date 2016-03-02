@extends('layout')

@section('content')
		<div class="col-xs-5 col-md-5">
			<h3>Workload: Week of {{$start_of_week}}</h3>
		</div>
		<div class="workload-button col-xs-2 col-md-1">
			<a href="workload?get_week=prev&start_of_week={{$start_of_week}}">{{ Form::button('Prev', array('class' => 'btn btn-primary')) }}</a>
		</div>
		<div class="workload-button bottom col-xs-2 col-md-1">
			<a href="workload?get_week=next&start_of_week={{$start_of_week}}">{{ Form::button('Next', array('class' => 'btn btn-primary')) }}</a>
		</div>
		<div class="workload-button col-xs-3 col-md-2">
			<a href="workload">{{ Form::button('Go to Present Week', array('class' => 'btn btn-success')) }}</a>
		</div>

	<!-- will be used to show any messages -->
	@if (Session::has('message'))
		<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif
			<div class="col-xs-12 col-md-12">
				<h5>Filter by Custom Dates</h3>
			</div>

		{{ Form::open(array('url' => 'reports/workload', 'method'=>'GET')) }}
			<div class="form-group col-xs-4 col-md-4">
			{{ Form::label('due_at', 'From') }}
			{{ Form::text('start_date', $start_date, array('class' => 'form-control', 'id' => 'from_date')) }}
			</div>
			<div class="form-group col-xs-4 col-md-4">
			{{ Form::label('due_at', 'To') }}
			{{ Form::text('end_date', $end_date, array('class' => 'form-control', 'id' => 'to_date')) }}
			</div>
			<div class="form-group col-xs-4 col-md-4">
			{{ Form::label('', '&nbsp;') }}<br/>
			{{ Form::submit('Get Custom Workload', array('class' => 'btn btn-primary')) }}
			</div>

		{{ Form::close() }}
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<td>Project</td>
				@foreach($resources as $resource)
				<td>{{ $resource->initials }}</td>
				@endforeach
				<td>Total</td>
				<td>&nbsp;</td>
			</tr>
		</thead>
		<tbody>
		@foreach($workload as $id => $project)
			<tr>
				<td>{{ $project['title'] }}</td>
				@foreach($project['resources'] as $id => $resource)
				<td>{{ $resource['hours_estimate'] }}</td>
				@endforeach
				<td>{{ $project['hours_estimate'] }}</td>
				<!-- we will also add show, edit, and delete buttons -->
				<td>

					<!-- delete the project (uses the destroy method DESTROY /projects/{id} -->
					{{ Form::open(array('url' => 'projects/' . $project['id'], 'class' => 'pull-right')) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
					{{ Form::close() }}

					<!-- show the project (uses the show method found at GET /projects/{id} -->
					<a class="btn btn-small btn-success" href="{{ URL::to('projects/' . $project['id']) }}">Show</a>

					<!-- edit this project (uses the edit method found at GET /projects/{id}/edit -->
					<a class="btn btn-small btn-info" href="{{ URL::to('projects/' . $project['id'] . '/edit') }}">Edit</a>

				</td>
			</tr>
		@endforeach
			<tr>
				<td>Total</td>
				@foreach( $resources_total as $resource )
				<td>{{ number_format($resource['hours_estimate'], 2, '.', '') }}</td>
				@endforeach
				<td>{{ number_format($projects_total, 2, '.', '') }}</td>
				<td></td>
			</tr>
		</tbody>
	</table>
@stop