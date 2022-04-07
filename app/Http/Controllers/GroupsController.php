<?php

namespace App\Http\Controllers;

use \App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class GroupsController extends Controller {

	/*
	 * Display a listing of groups
	 *
	 * @return Response
	 */
	public function index()
	{
		$groups = Group::all();

		return view('groups.index', compact('groups'));
	}

	/*
	 * Show the form for creating a new group
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('groups.create');
	}

	/*
	 * Store a newly created group in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($data = $request->all(), Group::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$group = new Group;

		$group->name = $request->get('name');
		$group->description = $request->get('description');
		$group->save();

		return Redirect::route('groups.index');
	}

	/*
	 * Display the specified group.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$group = Group::findOrFail($id);

		return view('groups.show', compact('group'));
	}

	/*
	 * Show the form for editing the specified group.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$group = Group::find($id);

		return view('groups.edit', compact('group'));
	}

	/*
	 * Update the specified group in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
		$group = Group::findOrFail($id);

		$validator = Validator::make($data = $request->all(), Group::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$group->name = $request->get('name');
		$group->description = $request->get('description');
		$group->update();

		return Redirect::route('groups.index');
	}

	/*
	 * Remove the specified group from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Group::destroy($id);

		return Redirect::route('groups.index');
	}

}
