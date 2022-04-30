<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ErpquotationitemsController extends \BaseController {

	/**
	 * Display a listing of erporderitems
	 *
	 * @return Response
	 */
	public function index()
	{
		$erpquotationitems = Erpquotationitem::all();

		return View::make('erpquotationitems.index', compact('erpquotationitems'));
	}

	/**
	 * Show the form for creating a new erporderitem
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('erpquotationitems.create');
	}

	/**
	 * Store a newly created erporderitem in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Erpquotationitem::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Erpquotationitem::create($data);

		return Redirect::route('erpquotationitems.index');
	}

	/**
	 * Display the specified erporderitem.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$erpquotationitem = Erpquotationitem::findOrFail($id);

		return View::make('erpquotationitems.show', compact('erpquotationitem'));
	}

	/**
	 * Show the form for editing the specified erporderitem.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$erpquotationitem = Erpquotationitem::find($id);

		return View::make('erpquotationitems.edit', compact('erpquotationitem'));
	}

	/**
	 * Update the specified erporderitem in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$erpquotationitem = Erpquotationitem::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Erpquotationitem::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$erpquotationitem->update($data);

		return Redirect::route('erpquotationitems.index');
	}

	/**
	 * Remove the specified erporderitem from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Erpquotationitem::destroy($id);

		return Redirect::route('erpquotationitems.index');
	}

}
