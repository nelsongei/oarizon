<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Leavetype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class LeavetypesController extends Controller {

	/*
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$leavetypes= Leavetype::where('organization_id',Auth::user()->organization_id)->get();
		return View::make('leavetypes.index',compact('leavetypes'));
	}


	/*
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('leavetypes.create');
	}


	/*
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
	$validator = Validator::make($data = $request->all(), Leavetype::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$leavetypes = new Leavetype;
        $leavetypes->name = $request->get('name');
		$leavetypes->days= $request->get('days');
		$leavetypes->organization_id = Auth::user()->organization_id;
		$leavetypes->save();

		return Redirect::route('leavetypes.index');	//
	}


	/*
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$leavetypes=Leavetype::findOrFail($id);
		return View::make('leavetypes.show',compact('leavetypes'));
	}


	/*
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$leavetype =Leavetype::find($id);
		return View::make('leavetypes.edit',compact('leavetype'));
	}


	/*
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
		$leavetype = Leavetype::findOrFail($id);
		$validator = Validator::make($data = $request->all(), Leavetype::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

        $leavetype->name = $request->get('name');
		$leavetype->days = $request->get('days');
		$leavetype->update();
		return Redirect::route('leavetypes.index');
	}


	/*
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Leavetype::destroy($id);

		return Redirect::route('leavetypes.index');
	}


}
