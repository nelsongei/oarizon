<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Models\Client;
use App\Models\Erporder;

class ClientsController extends Controller {

    /**
     * Display a listing of clients
     *
     * @return Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        //$clients = Client::all();
        $customers = Client::where('type','Customer')->get();
        $suppliers = Client::where('type', 'Supplier')->get();
        $clientOrders = Erporder::where("status","!=","REJECTED")->where("type","invoice")->orWhere("type","sales")->get();
        $companyOrders = Erporder::where("status","!=","REJECTED")->where("type","purchases")->get();
        return view('clients.index', compact('customers', 'suppliers','clientOrders','companyOrders'));
    }


    /**
     * Show the form for creating a new client
     *
     * @return Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('clients.create');
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
            return redirect()->route('clients.index')->with('flash_message', 'station  successfully created!');
        else if(Request::get('type') == 'Supplier')
            return redirect()->route('clients.index')->with('flash_message', 'supplier  successfully added!');
    }

    /**
     * Display the specified client.
     *
     * @param  int  $id
     * @return Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);

        return view('clients.show', compact('client'));
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

        return view('clients.edit', compact('client'));
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

        return redirect()->route('clients.index')->with('success', 'Client successfully updated!');
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

        return redirect('clients.index')->with('error', 'Client successfully deleted!');
    }

}
