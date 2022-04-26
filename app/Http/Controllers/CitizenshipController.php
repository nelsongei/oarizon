<?php namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Citizenship;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CitizenshipController extends Controller {

    /*
     * Display a listing of branches
     *
     * @return Response
     */
    public function index()
    {
        $citizenships = Citizenship::whereNull('organization_id')
            ->orWhere('organization_id',Auth::user()->organization_id)->get();


        Audit::logaudit(date('Y-m-d'),Auth::user()->name, 'view', 'viewed citizenships');


        return View::make('citizenship.index', compact('citizenships'));
    }

    /*
     * Show the form for creating a new branch
     *
     * @return Response
     */
    public function create()
    {
        return View::make('citizenship.create');
    }

    /*
     * Store a newly created branch in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($data = $request->all(), Citizenship::$rules, Citizenship::$messsages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $citizenship = new Citizenship;

        $citizenship->name = $request->get('name');

        $citizenship->organization_id = Auth::user()->organization_id;

        $citizenship->save();

        Audit::logaudit(date('Y-m-d'),Auth::user()->name,'Citizenships', 'create');


        return Redirect::route('citizenships.index')->withFlashMessage('Citizenship successfully created!');
    }

    /*
     * Display the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $citizenship = Citizenship::findOrFail($id);

        return View::make('citizenship.show', compact('citizenship'));
    }

    /*
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $citizenship = Citizenship::find($id);

        return View::make('citizenship.edit', compact('citizenship'));
    }

    /*
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $citizenship = Citizenship::findOrFail($id);

        $validator = Validator::make($data = $request->all(), Citizenship::$rules, Citizenship::$messsages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $citizenship->name = $request->get('name');
        $citizenship->update();

        Audit::logaudit(date('Y-m-d'),Auth::user()->name, 'update', 'updated: '.$citizenship->name);

        return Redirect::route('citizenships.index')->withFlashMessage('Citizenship successfully updated!');
    }

    /*
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $citizenship = Citizenship::findOrFail($id);
        $citizen  = DB::table('employee')->where('citizenship_id',$id)->count();
        if($citizen > 0){
            return Redirect::route('citizenships.index')->withDeleteMessage('Cannot delete this citizenship because its assigned to an employee(s)!');
        }else{
            Citizenship::destroy($id);

            Audit::logaudit('Citizenships', 'delete', 'deleted: '.$citizenship->name);

            return Redirect::route('citizenships.index')->withDeleteMessage('Citizenship successfully deleted!');
        }
    }

}
