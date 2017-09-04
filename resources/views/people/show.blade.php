@extends('layouts.default')

@section('content')

	<a href="{{ route('person.index') }}">Back</a>
	<br>
	Firstname: {{ $person->firstname }}<br>
	Lastname: {{ $person->lastname }}<br>
	Age: {{ $person->age }}<br>
	Description: {{ $person->description }}<br>

@endsection