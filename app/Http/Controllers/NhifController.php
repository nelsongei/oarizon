<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class NhifController extends BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return \Illuminate\Contracts\View\View
     */
	public function index()
	{
		$nrates = DB::table('x_hospital_insurance')->where('income_from', '!=', 0.00)->get();

		return View::make('nhif.index', compact('nrates'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('nhif.create');
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), NhifRates::$rules,NhifRates::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$nrate = new NhifRates;

		$nrate->income_from = Input::get('i_from');

		$nrate->income_to = Input::get('i_to');

		$nrate->hi_amount = Input::get('amount');

        $nrate->organization_id = '1';

		$nrate->save();

		return Redirect::route('nhif.index');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$nrate = NhifRates::findOrFail($id);

		return View::make('nhif.show', compact('nrate'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$nrate = NhifRates::find($id);

		return View::make('nhif.edit', compact('nrate'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$nrate = NhifRates::findOrFail($id);

		$validator = Validator::make($data = Input::all(), NhifRates::$rules,NhifRates::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$nrate->income_from = Input::get('i_from');

		$nrate->income_to = Input::get('i_to');

		$nrate->hi_amount = Input::get('amount');

		$nrate->update();

		return Redirect::route('nhif.index');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		NhifRates::destroy($id);

		return Redirect::route('nhif.index');
	}

}
