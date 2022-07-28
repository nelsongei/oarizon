<?php namespace App\Http\Controllers;

use App\Models\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AuditsController extends Controller {

    /*
     * Display a listing of audits
     *
     * @return Response
     */
    public function index()
    {
        $audits = Audit::where('organization_id',Auth::user()->organization_id)->orderBy('id', 'DESC')->simplepaginate(10);
        return View::make('audits.index', compact('audits'));
    }

    /*
     * Show the form for creating a new audit
     *
     * @return Response
     */
    public function create()
    {
        return View::make('audits.create');
    }

    /*
     * Store a newly created audit in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($data = $request->all(), Audit::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Audit::create($data);

        return Redirect::route('audits.index');
    }

    /*
     * Display the specified audit.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $audit = Audit::findOrFail($id);

        return View::make('audits.show', compact('audit'));
    }

    /*
     * Show the form for editing the specified audit.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $audit = Audit::find($id);

        return View::make('audits.edit', compact('audit'));
    }

    /*
     * Update the specified audit in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $audit = Audit::findOrFail($id);

        $validator = Validator::make($data = $request->all(), Audit::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $audit->update($data);

        return Redirect::route('audits.index');
    }

    /*
     * Remove the specified audit from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Audit::destroy($id);

        return Redirect::route('audits.index');
    }

}
