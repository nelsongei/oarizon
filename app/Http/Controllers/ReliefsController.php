<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Relief;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ReliefsController extends Controller {

    /**
     * Display a listing of branches
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $reliefs = Relief::all();

        return View::make('reliefs.index', compact('reliefs'));
    }

    /**
     * Show the form for creating a new branch
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('reliefs.create');
    }

    /**
     * Store a newly created branch in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $validator = Validator::make($data = request()->all(), Relief::$rules,Relief::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $relief = new Relief;

        $relief->relief_name = request('name');

        $relief->organization_id = '1';

        $relief->save();

        return Redirect::route('reliefs.index');
    }

    /**
     * Display the specified branch.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $relief = Relief::findOrFail($id);

        return View::make('reliefs.show', compact('relief'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $relief = Relief::find($id);

        return View::make('reliefs.edit', compact('relief'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $relief = Relief::findOrFail($id);

        $validator = Validator::make($data = request()->all(), Relief::$rules,Relief::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $relief->relief_name = Input::get('name');
        $relief->update();

        return Redirect::route('reliefs.index');
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Relief::destroy($id);

        return Redirect::route('reliefs.index');
    }

}
