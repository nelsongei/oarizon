<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Bank;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class BanksController extends Controller {

    /*
     * Display a listing of branches
     *
     * @return Response
     */
    public function index()
    {
        $banks = Bank::where('organization_id',Auth::user()->organization_id)->get();

        Audit::logaudit(date('Y-m-d'), Auth::user()->username, 'view', 'viewed banks');

        return View::make('banks.index', compact('banks'));
    }

    /*
     * Show the form for creating a new branch
     *
     * @return Response
     */
    public function create()
    {
        return View::make('banks.create');
    }

    public function import()
    {
        return View::make('banks.import');
    }

    /*
     * Store a newly created branch in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($data = $request->all(), Bank::$rules,Bank::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $bank = new Bank;

        $bank->bank_name = $request->get('name');

        $bank->bank_code = $request->get('code');

        $bank->organization_id = Auth::user()->organization_id;

        $bank->save();

        Audit::logaudit(date('Y-m-d'), Auth::user()->username, 'create', 'created: '.$bank->bank_name);

        return Redirect::route('banks.index')->withFlashMessage('Bank successfully created!');
    }

    /*
     * Display the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $bank = Bank::findOrFail($id);

        return View::make('banks.show', compact('bank'));
    }

    /*
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $bank = Bank::find($id);

        return View::make('banks.edit', compact('bank'));
    }

    /*
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $bank = Bank::findOrFail($id);

        $validator = Validator::make($data = $request->all(), Bank::$rules, Bank::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $bank->bank_name = $request->get('name');
        $bank->bank_code = $request->get('code');
        $bank->update();

        Audit::logaudit(date('Y-m-d'), Auth::user()->username, 'update', 'updated: '.$bank->bank_name);

        return Redirect::route('banks.index')->withFlashMessage('Bank successfully updated!');
    }

    /*
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);
        $bc  = DB::table('bank_branches')->where('bank_id',$id)->count();
        if($bc>0){
            return Redirect::route('banks.index')->withDeleteMessage('Cannot delete this bank because its assigned to bank branch(es)!');
        }else{

            Bank::destroy($id);

            Audit::logaudit(date('Y-m-d'), Auth::user()->username,'Bank', 'delete', 'deleted: '.$bank->bank_name);
            return Redirect::route('banks.index')->withDeleteMessage('Bank successfully deleted!');
        }
    }

}
