<?php namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Deduction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class DeductionsController extends Controller {

	/**
	 * Display a listing of branches
	 *
	 * @return \Illuminate\Contracts\View\View
     */
	public function index()
	{
		$deductions = Deduction::all();

		Audit::logaudit(now('Africa/Nairobi'),Auth::user()->username, 'view', 'viewed deduction list ');

		return View::make('deductions.index', compact('deductions'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return \Illuminate\Contracts\View\View
     */
	public function create()
	{
		return View::make('deductions.create');
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function store()
	{
		$validator = Validator::make($data = request()->all(), Deduction::$rules, Deduction::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$deduction = new Deduction;

		$deduction->deduction_name = request('name');

        $deduction->organization_id = '1';

		$deduction->save();

		Audit::logaudit('Deductions', 'create', 'created: '.$deduction->deduction_name);

		return Redirect::route('deductions.index');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Contracts\View\View
     */
	public function show($id)
	{
		$deduction = Deduction::findOrFail($id);

		return View::make('deductions.show', compact('deduction'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Contracts\View\View
     */
	public function edit($id)
	{
		$deduction = Deduction::find($id);

		return View::make('deductions.edit', compact('deduction'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function update($id)
	{
		$deduction = Deduction::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Deduction::$rules, Deduction::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$deduction->deduction_name = Input::get('name');
		$deduction->update();

		Audit::logaudit('Deductions', 'update', 'updated: '.$deduction->deduction_name);

		return Redirect::route('deductions.index');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$deduction = Deduction::findOrFail($id);

		Deduction::destroy($id);

		Audit::logaudit('Deductions', 'delete', 'deleted: '.$deduction->deduction_name);

		return Redirect::route('deductions.index');
	}

}
