@extends('layout')

@section('content')

<h1>Create a Project</h1>

<!-- if there are creation errors, they will show here -->
{{ Html::ul($errors->all()) }}

{{ Form::open(array('url' => 'projects')) }}

	<div class="form-group">
		{{ Form::label('title', 'Title') }}
		{{ Form::text('title', Input::old('title'), array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('description', 'Description') }}
		{{ Form::text('description', Input::old('description'), array('class' => 'form-control')) }}
	</div>

	{{ Form::submit('Create', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@stop