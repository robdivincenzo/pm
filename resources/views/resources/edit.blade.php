@extends('layout')

@section('content')

<h1>Edit {{ $resource->name }}</h1>

<!-- if there are creation errors, they will show here -->
{{ Html::ul($errors->all()) }}

{{ Form::model($resource, array('route' => array('resources.update', $resource->id), 'method' => 'PUT')) }}

	<div class="form-group">
		{{ Form::label('initials', 'Initials') }}
		{{ Form::text('initials', null, array('class' => 'form-control')) }}
	</div>

	{{ Form::submit('Save Changes', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@stop