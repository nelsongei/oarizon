<?php namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class HolidaysController extends Controller {

	/*
	 * Display a listing of holidays
	 *
	 * @return Response
	 */
	public function index()
	{
		$holidays = Holiday::all();

		return view('holidays.index', compact('holidays'));
	}

	/*
	 * Show the form for creating a new holiday
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('holidays.create');
	}

	/*
	 * Store a newly created holiday in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($data = $request->all(), Holiday::$rules);

		if ($validator->fails())
		{
			return redirect()->back()->withErrors($validator)->withInput();
		}

		Holiday::createHoliday($data);

		return route('holidays.index');
	}

	/*
	 * Display the specified holiday.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$holiday = Holiday::findOrFail($id);

		return view('holidays.show', compact('holiday'));
	}

	/*
	 * Show the form for editing the specified holiday.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$holiday = Holiday::find($id);

		return view('holidays.edit', compact('holiday'));
	}

	/*
	 * Update the specified holiday in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
		$holiday = Holiday::findOrFail($id);

		$validator = Validator::make($data = $request->all(), Holiday::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Holiday::updateHoliday($data, $id);

		return Redirect::route('holidays.index');
	}

	/*
	 * Remove the specified holiday from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Holiday::destroy($id);

		return Redirect::route('holidays.index');
	}

}
