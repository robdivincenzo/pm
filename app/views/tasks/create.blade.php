@extends('layout')

@section('content')

<h1>Create a Task</h1>

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

{{ Form::open(array('url' => 'tasks')) }}

	<div class="form-group">
		{{ Form::label('title', 'Title') }}
		{{ Form::text('title', Input::old('title'), array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('description', 'Description') }}
		{{ Form::text('description', Input::old('description'), array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('project', 'Project') }}
		{{ Form::select('project_id', $project_list, Input::old('project_id'), array('class' => 'form-control')) }}
	</div>

	<div class="row resource_estimate_row">
		<div class="form-group col-xs-2 col-md-2">
		{{ Form::label('resource_ids', 'Resource') }}
		{{ Form::select('resource_ids[]', $resource_list, Input::old('resource_list'), array('class' => 'form-control')) }}
		</div>
		<div class="form-group col-xs-2 col-md-2">
		{{ Form::label('hours_estimates', 'Hours Estimate') }}
		{{ Form::text('hours_estimates[]', Input::old('hours_estimate'), array('class' => 'form-control')) }}
		</div>
		<div class="form-group col-xs-2 col-md-2">
		{{ Form::label('due_at', 'Task Due On') }}
		{{ Form::text('due_at[]', '', array('class' => 'form-control date-picker','placeholder' => 'Date','data-datepicker' => 'datepicker')) }}</p>
		</div>
		<div class="form-group col-xs-2 col-md-2">
		{{ Form::button('Remove Resource', array('class' => 'btn btn-primary btn-warning clone-delete', 'id'=>'resource_estimate')) }}
		</div>
	</div>

{{ Form::button('Add Resource', array('class' => 'btn btn-primary clone-empty', 'id'=>'resource_estimate')) }}

{{ Form::submit('Create Task', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

<div class="row resource_estimate_clone hidden">
	<div class="form-group col-xs-2 col-md-2">
	{{ Form::label('resource_ids', 'Resource') }}
	{{ Form::select('resource_ids[]', $resource_list, Input::old('resource_list'), array('class' => 'form-control')) }}
	</div>
	<div class="form-group col-xs-2 col-md-2">
	{{ Form::label('hours_estimates', 'Hours Estimate') }}
	{{ Form::text('hours_estimates[]', Input::old('hours_estimate'), array('class' => 'form-control')) }}
	</div>
	<div class="form-group col-xs-2 col-md-2">
	{{ Form::label('due_at', 'Task Due On') }}
	{{ Form::text('due_at[]', '', array('class' => 'form-control date-picker','placeholder' => 'Date','data-datepicker' => 'datepicker')) }}</p>
	</div>
	<div class="form-group col-xs-2 col-md-2">
	{{ Form::button('Remove Resource', array('class' => 'btn btn-primary btn-warning clone-delete', 'id'=>'resource_estimate')) }}
	</div>
</div>

@stop