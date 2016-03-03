@extends('layout')

@section('content')

<h1>Edit {{ $task->title }}</h1>

<!-- if there are creation errors, they will show here -->
{{ Html::ul($errors->all()) }}

{{ Form::model($task, array('route' => array('tasks.update', $task->id), 'method' => 'PUT')) }}

	<div class="form-group">
		{{ Form::label('title', 'Title') }}
		{{ Form::text('title', null, array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('description', 'Description') }}
		{{ Form::text('description', null, array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('project', 'Project') }}
		{{ Form::select('project_id', $project_list, Input::old('project_id'), array('class' => 'form-control')) }}
	</div>
	<div class="row resource_estimate_row">
	</div>

	@foreach( $resource_tasks as $resource_task )
	<div class="row resource_estimate_row">
		<div class="form-group col-xs-2 col-md-2">
		{{ Form::label('resource_ids', 'Resource') }}
		{{ Form::select('resource_ids[]', $resource_list, $resource_task->id, array('class' => 'form-control')) }}
		</div>
		<div class="form-group col-xs-2 col-md-2">
		{{ Form::label('hours_estimates', 'Hours Estimate') }}
		{{ Form::text('hours_estimates[]', $resource_task->hours_estimate, array('class' => 'form-control')) }}
		</div>
		<div class="form-group col-xs-2 col-md-2">
		{{ Form::label('due_at', 'Task Due On') }}
		{{ Form::text('due_at[]', $resource_task->due_at, array('class' => 'form-control date-picker','placeholder' => 'Date','data-datepicker' => 'datepicker')) }}</p>
		</div>
		<div class="form-group col-xs-2 col-md-2">
		{{ Form::label('completed', 'Completed') }}<br />
		{{ Form::text('completed[]', 0, array('class' => 'hidden')) }}
		<input type="checkbox" <?php if ($resource_task->completed) { echo "checked='checked'"; }?>/>
		</div>

		<div class="form-group col-xs-2 col-md-2">
			{{ Form::button('Remove Resource', array('class' => 'btn btn-primary btn-warning clone-delete', 'id'=>'resource_estimate')) }}
		</div>
	</div>
	@endforeach

{{ Form::button('Add Resource', array('class' => 'btn btn-primary clone-empty', 'id'=>'resource_estimate')) }}

{{ Form::submit('Save Changes', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

<div class="row resource_estimate_clone clone hidden">
	<div class="form-group col-xs-2 col-md-2">
	{{ Form::label('resource_ids', 'Resource') }}
	{{ Form::select('resource_ids[]', $resource_list, '', array('class' => 'form-control')) }}
	</div>
	<div class="form-group col-xs-2 col-md-2">
	{{ Form::label('hours_estimates', 'Hours Estimate') }}
	{{ Form::text('hours_estimates[]', '', array('class' => 'form-control')) }}
	</div>
	<div class="form-group col-xs-2 col-md-2">
	{{ Form::label('due_at', 'Task Due On') }}
	{{ Form::text('due_at[]', '', array('class' => 'form-control date-picker','placeholder' => 'Date','data-datepicker' => 'datepicker')) }}</p>
	</div>
	<div class="form-group col-xs-2 col-md-2">
	{{ Form::label('completed', 'Completed') }}<br />
	{{ Form::text('completed[]', 0, array('class' => 'hidden')) }}
	<input type="checkbox" />
	</div>

	<div class="form-group col-xs-2 col-md-2">
		{{ Form::button('Remove Resource', array('class' => 'btn btn-primary btn-warning clone-delete', 'id'=>'resource_estimate')) }}
	</div>
</div>
@stop