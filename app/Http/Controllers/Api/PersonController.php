<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Validator;
use App\Http\Controllers\Controller;
use App\Person;

class PersonController extends Controller
{
	public function index(Request $request)
	{
		return Person::all();
	}

	public function store(Request $request)
	{
		$rules = [
			'firstname' => 'required',
	    	'lastname' => 'required',
	    	'age' => 'required|integer|between:1,100',
	    	'description' => 'required'
    	];

    	$validator = Validator($request->all(), $rules);
    	if ($validator->fails())
    	{
    		return response($validator->failed(), 400);
    	}

		$person = Person::create($request->all());
		return response($person, 201);
	}

	public function show($id)
	{
		$person = Person::find($id);
		if ($person != null)
		{
			return $person;
		}
		return response($person, 404);
	}

	public function update(Request $request, $id)
	{
		$rules = [
			'age' => 'integer|between:1,100'
		];

		$validator = Validator($request->all(), $rules);
		if ($validator->fails())
		{
			return response($validator->failed(), 400);
		}

		$person = Person::find($id);
		if ($person != null)
		{
			$person->update($request->all());
			return response(null, 204);
		}
		return response(null, 404);
	}

	public function destroy($id)
	{
		$person = Person::find($id);
		if ($person != null)
		{
			$person->delete();
			return response(null, 204);
		}
		return response(null, 404);
	}
}