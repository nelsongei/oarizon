<?php namespace App\Http\Controllers;

use App\Models\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class BranchesController extends Controller {

    /*
     * Display a listing of branches
     *
     * @return Response
     */
    public function index()
    {
        $branches = Branch::where('organization_id',Auth::user()->organization_id)->get();
        return View::make('branches.index', compact('branches'));
    }

    /*
     * Show the form for creating a new branch
     *
     * @return Response
     */
    public function create()
    {
        return View::make('branches.create');
    }

    /*
     * Store a newly created branch in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($data = $request->all(), Branch::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $branch = new Branch;

        $branch->name = $request->get('name');
        $branch->organization_id = Auth::user()->organization_id;
        $branch->save();

        return Redirect::route('branches.index');
    }

    /*
     * Display the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $branch = Branch::findOrFail($id);

        return View::make('branches.show', compact('branch'));
    }

    /*
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $branch = Branch::find($id);

        return View::make('branches.edit', compact('branch'));
    }

    /*
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $branch = Branch::findOrFail($id);

        $validator = Validator::make($data = $request->all(), Branch::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $branch->name = $request->get('name');
        $branch->organization_id = Auth::user()->organization_id;
        $branch->update();

        return Redirect::route('branches.index');
    }

    /*
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Branch::destroy($id);
        return Redirect::route('branches.index');
    }

}
