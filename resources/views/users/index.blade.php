@extends('layout')

@section('content')

<h1>Your Profile</h1>

	<div class="jumbotron text-center">
		<h2></h2>
		<p></p>
	</div>

<!-- if there are creation errors, they will show here -->
{{ Html::ul($errors->all()) }}

{{ Form::model($user, array('route' => array('profile.update', $user->id), 'method' => 'PUT')) }}

	<div class="form-group">
		{{ Form::label('name', 'Name') }}
		{{ Form::text('name', null, array('class' => 'form-control')) }}
	</div>
	<div class="form-group">
		{{ Form::label('email', 'Email') }}
		{{ Form::text('email', null, array('class' => 'form-control')) }}
	</div>
	<div class="form-group">
		{{ Form::label('password', 'Password') }}
		{{ Form::password('password', array('class' => 'form-control')) }}
	</div>
	<div class="form-group">
		{{ Form::label('resource_id', 'Profile') }}
		{{ Form::select('resource_id', $resources, $user->resource_id, array('class' => 'form-control')) }}

	</div>
	{{ Form::submit('Save Changes', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@stop