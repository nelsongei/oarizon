<?php namespace App\Http\Controllers;

use App\models\Audit;
use App\models\BenefitSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class BenefitsController extends Controller {

    /**
     * Display a listing of branches
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $benefits = BenefitSetting::where('organization_id',Auth::user()->organization_id)->get();


        Audit::logaudit('Benefits', 'view', 'viewed benefits');


        return View::make('benefitsettings.index', compact('benefits'));
    }

    /**
     * Show the form for creating a new branch
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('benefitsettings.create');
    }

    /**
     * Store a newly created branch in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $validator = Validator::make($data = Input::all(), Benefitsetting::$rules, Benefitsetting::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $benefit = new Benefitsetting;

        $benefit->benefit_name = Input::get('name');

        $benefit->organization_id = Auth::user()->organization_id;

        $benefit->save();

        Audit::logaudit('Benefits', 'create', 'created: '.$benefit->benefit_name);


        return Redirect::route('benefitsettings.index')->withFlashMessage('Benefit successfully created!');
    }

    /**
     * Display the specified branch.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $benefit = Benefitsetting::findOrFail($id);

        return View::make('benefitsettings.show', compact('benefit'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $benefit = Benefitsetting::find($id);

        return View::make('benefitsettings.edit', compact('benefit'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $benefit = Benefitsetting::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Benefitsetting::$rules, Benefitsetting::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $benefit->benefit_name = Input::get('name');
        $benefit->update();

        Audit::logaudit('Benefits', 'update', 'updated: '.$benefit->benefit_name);

        return Redirect::route('benefitsettings.index')->withFlashMessage('Benefit successfully updated!');
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $benefit = Benefitsetting::findOrFail($id);
        Benefitsetting::destroy($id);

        Audit::logaudit('Benefits', 'delete', 'deleted: '.$benefit->benefit_name);

        return Redirect::route('benefitsettings.index')->withDeleteMessage('Benefit successfully deleted!');
    }

}
