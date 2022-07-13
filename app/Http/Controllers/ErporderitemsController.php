<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Models\Erporderitem;

class ErporderitemsController extends Controller {

	/**
	 * Display a listing of erporderitems
	 *
	 * @return Response
	 */
	public function index()
	{
		$erporderitems = Erporderitem::all();

		return view('erporderitems.index', compact('erporderitems'));
	}

	/**
	 * Show the form for creating a new erporderitem
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('erporderitems.create');
	}

	/**
	 * Store a newly created erporderitem in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Erporderitem::$rules);

		if ($validator->fails())
		{
			return back()->withErrors($validator)->withInput();
		}

		Erporderitem::create($data);

		
		return redirect('erporderitems.index');
	}

	/**
	 * Display the specified erporderitem.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$erporderitem = Erporderitem::findOrFail($id);

		return view('erporderitems.show', compact('erporderitem'));
	}

	/**
	 * Show the form for editing the specified erporderitem.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$erporderitem = Erporderitem::find($id);

		return view('erporderitems.edit', compact('erporderitem'));
	}

	/**
	 * Update the specified erporderitem in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$erporderitem = Erporderitem::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Erporderitem::$rules);

		if ($validator->fails())
		{
			return back()->withErrors($validator)->withInput();
		}

		$erporderitem->update($data);

		return redirect('erporderitems.index');
	}

	/**
	 * Remove the specified erporderitem from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Erporderitem::destroy($id);

		return redirect('erporderitems.index');
	}

}
