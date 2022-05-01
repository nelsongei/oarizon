<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Stations;
use Illuminate\Support\Facades\Auth;

class StationsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function index()
	{
		$stations = Stations::where('organization_id',Auth::user()->organization_id)->get();
		return view('stations.index', compact('stations'));
	}


	/**
	 * Show the form for creating a new station.
	 *
	 * @return Response
	 */
	public function create()
	{
		$stations = Stations::where('organization_id',Auth::user()->organization_id)->get();
		return view('stations.create', compact('stations'));
	}


	/**
	 * Store a newly created station in storage.
	 *
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function store()
	{
		$validator = Validator::make($data = Request::all(), Stations::$rules);

		if ($validator->fails())
		{
			return back()->withErrors($validator)->withInput();
		}

		$stations = new Stations;

		$stations->station_name = Request::get('station_name');
		$stations->location = Request::get('location');
		$stations->description = Request::get('description');
		$stations->organization_id = Auth::user()->organization_id;
		$stations->save();

		return redirect()->route('stations.index')->with('flash_message', 'Station has been successfully created!');
	}


	/**
	 * Display the specified station.
	 *
	 * @param  int  $id
	 * @return Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function show($id)
	{
		$stations = Stations::findOrFail($id);

		return view('stations.show', compact('stations'));
	}


	/**
	 * Show the form for editing the specified station.
	 *
	 * @param  int  $id
	 * @return Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
	 */
	public function edit($id)
	{
		$stations = Stations::find($id);

		return view('stations.edit', compact('stations'));
	}


	/**
	 * Update the specified station in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$stations = Stations::findOrFail($id);

		$validator = Validator::make($data = Request::all(), Stations::$rules);

		if ($validator->fails())
		{
			return back()->withErrors($validator)->withInput();
		}

		$stations->station_name = Request::get('station_name');
		$stations->location = Request::get('location');
		$stations->description = Request::get('description');
		$stations->update();

		return redirect()->route('stations.index')->with('flash_message', 'Station has been successfully updated!');

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Stations::destroy($id);


		return redirect('stations.index')->with('flash_message', 'Station has been successfully Deleted!');
	}


	public function assign($id){

    return view('stations.assign', compact('stations'));
	}


}
