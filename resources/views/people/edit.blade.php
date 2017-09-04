@extends('layouts.default')

@section('content')

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

	{!! Form::open(array('route' => ['person.update', $person->id], 'method' => 'patch')) !!}
		{!! Form::text('firstname', $person->firstname, array('placeholder' => 'Firstname')) !!}<br>
		{!! Form::text('lastname',  $person->lastname, array('placeholder' => 'Lastname')) !!}<br>
		{!! Form::number('age', $person->age, array('placeholder' => 'Age')) !!}<br>
		{!! Form::textarea('description', $person->description, array('placeholder' => 'Desciption')) !!}<br>
		<input type="submit" value="Submit">
	{!!  Form::close() !!}

@endsection