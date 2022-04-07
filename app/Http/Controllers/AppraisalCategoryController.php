<?php namespace App\Http\Controllers;

use App\models\Appraisalcategory;
use App\models\Audit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AppraisalCategoryController extends Controller {

	/**
	 * Display a listing of branches
	 *
	 * @return \Illuminate\Contracts\View\View
     */
	public function index()
	{
		$categories = Appraisalcategory::whereNull('organization_id')
		->orWhere('organization_id',Auth::user()->organization_id)->get();


		Audit::logaudit(now('Africa/Nairobi'),Auth::user()->username, 'view', 'viewed appraisal categories');


		return View::make('appraisalcategories.index', compact('categories'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return \Illuminate\Contracts\View\View
     */
	public function create()
	{
		return View::make('appraisalcategories.create');
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function store()
	{
		$validator = Validator::make($data = request()->all(), Appraisalcategory::$rules, Appraisalcategory::$messsages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$category = new Appraisalcategory;

		$category->name = Input::get('name');

        $category->organization_id = Auth::user()->organization_id;

		$category->save();

		Audit::logaudit('Appraisalcategories', 'create', 'created: '.$category->name);


		return Redirect::route('appraisalcategories.index')->withFlashMessage('Appraisal category successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Contracts\View\View
     */
	public function show($id)
	{
		$category = Appraisalcategory::findOrFail($id);

		return View::make('appraisalcategories.show', compact('category'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Contracts\View\View
     */
	public function edit($id)
	{
		$category = Appraisalcategory::find($id);

		return View::make('appraisalcategories.edit', compact('category'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function update($id)
	{
		$category = Appraisalcategory::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Appraisalcategory::$rules, Appraisalcategory::$messsages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$category->name = Input::get('name');
		$category->update();

		Audit::logaudit('Appraisalcategories', 'update', 'updated: '.$category->name);

		return Redirect::route('appraisalcategories.index')->withFlashMessage('Appraisal category successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$category = Appraisalcategory::findOrFail($id);

		$app  = DB::table('Appraisalquestions')->where('Appraisalcategory_id',$id)->count();
		if($app>0){
			return Redirect::route('appraisalcategories.index')->withDeleteMessage('Cannot delete this appraisal category because its assigned to appraisal question(s)!');
		}else{
		Appraisalcategory::destroy($id);

		Audit::logaudit('Appraisalcategories', 'delete', 'deleted: '.$category->name);

		return Redirect::route('appraisalcategories.index')->withDeleteMessage('Appraisal category successfully deleted!');
	}
 }

}
