<?php
namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Audit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AllowancesController extends Controller {

	/**
	 * Display a listing of branches
	 *
	 * @return \Illuminate\Contracts\View\View
     */
	public function index()
	{
		$allowances = Allowance::all();
		return View::make('allowances.index', compact('allowances'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return \Illuminate\Contracts\View\View
     */
	public function create()
	{
		return View::make('allowances.create');
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function store()
	{
		$validator = Validator::make($data = request()->all(), Allowance::$rules, Allowance::$messsages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$allowance = new Allowance;

		$allowance->allowance_name = request('name');

        $allowance->organization_id = '1';

		$allowance->save();

		Audit::logaudit(date('Y-m-d'),Auth::user()->name,'Allowances', 'create',);


		return Redirect::route('allowances.index');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Contracts\View\View
     */
	public function show($id)
	{
		$allowance = Allowance::findOrFail($id);

		return View::make('allowances.show', compact('allowance'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Contracts\View\View
     */
	public function edit($id)
	{
		$allowance = Allowance::find($id);

		return View::make('allowances.edit', compact('allowance'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function update($id)
	{
		$allowance = Allowance::findOrFail($id);

		$validator = Validator::make($data = request()->all(), Allowance::$rules, Allowance::$messsages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$allowance->allowance_name = request('name');
		$allowance->update();

		Audit::logaudit(date('Y-m-d'),Auth()->user()->name,'Allowances', 'update');

		return Redirect::route('allowances.index');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function destroy($id)
	{
		$allowance = Allowance::findOrFail($id);
		Allowance::destroy($id);

		Audit::logaudit(date('Y-m-d'),Auth::user()->name,'Allowances', 'delete');

		return Redirect::route('allowances.index');
	}

}
