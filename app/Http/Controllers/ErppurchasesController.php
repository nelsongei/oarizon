<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ErppurchasesController extends \BaseController {

	/**
	 * Display a listing of erppurchases
	 *
	 * @return Response
	 */
	public function index()
	{
		$erppurchases = Erppurchase::all();
		$orders = Erporder::all();

		return View::make('erppurchases.index', compact('erppurchases','orders'));
	}

	/**
	 * Show the form for creating a new erporder
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('erppurchases.create');
	}

	/**
	 * Store a newly created erporder in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Erppurchase::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Erppurchase::create($data);

		return Redirect::route('erppurchases.index');
	}

	/**
	 * Display the specified erporder.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$erppurchase = Erppurchase::findOrFail($id);

		return View::make('erppurchases.show', compact('erppurchase'));
	}


	// public function payment($id)
	// {
	// 	$erppurchase = Erppurchase::findOrFail($id);

	// 	return View::make('erppurchases.payment', compact('erppurchase'));
	// }

	/**
	 * Show the form for editing the specified erporder.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$erppurchase = Erppurchase::find($id);

		return View::make('erppurchases.edit', compact('erppurchase'));
	}

	/**
	 * Update the specified erporder in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$erppurchase = Erppurchase::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Erppurchase::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$erppurchase->update($data);

		return Redirect::route('erppurchases.index');
	}

	/**
	 * Remove the specified erporder from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Erppurchase::destroy($id);

		return Redirect::route('erppurchases.index');
	}



	public function payment($id){

     	$payments = Payment::all();

		$purchase = Purchase::findOrFail($id);

		$account = Account::all();

		return View::make('erppurchases.payment', compact('payments', 'purchase', 'account'));
	}

}
