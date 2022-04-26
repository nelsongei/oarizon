<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\models\NssfRates;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class NssfController extends Controller {

	/**
	 * Display a listing of branches
	 *
	 * @return \Illuminate\Contracts\View\View
     */
	public function index()
	{
		$nrates = DB::table('x_social_security')->where('income_from', '!=', 0.00)->get();

		return View::make('nssf.index', compact('nrates'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return \Illuminate\Contracts\View\View
     */
	public function create()
	{
		return View::make('nssf.create');
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function store()
	{
		$validator = Validator::make($data = request()->all(), NssfRates::$rules,NssfRates::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$nrate = new NssfRates;

		$nrate->tier = Input::get('tier');

		$nrate->income_from = Input::get('i_from');

		$nrate->income_to = Input::get('i_to');

		$nrate->ss_amount_employee = Input::get('employee_amount');

		$nrate->ss_amount_employer = Input::get('employer_amount');

        $nrate->organization_id = '1';

		$nrate->save();

		return Redirect::route('nssf.index');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$nrate = NssfRates::findOrFail($id);

		return View::make('nssf.show', compact('nrate'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$nrate = NssfRates::find($id);

		return View::make('nssf.edit', compact('nrate'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$nrate = NssfRates::findOrFail($id);

		$validator = Validator::make($data = Input::all(), NssfRates::$rules,NssfRates::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$nrate->tier = Input::get('tier');

		$nrate->income_from = Input::get('i_from');

		$nrate->income_to = Input::get('i_to');

		$nrate->ss_amount_employee = Input::get('employee_amount');

		$nrate->ss_amount_employer = Input::get('employer_amount');

		$nrate->update();

		return Redirect::route('nssf.index');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		NssfRates::destroy($id);

		return Redirect::route('nssf.index');
	}

}
