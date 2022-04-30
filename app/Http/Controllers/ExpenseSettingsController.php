<?php

class ExpenseSettingsController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$expenses = Expensesetting::where('id','>',1)->where('organization_id',Confide::user()->organization_id)->get();

		Audit::logaudit('Expensesettings', 'view', 'viewed expensesettings');

		return View::make('expensesettings.index', compact('expenses'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('expensesettings.create');
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Expensesetting::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$expense = new Expensesetting;

		$expense->name = Input::get('name');
		$expense->organization_id = Confide::user()->organization_id;
		$expense->save();

        Audit::logaudit('Expensesettings', 'create', 'created: '.$expense->name);
		return Redirect::route('expensesettings.index')->withFlashMessage('Expense type successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$expense = Expensesetting::findOrFail($id);

		return View::make('expensesettings.show', compact('expense'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$expense = Expensesetting::find($id);

		return View::make('expensesettings.edit', compact('expense'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$expense = Expensesetting::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Expensesetting::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$expense->name = Input::get('name');
		$expense->update();

        Audit::logaudit('Expensesettings', 'update', 'updated: '.$expense->name);
		return Redirect::route('expensesettings.index')->withFlashMessage('Expense type successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$expense = Expensesetting::findOrFail($id);
		$exp  = DB::table('expenses')->where('expensesetting_id',$id)->count();
		$budget  = DB::table('budget')->where('expensesetting_id',$id)->count();
		if($exp>0 && $budget>0){
			return Redirect::route('expensesettings.index')->withDeleteMessage('Cannot delete this expense type because its assigned to an expense and a budget!');
		}else if($exp>0){
            return Redirect::route('expensesettings.index')->withDeleteMessage('Cannot delete this expense type because its assigned to an expense!');
		}else if($budget>0){
            return Redirect::route('expensesettings.index')->withDeleteMessage('Cannot delete this expense type because its assigned to a budget!');
		}else{
		
		Expensesetting::destroy($id);
        Audit::logaudit('Expensesettings', 'delete', 'deleted: '.$expense->name);
		return Redirect::route('expensesettings.index')->withDeleteMessage('Expense type successfully deleted!');
	}
}

}
