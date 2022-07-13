<?php namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Currency;
use App\Models\Deduction;
use App\Models\EDeduction;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class EmployeeDeductionsController extends Controller {

    /*
     * Display a listing of branches
     *
     * @return Response
     */
    public function index()
    {
        $deds = DB::table('x_employee')
            ->join('x_employee_deductions', 'x_employee.id', '=', 'x_employee_deductions.employee_id')
            ->join('x_deductions', 'x_employee_deductions.deduction_id', '=', 'x_deductions.id')
            ->where('in_employment','=','Y')
            ->where('x_employee.organization_id',Auth::user()->organization_id)
            ->select('x_employee_deductions.id','first_name','middle_name','last_name','deduction_amount','deduction_name')
            ->get();
        return View::make('employee_deductions.index', compact('deds'));
    }

    /*
     * Show the form for creating a new branch
     *
     * @return Response
     */

    public function create()
    {
        $employees = DB::table('x_employee')
            ->where('in_employment','=','Y')
            ->where('x_employee.organization_id',Auth::user()->organization_id)
            ->get();
        $deductions = Deduction::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->get();
        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->first();
        return View::make('employee_deductions.create',compact('employees','deductions','currency'));
    }

    public function creatededuction(Request $request)
    {
        $postdeduction = $request->all();
        $data = array('deduction_name' => $postdeduction['name'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('x_deductions')->insertGetId( $data );

        if($check > 0){

            Audit::logaudit('Deductions', 'create', 'created: '.$postdeduction['name']);
            return $check;
        }else{
            return 1;
        }

    }

    /*
     * Store a newly created branch in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($data = $request->all(), EDeduction::$rules, EDeduction::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $ded = new EDeduction;

        $ded->employee_id = $request->get('employee');

        $ded->deduction_id = $request->get('deduction');

        $ded->formular = $request->get('formular');

        if($request->get('formular') == 'Instalments'){
            $ded->instalments = $request->get('instalments');
            $insts = $request->get('instalments');

            $a = str_replace( ',', '', $request->get('amount') );
            $ded->deduction_amount = $a;

            $d=strtotime($request->get('ddate'));

            $ded->deduction_date = date("Y-m-d", $d);

            $effectiveDate = date('Y-m-d', strtotime("+".($insts-1)." months", strtotime($request->get('ddate'))));

            $First  = date('Y-m-01', strtotime($request->get('ddate')));
            $Last   = date('Y-m-t', strtotime($effectiveDate));

            $ded->first_day_month = $First;

            $ded->last_day_month = $Last;

        }else{
            $ded->instalments = '1';
            $a = str_replace( ',', '', $request->get('amount') );
            $ded->deduction_amount = $a;

            $d=strtotime($request->get('ddate'));

            $ded->deduction_date = date("Y-m-d", $d);

            $First  = date('Y-m-01', strtotime($request->get('ddate')));
            $Last   = date('Y-m-t', strtotime($request->get('ddate')));


            $ded->first_day_month = $First;

            $ded->last_day_month = $Last;

        }


        $ded->save();

        Audit::logaudit(date('Y-m-d'),Auth::user()->name,'Employee Deduction',  'assigned: '.$ded->deduction_amount.' to '.Employee::getEmployeeName($request->get('employee')));

        return Redirect::route('employee_deductions.index')->withFlashMessage('Employee Deduction successfully created!');
    }

    /*
     * Display the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $ded = EDeduction::findOrFail($id);

        return View::make('employee_deductions.show', compact('ded'));
    }

    /*
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $ded = EDeduction::find($id);
        $employees = Employee::where('organization_id',Auth::user()->organization_id)->get();
        $deductions = Deduction::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->get();
        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->first();
        return View::make('employee_deductions.edit', compact('ded','employees','deductions','currency'));
    }

    /*
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $ded = EDeduction::findOrFail($id);

        $validator = Validator::make($data = $request->all(), EDeduction::$rules, EDeduction::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $ded->deduction_id = $request->get('deduction');

        $ded->formular = $request->get('formular');

        if($request->get('formular') == 'Instalments'){
            $ded->instalments = $request->get('instalments');
            $insts = $request->get('instalments');

            $a = str_replace( ',', '', $request->get('amount') );
            $ded->deduction_amount = $a;

            $d=strtotime($request->get('ddate'));

            $ded->deduction_date = date("Y-m-d", $d);

            $effectiveDate = date('Y-m-d', strtotime("+".($insts-1)." months", strtotime($request->get('ddate'))));

            $First  = date('Y-m-01', strtotime($request->get('ddate')));
            $Last   = date('Y-m-t', strtotime($effectiveDate));

            $ded->first_day_month = $First;

            $ded->last_day_month = $Last;

        }else{
            $ded->instalments = '1';
            $a = str_replace( ',', '', $request->get('amount') );
            $ded->deduction_amount = $a;

            $d=strtotime($request->get('ddate'));

            $ded->deduction_date = date("Y-m-d", $d);

            $First  = date('Y-m-01', strtotime($request->get('ddate')));
            $Last   = date('Y-m-t', strtotime($request->get('ddate')));

            $ded->first_day_month = $First;

            $ded->last_day_month = $Last;

        }

        $ded->update();

        Audit::logaudit(date('Y-m-d'),Auth::user()->name,'Employee Deduction',  'assigned: '.$ded->deduction_amount.' for '.Employee::getEmployeeName($ded->employee_id));

        return Redirect::route('employee_deductions.index')->withFlashMessage('Employee Deduction successfully updated!');
    }

    /*
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $ded = EDeduction::findOrFail($id);
        EDeduction::destroy($id);

        Audit::logaudit('Employee Deduction', 'delete', 'deleted: '.$ded->deduction_amount.' for '.Employee::getEmployeeName($ded->employee_id));

        return Redirect::route('employee_deductions.index')->withDeleteMessage('Employee Deduction successfully deleted!');
    }

    public function view($id){

        $ded = DB::table('x_employee')
            ->join('x_employee_deductions', 'x_employee.id', '=', 'x_employee_deductions.employee_id')
            ->join('x_deductions', 'x_employee_deductions.deduction_id', '=', 'x_deductions.id')
            ->where('x_employee_deductions.id','=',$id)
            ->where('x_employee.organization_id',Auth::user()->organization_id)
            ->select('x_employee_deductions.id','first_name','last_name','middle_name','formular','instalments','deduction_amount','deduction_name','deduction_date','last_day_month','photo','signature')
            ->first();

        $organization = Organization::find(Auth::user()->organization_id);

        return View::make('employee_deductions.view', compact('ded'));

    }

}
