<?php namespace App\Http\Controllers;

use App\models\Allowance;
use App\models\Audit;
use App\models\Currency;
use App\models\EAllowances;
use App\models\Employee;
use App\models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class EmployeeAllowancesController extends Controller {

	/*
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$eallws = DB::table('x_employee_allowances')
		          ->join('x_employee', 'x_employee_allowances.employee_id', '=', 'x_employee.id')
		          ->join('x_allowances', 'x_employee_allowances.allowance_id', '=', 'x_allowances.id')
		          ->where('in_employment','=','Y')
		          ->where('x_employee.organization_id',Auth::user()->organization_id)
		          ->select('x_employee_allowances.id','first_name','middle_name','last_name','allowance_amount','allowance_name')
		          ->get();

		Audit::logaudit(date('Y-m-d'),Auth::user()->username,'viewed employee allowances','Employee Allowances',0);


		return View::make('employee_allowances.index', compact('eallws'));
	}

	/*
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */

    public function createallowance(Request $request)
	{
      $postallowance = $request->all();
      $data = array('allowance_name' => $postallowance['name'],
      	            'organization_id' => Auth::user()->organization_id,
      	            'created_at' => DB::raw('NOW()'),
      	            'updated_at' => DB::raw('NOW()'));
      $check = DB::table('allowances')->insertGetId( $data );
      $date = date('Y-m-d');
      $user = Auth::user()->username;



		if($check > 0){

		Audit::logaudit($date ,$user,'Allowances', 'create', 'created: '.$postallowance['name']);

        return $check;
        }else{
         return 1;
        }

	}

	public function create()
	{

		$employees = DB::table('x_employee')
		          ->where('in_employment','=','Y')
		          ->where('x_employee.organization_id',Auth::user()->organization_id)
		          ->get();
		$allowances = Allowance::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->get();
		$currency = Currency::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->first();
		return View::make('employee_allowances.create',compact('employees','allowances','currency'));
	}


	public function display(){

      $allw = Allowance::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->orderBy('id','DESC')->first();

      return json_encode(array("id"=>$allw->id,"name"=>$allw->allowance_name));
      exit();

    }

	/*
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($data = $request->all(), EAllowances::$rules, EAllowances::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$allowance = new EAllowances;

		$allowance->employee_id = $request->get('employee');

		$allowance->allowance_id = $request->get('allowance');

        $allowance->formular = $request->get('formular');

		if($request->get('formular') == 'Instalments'){
		$allowance->instalments = $request->get('instalments');
        $insts = $request->get('instalments');

		$a = str_replace( ',', '', $request->get('amount') );

        $allowance->allowance_amount = $a;

        $d=strtotime($request->get('adate'));

        $allowance->allowance_date = date("Y-m-d", $d);

        $effectiveDate = date('Y-m-d', strtotime("+".($insts-1)." months", strtotime($request->get('adate'))));

        $First  = date('Y-m-01', strtotime($request->get('adate')));
        $Last   = date('Y-m-t', strtotime($effectiveDate));

        $allowance->first_day_month = $First;

        $allowance->last_day_month = $Last;

	    }else{
	    $allowance->instalments = '1';
        $a = str_replace( ',', '', $request->get('amount') );

        $allowance->allowance_amount = $a;

        $d=strtotime($request->get('adate'));

        $allowance->allowance_date = date("Y-m-d", $d);

        $First  = date('Y-m-01', strtotime($request->get('adate')));
        $Last   = date('Y-m-t', strtotime($request->get('adate')));


        $allowance->first_day_month = $First;

        $allowance->last_day_month = $Last;

	    }


		$allowance->save();



		Audit::logaudit(date('Y-m-d'),Auth::user()->username,'assigned: '.$allowance->allowance_amount.' to'.Employee::getEmployeeName($request->get('employee')),'Employee Allowances',$allowance->allowance_amount);

		return Redirect::route('employee_allowances.index')->withFlashMessage('Employee Allowance successfully created!');
	}

	/*
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$eallw = EAllowances::findOrFail($id);

		return View::make('employee_allowances.show', compact('eallw'));
	}

	/*
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$eallw = EAllowances::find($id);
		$employees = Employee::where('organization_id',Auth::user()->organization_id)->get();
		$allowances = Allowance::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->get();
                $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->first();
		return View::make('employee_allowances.edit', compact('eallw','allowances','employees','currency'));
	}

	/*
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
		$allowance = EAllowances::findOrFail($id);

		$validator = Validator::make($data = $request->all(), EAllowances::$rules, EAllowances::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}


		$allowance->allowance_id = $request->get('allowance');

        $allowance->formular = $request->get('formular');

		if($request->get('formular') == 'Instalments'){
		$allowance->instalments = $request->get('instalments');
        $insts = $request->get('instalments');

		$a = str_replace( ',', '', $request->get('amount') );

        $allowance->allowance_amount = $a;

        $d=strtotime($request->get('adate'));

        $allowance->allowance_date = date("Y-m-d", $d);

        $effectiveDate = date('Y-m-d', strtotime("+".($insts-1)." months", strtotime($request->get('adate'))));

        $First  = date('Y-m-01', strtotime($request->get('adate')));
        $Last   = date('Y-m-t', strtotime($effectiveDate));

        $allowance->first_day_month = $First;

        $allowance->last_day_month = $Last;

	    }else{
	    $allowance->instalments = '1';
        $a = str_replace( ',', '', $request->get('amount') );

        $allowance->allowance_amount = $a;

        $d=strtotime($request->get('adate'));

        $allowance->allowance_date = date("Y-m-d", $d);

        $First  = date('Y-m-01', strtotime($request->get('adate')));
        $Last   = date('Y-m-t', strtotime($request->get('adate')));


        $allowance->first_day_month = $First;

        $allowance->last_day_month = $Last;

	    }


		$allowance->update();
		Audit::logaudit(date('Y-m-d'),Auth::user()->username,'assigned: '.$allowance->allowance_amount.' to '.Employee::getEmployeeName($allowance->employee_id),'Employee Allowances',$allowance->allowance_amount);
		return Redirect::route('employee_allowances.index')->withFlashMessage('Employee Allowance successfully updated!');
	}

	/*
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$allowance = EAllowances::findOrFail($id);

		EAllowances::destroy($id);


		Audit::logaudit(date('Y-m-d'),Auth::user()->username, 'deleted: '.$allowance->allowance_amount.' for '.Employee::getEmployeeName($allowance->employee_id),'Employee Allowances',$allowance->allowance_amount);


		return Redirect::route('employee_allowances.index')->withDeleteMessage('Employee Allowance successfully deleted!');
	}

    public function view($id){

		$eallw = DB::table('employee_allowances')
		          ->join('employee', 'employee_allowances.employee_id', '=', 'employee.id')
		          ->join('allowances', 'employee_allowances.allowance_id', '=', 'allowances.id')
		          ->where('employee_allowances.id','=',$id)
		          ->where('employee.organization_id',Auth::user()->organization_id)
		          ->select('employee_allowances.id','first_name','last_name','middle_name','allowance_amount',
		          	'allowance_name','photo','signature','formular','instalments','allowance_date','first_day_month','last_day_month')
		          ->first();

		$organization = Organization::find(Auth::user()->organization_id);

		return View::make('employee_allowances.view', compact('eallw'));

	}


}
