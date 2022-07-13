<?php
namespace App\Http\Controllers;

use App\Models\NhifRates;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class NhifController extends BaseController {

    /**
     * Display a listing of branches
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $nrates = DB::table('x_hospital_insurance')->get();
//		$nrates = DB::table('x_hospital_insurance')->where('income_from', '!=', 0)->get();
//        dd($nrates);

        return View::make('nhif.index', compact('nrates'));
    }

    /**
     * Show the form for creating a new branch
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('nhif.create');
    }

    /**
     * Store a newly created branch in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
//        dd(request('amount'));
        $validator = Validator::make($data = request()->all(), NhifRates::$rules,NhifRates::$messages);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $nrate = new NhifRates;

        $nrate->income_from = request('i_from');

        $nrate->income_to = request('i_to');

        $nrate->hi_amount = request('amount');

        $nrate->organization_id = '1';

        $nrate->save();

//		return Redirect::route('nhif.index');
        return redirect()->route('nhif.index');
    }

    /**
     * Display the specified branch.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $nrate = NhifRates::findOrFail($id);

        return View::make('nhif.show', compact('nrate'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $nrate = NhifRates::find($id);

        return View::make('nhif.edit', compact('nrate'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $nrate = NhifRates::findOrFail($id);

        $validator = Validator::make($data = request()->all(), NhifRates::$rules,NhifRates::$messages);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $nrate->income_from = request('i_from');

        $nrate->income_to = request('i_to');

        $nrate->hi_amount = request('amount');

        $nrate->update();

        return redirect()->route('nhif.index');
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        NhifRates::destroy($id);

        return redirect()->route('nhif.index');
    }

}
