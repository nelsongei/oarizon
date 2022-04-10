<?php namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Currency;
use App\Models\Earnings;
use App\Models\Earningsetting;
use App\Models\Employee;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class EarningsController extends Controller
{

    /*
     * Display a listing of branches
     *
     * @return Response
     */
    public function index()
    {
        $earnings = DB::table('x_employee')
            ->join('x_earnings', 'x_employee.id', '=', 'x_earnings.employee_id')
            ->join('x_earningsettings', 'x_earnings.earning_id', '=', 'x_earningsettings.id')
            ->where('in_employment', '=', 'Y')
            ->where('x_employee.organization_id', Auth::user()->organization_id)
            ->select('x_earnings.id', 'first_name', 'middle_name', 'last_name', 'earnings_amount', 'earning_name')
            ->get();

        Audit::logaudit(date('Y-m-d'), Auth::user()->username, 'viewed earnings', 'Earnings', 0);

        return View::make('other_earnings.index', compact('earnings'));
    }

    /*
     * Show the form for creating a new branch
     *
     * @return Response
     */
    public function create()
    {

        $employees = DB::table('x_employee')
            ->where('in_employment', '=', 'Y')
            ->where('x_employee.organization_id', Auth::user()->organization_id)
            ->get();
        $earnings = Earningsetting::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
        $currency = Currency::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->first();
        return View::make('other_earnings.create', compact('employees', 'earnings', 'currency'));
    }

    public function createearning(Request $request)
    {
        $postearning = $request->all();
        $data = array('earning_name' => $postearning['name'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('earningsettings')->insertGetId($data);
        // $id = DB::table('earningsettings')->insertGetId( $data );

        if ($check > 0) {

            Audit::logaudit(date('Y-m-d'), Auth::user()->username, 'created: ' . $postearning['name'], 'Earningsettings', 0);

            return $check;
        } else {
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
        $validator = Validator::make($data = $request->all(), Earnings::$rules, Earnings::$messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $earning = new Earnings;

        $earning->employee_id = $request->get('employee');

        $earning->earning_id = $request->get('earning');

        $earning->narrative = $request->get('narrative');

        $earning->formular = $request->get('formular');

        if ($request->get('formular') == 'Instalments') {
            $earning->instalments = $request->get('instalments');
            $insts = $request->get('instalments');

            $a = str_replace(',', '', $request->get('amount'));
            $earning->earnings_amount = $a;

            $d = strtotime($request->get('ddate'));

            $earning->earning_date = date("Y-m-d", $d);

            $effectiveDate = date('Y-m-d', strtotime("+" . ($insts - 1) . " months", strtotime($request->get('ddate'))));

            $First = date('Y-m-01', strtotime($request->get('ddate')));
            $Last = date('Y-m-t', strtotime($effectiveDate));

            $earning->first_day_month = $First;

            $earning->last_day_month = $Last;

        } else {
            $earning->instalments = '1';
            $a = str_replace(',', '', $request->get('amount'));
            $earning->earnings_amount = $a;

            $d = strtotime($request->get('ddate'));

            $earning->earning_date = date("Y-m-d", $d);

            $First = date('Y-m-01', strtotime($request->get('ddate')));
            $Last = date('Y-m-t', strtotime($request->get('ddate')));


            $earning->first_day_month = $First;

            $earning->last_day_month = $Last;

        }

        $earning->save();

        Audit::logaudit(date('Y-m-d'), Auth::user()->username, 'created: ' . $earning->earnings_name . ' for ' . Employee::getEmployeeName($request->get('employee')), 'Earnings', $earning->earnings_amount);

        return Redirect::route('other_earnings.index')->withFlashMessage('Earning successfully created!');
    }

    /*
     * Display the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $earning = Earnings::findOrFail($id);

        return View::make('other_earnings.show', compact('earning'));
    }

    /*
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $earning = DB::table('employee')
            ->join('earnings', 'employee.id', '=', 'earnings.employee_id')
            ->where('in_employment', '=', 'Y')
            ->where('employee.organization_id', Auth::user()->organization_id)
            ->where('earnings.id', '=', $id)
            ->first();

        $earningsettings = Earningsetting::all();
        $currency = Currency::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->first();
        return View::make('other_earnings.edit', compact('earning', 'employees', 'earningsettings', 'currency'));
    }

    /*
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $earning = Earnings::findOrFail($id);

        $validator = Validator::make($data = $request->all(), Earnings::$rules, Earnings::$messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $earning->earning_id = $request->get('earning');

        $earning->narrative = $request->get('narrative');

        $earning->formular = $request->get('formular');

        if ($request->get('formular') == 'Instalments') {
            $earning->instalments = $request->get('instalments');
            $insts = $request->get('instalments');

            $a = str_replace(',', '', $request->get('amount'));
            $earning->earnings_amount = $a;

            $d = strtotime($request->get('ddate'));

            $earning->earning_date = date("Y-m-d", $d);

            $effectiveDate = date('Y-m-d', strtotime("+" . ($insts - 1) . " months", strtotime($request->get('ddate'))));

            $First = date('Y-m-01', strtotime($request->get('ddate')));
            $Last = date('Y-m-t', strtotime($effectiveDate));

            $earning->first_day_month = $First;

            $earning->last_day_month = $Last;

        } else {
            $earning->instalments = '1';
            $a = str_replace(',', '', $request->get('amount'));
            $earning->earnings_amount = $a;

            $d = strtotime($request->get('ddate'));

            $earning->earning_date = date("Y-m-d", $d);

            $First = date('Y-m-01', strtotime($request->get('ddate')));
            $Last = date('Y-m-t', strtotime($request->get('ddate')));


            $earning->first_day_month = $First;

            $earning->last_day_month = $Last;
        }

        $earning->update();

        Audit::logaudit(date('Y-m-d'), Auth::user()->username, 'updated: ' . $earning->earnings_name . ' for ' . Employee::getEmployeeName($earning->employee_id), 'Earnings', $earning->earnings_amount);

        return Redirect::route('other_earnings.index')->withFlashMessage('Earning successfully updated!');
    }

    /*
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $earning = Earnings::findOrFail($id);

        Earnings::destroy($id);

        Audit::logaudit(date('Y-m-d'), Auth::user()->username, 'deleted: ' . $earning->earnings_name . ' for ' . Employee::getEmployeeName($earning->employee_id), 'Earnings', $earning->earnings_amount);

        return Redirect::route('other_earnings.index')->withDeleteMessage('Earning successfully deleted!');

    }

    public function view($id)
    {

        $earning = Earnings::find($id);

        $organization = Organization::find(Auth::user()->organization_id);

        return View::make('other_earnings.view', compact('earning'));

    }

}
