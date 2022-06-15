<?php namespace App\Http\Controllers;

use App\Models\Currency;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CurrenciesController extends Controller {

	/*
	 * Display a listing of currencies
	 *
	 * @return Response
	 */
	public function index()
	{
		$currencies = Currency::where('organization_id',Auth::user()->organization_id)->get();

		return View::make('currencies.index', compact('currencies'));
	}

	/*
	 * Show the form for creating a new currency
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('currencies.create');
	}

	/*
	 * Store a newly created currency in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($data = $request->all(), Currency::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$currency = new Currency;

		$currency->name = $request->get('name');
		$currency->shortname = $request->get('shortname');
        $currency->organization_id = Auth::user()->organization_id;
		$currency->save();

		return Redirect::route('currencies.index');
	}

	/*
	 * Display the specified currency.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$currency = Currency::findOrFail($id);

		return View::make('currencies.show', compact('currency'));
	}

	/*
	 * Show the form for editing the specified currency.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$currency = Currency::find($id);

		return View::make('currencies.edit', compact('currency'));
	}

	/*
	 * Update the specified currency in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
		$currency = Currency::findOrFail($id);

		$validator = Validator::make($data = $request->all(), Currency::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$currency->name = $request->get('name');
		$currency->shortname = $request->get('shortname');
		$currency->update();

		return Redirect::route('currencies.index');
	}

	/*
	 * Remove the specified currency from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Currency::destroy($id);

		return Redirect::route('currencies.index');
	}

}
