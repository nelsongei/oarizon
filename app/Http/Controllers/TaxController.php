<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tax;

class TaxController extends Controller {

    /**
     * Display a listing of branches
     *
     * @return Response
     */
    public function index()
    {
        $taxes = Tax::all();

        return view('taxes.index', compact('taxes'));
    }

    /**
     * Show the form for creating a new branch
     *
     * @return Response
     */
    public function create()
    {
        return view('taxes.create');
    }

    /**
     * Store a newly created branch in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make($data = Request::all(), Tax::$rules,Tax::$messages);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $tax = new Tax;

        $tax->name = Request::get('name');

        $tax->rate = Request::get('rate');

        $tax->save();

        return redirect('taxes.index')->with('flash_message', 'Tax successfully created!');
    }

    /**
     * Display the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $tax = Tax::findOrFail($id);

        return view('taxes.show', compact('tax'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $tax = Tax::find($id);

        return view('taxes.edit', compact('tax'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $tax = Tax::findOrFail($id);

        $validator = Validator::make($data = Request::all(), Tax::$rules, Tax::$messages);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $tax->name = Request::get('name');
        $tax->rate = Request::get('rate');
        $tax->update();

        return redirect('taxes.index')->with('flash_message', 'Tax successfully updated!');
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Tax::destroy($id);

        return redirect('taxes.index')->with('error', 'Tax successfully deleted!');
    }

}
