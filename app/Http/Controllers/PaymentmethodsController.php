<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paymentmethod;
use App\Models\Account;

class PaymentmethodsController extends Controller {

	/**
	 * Display a listing of paymentmethods
	 *
	 * @return Response
	 */
	public function index()
	{
		$paymentmethods = Paymentmethod::all();

		return view('paymentmethods.index', compact('paymentmethods'));
	}

	/**
	 * Show the form for creating a new paymentmethod
	 *
	 * @return Response
	 */
	public function create()
	{
		$accounts = Account::all();
		return view('paymentmethods.create',compact('accounts'));
	}

	/**
	 * Store a newly created paymentmethod in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Paymentmethod::$rules, Paymentmethod::$messages);

		if ($validator->fails())
		{
			return back()->withErrors($validator)->withInput();
		}

		$paymentmethod = new Paymentmethod;

		$paymentmethod->name = Input::get('name');
		$paymentmethod->account_id = Input::get('account');
		$paymentmethod->save();

		return redirect('paymentmethods.index')->with('success', 'Payment Method successfully created!');
	}

	/**
	 * Display the specified paymentmethod.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$paymentmethod = Paymentmethod::findOrFail($id);

		return view('paymentmethods.show', compact('paymentmethod'));
	}

	/**
	 * Show the form for editing the specified paymentmethod.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$paymentmethod = Paymentmethod::find($id);
        $accounts = Account::all();
		return view('paymentmethods.edit', compact('paymentmethod','accounts'));
	}

	/**
	 * Update the specified paymentmethod in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$paymentmethod = Paymentmethod::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Paymentmethod::$rules, Paymentmethod::$messages);

		if ($validator->fails())
		{
			return back()->withErrors($validator)->withInput();
		}

        $paymentmethod->name = Input::get('name');
		$paymentmethod->account_id = Input::get('account');
		$paymentmethod->update();

		return redirect('paymentmethods.index')->with('success', 'Payment Method successfully updated!');
	}

	/**
	 * Remove the specified paymentmethod from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Paymentmethod::destroy($id);

		return redirect('paymentmethods.index')->with('success', 'Payment Method successfully deleted!');
	}

}
