<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ErppurchaseitemsController extends \BaseController {

	/**
	 * Display a listing of erporderitems
	 *
	 * @return Response
	 */
	public function index()
	{
		$erppurchaseitems = Erppurchaseitem::all();

		return View::make('erppurchaseitems.index', compact('erppurchaseitems'));
	}

	/**
	 * Show the form for creating a new erporderitem
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('erppurchaseitems.create');
	}

	/**
	 * Store a newly created erporderitem in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Erppurchaseitem::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Erppurchaseitem::create($data);

		return Redirect::route('erppurchaseitems.index');
	}

	/**
	 * Display the specified erporderitem.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$erppurchaseitem = Erppurchaseitem::findOrFail($id);

		return View::make('erppurchaseitems.show', compact('erppurchaseitem'));
	}

	/**
	 * Show the form for editing the specified erporderitem.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$erppurchaseitem = Erppurchaseitem::find($id);

		return View::make('erppurchaseitems.edit', compact('erppurchaseitem'));
	}

	/**
	 * Update the specified erporderitem in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$erppurchaseitem = Erppurchaseitem::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Erppurchaseitem::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$erppurchaseitem->update($data);

		return Redirect::route('erppurchaseitems.index');
	}

	/**
	 * Remove the specified erporderitem from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Erppurchaseitem::destroy($id);

		return Redirect::route('erppurchaseitems.index');
	}

}
