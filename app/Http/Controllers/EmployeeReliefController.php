<?php namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\ERelief;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Relief;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class EmployeeReliefController extends Controller {

	/**
	 * Display a listing of branches
	 *
	 * @return \Illuminate\Contracts\View\View
     */
	public function index()
	{
		$rels = DB::table('x_employee')
		          ->join('x_employee_relief', 'x_employee.id', '=', 'x_employee_relief.employee_id')
		          ->join('x_relief', 'x_employee_relief.relief_id', '=', 'x_relief.id')
		          ->where('in_employment','=','Y')
		          ->where('x_employee.organization_id',Auth::user()->organization_id)
		          ->select('x_employee_relief.id','first_name','middle_name','last_name','relief_amount','relief_name','percentage','premium')
		          ->get();
		Audit::logaudit(date('Y-m-d'),Auth::user()->username, 'view', 'viewed employee relief');
		return View::make('employee_relief.index', compact('rels'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return \Illuminate\Contracts\View\View
     */
	public function create()
	{

		$employees = DB::table('x_employee')
		          ->where('in_employment','=','Y')
		          ->where('x_employee.organization_id',Auth::user()->organization_id)
		          ->get();
		$reliefs = Relief::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->get();
		$currency = Currency::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->first();
		return View::make('employee_relief.create',compact('employees','reliefs','currency'));
	}

	public function createrelief()
	{
      $postrelief = request()->all();
      $data = array('relief_name' => $postrelief['name'],
      	            'organization_id' => Auth::user()->organization_id,
      	            'created_at' => DB::raw('NOW()'),
      	            'updated_at' => DB::raw('NOW()'));
      $check = DB::table('x_relief')->insertGetId( $data );

		if($check > 0){

		Audit::logaudit('Reliefs', 'create', 'created: '.$postrelief['name']);
        return $check;
        }else{
         return 1;
        }

	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function store()
	{
		$validator = Validator::make($data = request()->all(), ERelief::$rules, ERelief::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$rel = new ERelief;

		$rel->employee_id = request('employee');

		$rel->relief_id = request('relief');

		$rel->percentage = str_replace( '%', '', request('percentage'));

		$rel->premium = str_replace( ',', '', request('premium'));

		$a = str_replace( ',', '', request('amount') );

        $rel->relief_amount = $a;

		$rel->save();

		Audit::logaudit(date('Y-m-d'),Auth::user()->name,'Employee Reliefs',  'created: '.$rel->relief_amount.' for '.Employee::getEmployeeName(request('employee')));

		return Redirect::route('employee_relief.index')->withFlashMessage('Employee Relief successfully created!');
	}


	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Contracts\View\View
     */
	public function show($id)
	{
		$rel = ERelief::findOrFail($id);

		return View::make('employee_relief.show', compact('rel'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Contracts\View\View
     */
	public function edit($id)
	{

		$rel = ERelief::find($id);
		$employees = Employee::where('x_employee.organization_id',Auth::user()->organization_id)->get();
                $reliefs = Relief::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->get();
                $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->first();
		return View::make('employee_relief.edit', compact('rel','employees','reliefs','currency'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function update($id)
	{
		$rel = ERelief::findOrFail($id);

		$validator = Validator::make($data = request()->all(), ERelief::$rules, ERelief::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$rel->relief_id = request('relief');

		$rel->percentage = str_replace( '%', '', request('percentage'));

		$rel->premium = str_replace( ',', '', request('premium'));

        $a = str_replace( ',', '', request('amount') );

        $rel->relief_amount = $a;

		$rel->update();

		Audit::logaudit(date('Y-m-d'),Auth::user()->name,'Employee Reliefs',  'updated: '.$rel->relief_amount.' for '.Employee::getEmployeeName($rel->employee_id));

		return Redirect::route('employee_relief.index')->withFlashMessage('Employee Relief successfully updated!');
	}


	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$rel = ERelief::findOrFail($id);
		ERelief::destroy($id);
        Audit::logaudit('Employee Reliefs', 'delete', 'deleted: '.$rel->relief_amount.' for '.Employee::getEmployeeName($rel->employee_id));
		return Redirect::route('employee_relief.index')->withDeleteMessage('Employee Relief successfully deleted!');
	}

	public function view($id){

		$rel = DB::table('x_employee')
		          ->join('x_employee_relief', 'x_employee.id', '=', 'x_employee_relief.employee_id')
		          ->join('x_relief', 'x_employee_relief.relief_id', '=', 'x_relief.id')
		          ->where('x_employee_relief.id','=',$id)
		          ->where('x_employee.organization_id',Auth::user()->organization_id)
		          ->select('x_employee_relief.id','first_name','last_name','relief_amount','relief_name','middle_name','photo','signature','premium','percentage')
		          ->first();

		$organization = Organization::find(Auth::user()->organization_id);

		return View::make('employee_relief.view', compact('rel'));

	}

}
