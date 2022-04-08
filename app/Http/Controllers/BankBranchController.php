<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Bank;
use App\Models\BBranch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class BankBranchController extends Controller {

	/*
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$bbranches = BBranch::all();

		Audit::logaudit(date('Y-m-d'), Auth::user()->username, 'view', 'viewed bank branches');

		return View::make('bank_branch.index', compact('bbranches'));
	}

	 public function import()
	{
		return View::make('banks.import');
	}

	/*
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		$banks = Bank::all();
		return View::make('bank_branch.create',compact('banks'));
	}

	/*
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($data = $request->all(), BBranch::$rules,BBranch::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$bbranch = new BBranch;

		$bbranch->bank_branch_name = $request->get('name');

		$bbranch->branch_code = $request->get('code');

		$bbranch->bank_id = $request->get('bank');

        $bbranch->organization_id = '1';

		$bbranch->save();

		Audit::logaudit(date('Y-m-d'), Auth::user()->username, 'create', 'created: '.$bbranch->bank_branch_name);

		return Redirect::route('bank_branch.index')->withFlashMessage('Bank Branch successfully created!');
	}

	/*
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$bbranch = BBranch::findOrFail($id);

		return View::make('bank_branch.show', compact('bbranch'));
	}

	/*
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$bbranch = BBranch::find($id);

		$banks = Bank::all();

		return View::make('bank_branch.edit', compact('bbranch','banks'));
	}

	/*
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
		$bbranch = BBranch::findOrFail($id);

		$validator = Validator::make($data = $request->all(), BBranch::$rules,BBranch::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$bbranch->bank_branch_name = $request->get('name');
		$bbranch->branch_code = $request->get('code');
		$bbranch->bank_id = $request->get('bank');
		$bbranch->update();

		Audit::logaudit(date('Y-m-d'), Auth::user()->username, 'update', 'updated: '.$bbranch->bank_branch_name);

		return Redirect::route('bank_branch.index')->withFlashMessage('Bank Branch successfully updated!');
	}

	/*
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$bbranch = BBranch::findOrFail($id);

		BBranch::destroy($id);

		Audit::logaudit(date('Y-m-d'), Auth::user()->username,'delete', 'deleted: '.$bbranch->bank_branch_name);

		return Redirect::route('bank_branch.index')->withDeleteMessage('Bank Branch successfully deleted!');

  }

}
