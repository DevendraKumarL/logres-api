@extends('layouts.default')

@section('content')

	<h2>Welcome to People's Community</h2>
	<h4>Community Size: {{ count($people) }}</h4>
	<a href="{{ route('person.create') }}">Create a new Person</a><br>

	<table border="2">
		<thead>
			<th>Name</th>
			<th>Age</th>
			<th>Description</th>
			<th>View</th>
			<th>Update</th>
			<th>Delete</th>
		</thead>
		<tbody>
			@foreach($people as $key => $person)
				<tr>
					<td>{{ $person->firstname }}&nbsp;{{ $person->lastname }}</td>
					<td>{{ $person->age }}</td>
					<td>{{ $person->description }}</td>
					<td><a href="{{ route('person.show', $person->id) }}">View</a></td>
					<td><a href="{{ route('person.edit', $person->id) }}">Edit</a></td>
					<td>
						{!! Form::open(['method' => 'delete', 
							'route' => ['person.destroy', $person->id], 'style' => 'display:inline']) !!}
						{!! Form::submit('Delete') !!}
						{!! Form::close() !!}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

@endsection