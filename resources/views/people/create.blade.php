@extends('layouts.default')

@section('content')
	<h3>Create a new Person</h3>
	<a href="{{ route('person.index') }}">Back</a><br>

	<div>
		@if (count($errors) > 0)
			Errors:
			<ul>
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
			</ul>
		@endif
	</div>

	{!! Form::open(array('route' => 'person.store', 'method' => 'post')) !!}
		{!! Form::text('firstname', null, array('placeholder' => 'Firstname')) !!}<br>
		{!! Form::text('lastname', null, array('placeholder' => 'Lastname')) !!}<br>
		{!! Form::number('age', null, array('placeholder' => 'Age')) !!}<br>
		{!! Form::textarea('description', null, array('placeholder' => 'Desciption')) !!}<br>
		<input type="submit" value="Submit">
	{!!  Form::close() !!}

@endsection