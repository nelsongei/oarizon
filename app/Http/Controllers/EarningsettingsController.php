<?php namespace App\Http\Controllers;

use App\Audit;
use App\Earningsetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class EarningsettingsController extends Controller {

    /**
     * Display a listing of branches
     *
     * @return Response
     */
    public function index()
    {
        $earnings = Earningsetting::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->get();


        Audit::logaudit('EarningSettings', 'view', 'viewed allowances');


        return View::make('earningsettings.index', compact('earnings'));
    }

    /**
     * Show the form for creating a new branch
     *
     * @return Response
     */
    public function create()
    {
        return View::make('earningsettings.create');
    }

    /**
     * Store a newly created branch in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make($data = Input::all(), Earningsetting::$rules, Earningsetting::$messsages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $earning = new Earningsetting;

        $earning->earning_name = Input::get('name');

        $earning->organization_id = Auth::user()->organization_id;

        $earning->save();

        Audit::logaudit('EarningSettings', 'create', 'created: '.$earning->earning_name);


        return Redirect::route('earningsettings.index')->withFlashMessage('Earning type successfully created!');
    }

    /**
     * Display the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $earning = Earningsetting::findOrFail($id);

        return View::make('earningsettings.show', compact('earning'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $earning = Earningsetting::find($id);

        return View::make('earningsettings.edit', compact('earning'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $earning = Earningsetting::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Earningsetting::$rules, Earningsetting::$messsages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $earning->earning_name = Input::get('name');
        $earning->update();

        Audit::logaudit('EarningSettings', 'update', 'updated: '.$earning->earning_name);

        return Redirect::route('earningsettings.index')->withFlashMessage('Earning type successfully updated!');
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $earning = Earningsetting::findOrFail($id);
        $earn  = DB::table('earnings')->where('earning_id',$id)->count();
        if($earn>0){
            return Redirect::route('earningsettings.index')->withDeleteMessage('Cannot delete this earning because its assigned to an employee(s)!');
        }else{

            Earningsetting::destroy($id);

            Audit::logaudit('EarningSettings', 'delete', 'deleted: '.$earning->earning_name);

            return Redirect::route('earningsettings.index')->withDeleteMessage('Earning type successfully deleted!');
        }
    }

}
