<?php

namespace App\Http\Controllers;

use App\Models\JGroup;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class JobGroupController extends BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return \Illuminate\Contracts\View\View
     */
	public function index()
	{
		$jgroups = JGroup::all();

		return View::make('job_group.index', compact('jgroups'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return \Illuminate\Contracts\View\View
     */
	public function create()
	{
		return View::make('job_group.create');
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function store()
	{
		$validator = Validator::make($data = request()->all(), JGroup::$rules,JGroup::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$jgroup = new JGroup;

		$jgroup->job_group_name = request('name');

        $jgroup->organization_id = '1';

		$jgroup->save();

		return Redirect::route('job_group.index');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Contracts\View\View
     */
	public function show($id)
	{
		$jgroup = JGroup::findOrFail($id);

		return View::make('job_group.show', compact('jgroup'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Contracts\View\View
     */
	public function edit($id)
	{
		$jgroup = JGroup::find($id);

		return View::make('job_group.edit', compact('jgroup'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function update($id)
	{
		$jgroup = JGroup::findOrFail($id);

		$validator = Validator::make($data = request()->all(), JGroup::$rules,JGroup::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$jgroup->job_group_name = request('name');
		$jgroup->update();

		return Redirect::route('job_group.index');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function destroy($id)
	{
		JGroup::destroy($id);

		return Redirect::route('job_group.index');
	}

}
