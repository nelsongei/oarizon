<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ErpquotationsController extends \BaseController {

	/**
	 * Display a listing of erppurchases
	 *
	 * @return Response
	 */
	public function index()
	{
		$erpquotations = Erpquotation::all();
		$orders = Erporder::all();
		$invoices = Invoice::all();

		return View::make('erpquotations.index', compact('erpquotations','orders', 'invoices'));
	}

	/**
	 * Show the form for creating a new erporder
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('erpquotations.create');
	}

	/**
	 * Store a newly created erporder in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Erpquotation::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Erpquotation::create($data);

		return Redirect::route('erpquotations.index');
	}

	/**
	 * Display the specified erporder.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$erpquotation = Erpquotation::findOrFail($id);

		return View::make('erpquotations.show', compact('erpquotation'));
	}

	/**
	 * Show the form for editing the specified erporder.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$erpquotation = Erpquotation::find($id);

		return View::make('erpquotations.edit', compact('erpquotation'));
	}

	/**
	 * Update the specified erporder in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$erpquotation = Erpquotation::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Erpquotation::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$erpquotation->update($data);

		return Redirect::route('erpquotations.index');
	}

	/**
	 * Remove the specified erporder from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Erpquotation::destroy($id);

		return Redirect::route('erpquotations.index');
	}

}
