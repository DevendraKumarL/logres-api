<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;

class PersonController extends Controller
{
	public function index(Request $request)
	{
		$people = Person::all();
		return view('people.index', ['people' => $people]);
	}

	public function create()
	{
		return view('people.create');
	}

	public function store(Request $request)
	{
		$this->validate($request, [
			'firstname' => 'required',
	    	'lastname' => 'required',
	    	'age' => 'required|integer|between:1,100',
	    	'description' => 'required'
    	]);

		Person::create($request->all());
		return redirect()->route('person.index');
	}

	public function show($id)
	{
		return view('people.show', ['person' => Person::find($id)]);
	}

	public function edit($id)
	{
		return view('people.edit', ['person' => Person::find($id)]);
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'age' => 'integer|between:1,100'
		]);

		Person::find($id)->update($request->all());
		return redirect()->route('person.index');
	}

	public function destroy($id)
	{
		Person::find($id)->delete();
		return redirect()->route('person.index');
	}

}
