<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Models\Location;

class LocationsController extends Controller {

    /**
     * Display a listing of locations
     *
     * @return Response
     */
    public function index()
    {
        $locations = Location::all();

        return view('locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new location
     *
     * @return Response
     */
    public function create()
    {
        return view('locations.create');
    }

    /**
     * Store a newly created location in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make($data = Request::all(), Location::$rules);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $location = new Location;

        $location->name = Request::get('name');
        $location->description = Request::get('description');
        $location->save();

        return redirect('locations.index')->with('success', 'Store has been successfully created!');
    }

    /**
     * Display the specified location.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $location = Location::findOrFail($id);

        return view('locations.show', compact('location'));
    }

    /**
     * Show the form for editing the specified location.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $location = Location::find($id);

        return view('locations.edit', compact('location'));
    }

    /**
     * Update the specified location in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $location = Location::findOrFail($id);

        $validator = Validator::make($data = Request::all(), Location::$rules);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $location->name = Request::get('name');
        $location->description = Request::get('description');
        $location->update();

        return redirect('locations.index')->with('success', 'Store has been successfully updated!');

    }

    /**
     * Remove the specified location from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Location::destroy($id);


        return redirect('locations.index')->with('success', 'Store has been successfully removed!');

    }

}
