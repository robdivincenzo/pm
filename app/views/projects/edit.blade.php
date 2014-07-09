@extends('layout')

@section('content')
	<h1>Edit {{ $project->title }}</h1>

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

{{ Form::model($project, array('route' => array('projects.update', $project->id), 'method' => 'PUT')) }}

	<div class="form-group">
		{{ Form::label('title', 'Title') }}
		{{ Form::text('title', null, array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('description', 'Description') }}
		{{ Form::text('description', null, array('class' => 'form-control')) }}
	</div>

	{{ Form::submit('Save Changes', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@stop