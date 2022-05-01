<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Models\Client;
use App\Models\Erporder;

class SuppliersController extends Controller
{
    /** 
	 * Display a listing of clients
	 *
	 * @return Response
	 */
	public function index()
	{  
		//$clients = Client::all();   
		$customers = Client::where('type','Customer')->get();
		$suppliers = Client::where('type', 'Supplier')->get();
		$clientOrders = Erporder::where("status","!=","REJECTED")->where("type","invoice")->orWhere("type","sales")->get();
		$companyOrders = Erporder::where("status","!=","REJECTED")->where("type","purchases")->get(); 
		return view('suppliers.index', compact('customers', 'suppliers','clientOrders','companyOrders'));
	} 
  

	/**
	 * Show the form for creating a new client
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('suppliers.create');
	}


	/*public function supply()
	{
		return View::make('clients.create2');
	}*/

	/**
	 * Store a newly created client in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Request::all(), Client::$rules, Client::$messages);

		if ($validator->fails())
		{
			return back()->withErrors($validator)->withInput();
		}

		$client = new Client;

		$client->name = Request::get('name');
		$client->date = date('Y-m-d');
		$client->contact_person = Request::get('cname');
		$client->email = Request::get('email_office');
		$client->contact_person_email = Request::get('email_personal');
		$client->contact_person_phone = Request::get('mobile_phone');
		$client->phone = Request::get('office_phone');
		$client->address = Request::get('address');
		$client->type = Request::get('type'); 
		$client->save();

		if(Request::get('type') == 'Customer')
		return redirect('suppliers.index')->with('success', 'station  successfully created!');
	    elseif(Request::get('type') == 'Supplier')
	    return redirect('suppliers.index')->with('success', 'supplier  successfully added!');
	}

	/**
	 * Display the specified client.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$client = Client::findOrFail($id);

		return view('suppliers.show', compact('client'));
	}

	/**
	 * Show the form for editing the specified client.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$client = Client::find($id);

		return view('suppliers.edit', compact('client'));
	}

	/**
	 * Update the specified client in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$client = Client::findOrFail($id);

		$validator = Validator::make($data = Request::all(), Client::rolesUpdate($client->id), Client::$messages);

		if ($validator->fails())
		{
			return back()->withErrors($validator)->withInput();
		}

		$client->name = Request::get('name');
		$client->contact_person = Request::get('cname');
		$client->email = Request::get('email_office');
		$client->contact_person_email = Request::get('email_personal');
		$client->contact_person_phone = Request::get('mobile_phone');
		$client->phone = Request::get('office_phone');
		$client->address = Request::get('address');
		$client->type = Request::get('type');
		$client->save();

		$client->update();

		return redirect('suppliers.index')->with('success', 'Client successfully updated!');
	}

	/**
	 * Remove the specified client from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Client::destroy($id);

		return redirect('suppliers.index')->with('error', 'Client successfully deleted!');
	}
}
