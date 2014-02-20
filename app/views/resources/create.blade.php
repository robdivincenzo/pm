@extends('layout')

@section('content')

<h1>Create a Resource</h1>

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

{{ Form::open(array('url' => 'resources')) }}

	<div class="form-group">
		{{ Form::label('initials', 'Initials') }}
		{{ Form::text('initials', Input::old('initials'), array('class' => 'form-control')) }}
	</div>

	{{ Form::submit('Create', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@stop