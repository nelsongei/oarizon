<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\BenefitSetting;
use App\Models\Employeebenefit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class BenefitSettingsController extends BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return \Illuminate\Contracts\View\View
     */
	public function index()
	{
		$benefits = Benefitsetting::where('organization_id',Auth::user()->organization_id)->get();


		Audit::logaudit(now('Africa/Nairobi'),Auth::user()->username,'Benefits');


		return View::make('benefitsettings.index', compact('benefits'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return \Illuminate\Contracts\View\View
     */
	public function create()
	{
		return View::make('benefitsettings.create');
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function store(Request $request)
	{
		$validator = Validator::make($data = request()->all(), Benefitsetting::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$benefit = new Benefitsetting;

		$benefit->benefit_name = request()->input('name');

                $benefit->organization_id = Auth::user()->organization_id;

		$benefit->save();

		Audit::logaudit(date('Y-m-d'),'Benefits', 'create', 'created: '.$benefit->benefit_name);


		return Redirect::route('benefitsettings.index')->withFlashMessage('Benefit successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Contracts\View\View
     */
	public function show($id)
	{
		$benefit = Benefitsetting::findOrFail($id);

		return View::make('benefitsettings.show', compact('benefit'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Contracts\View\View
     */
	public function edit($id)
	{
		$benefit = Benefitsetting::find($id);

		return View::make('benefitsettings.edit', compact('benefit'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function update($id)
	{
		$benefit = Benefitsetting::findOrFail($id);

		$validator = Validator::make($data = request()->all(), Benefitsetting::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$benefit->benefit_name = request()->input('name');
		$benefit->update();

		Audit::logaudit(date('Y-m-d'),'Benefits', 'update', 'updated: '.$benefit->benefit_name);

		return Redirect::route('benefitsettings.index')->withFlashMessage('Benefit successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$benefit = Benefitsetting::findOrFail($id);
		$empben  = Employeebenefit::where('benefit_id',$id)->count();
		if($empben>0){
			return Redirect::route('benefitsettings.index')->withDeleteMessage('Cannot delete this Benefit because its assigned to a job group!');
		}else{
		Benefitsetting::destroy($id);

		Audit::logaudit(date('Y-m-d'),'Benefits', 'delete', 'deleted: '.$benefit->benefit_name);

		return Redirect::route('benefitsettings.index')->withDeleteMessage('Benefit successfully deleted!');
	}
	}

}
