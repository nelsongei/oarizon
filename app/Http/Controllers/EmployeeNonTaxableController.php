<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\Employeenontaxable;
use App\Models\Nontaxable;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class EmployeeNonTaxableController extends Controller
{

    /**
     * Display a listing of branches
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $nontaxables = DB::table('x_employee')
            ->join('x_employeenontaxables', 'x_employee.id', '=', 'x_employeenontaxables.employee_id')
            ->join('x_nontaxables', 'x_employeenontaxables.nontaxable_id', '=', 'x_nontaxables.id')
            ->where('in_employment', '=', 'Y')
            ->where('x_employee.organization_id', Auth::user()->organization_id)
            ->select('x_employeenontaxables.id', 'first_name', 'middle_name', 'last_name', 'nontaxable_amount', 'name')
            ->get();
        return View::make('employeenontaxables.index', compact('nontaxables'));
    }

    /**
     * Show the form for creating a new branch
     *
     * @return \Illuminate\Contracts\View\View
     */

    public function create()
    {
        $employees = DB::table('x_employee')
            ->where('in_employment', '=', 'Y')
            ->where('x_employee.organization_id', Auth::user()->organization_id)
            ->get();
        $nontaxables = Nontaxable::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
        $currency = Currency::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->first();
        return View::make('employeenontaxables.create', compact('employees', 'nontaxables', 'currency'));
    }

    public function createnontaxable()
    {
        $postdeduction = request()->all();
        $data = array('name' => $postdeduction['name'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('nontaxables')->insertGetId($data);

        if ($check > 0) {

            Audit::logaudit('Nontaxables', 'create', 'created: ' . $postdeduction['name']);
            return $check;
        } else {
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
        $validator = Validator::make($data = request()->all(), Employeenontaxable::$rules, Employeenontaxable::$messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $nontaxable = new Employeenontaxable;

        $nontaxable->employee_id = request()->input('employee');

        $nontaxable->nontaxable_id = request()->input('income');

        $nontaxable->formular = request()->input('formular');

        if (request()->input('formular') == 'Instalments') {
            $nontaxable->instalments = request()->input('instalments');
            $insts = request()->input('instalments');

            $a = str_replace(',', '', request()->input('amount'));
            $nontaxable->nontaxable_amount = $a;

            $d = strtotime(request()->input('idate'));

            $nontaxable->nontaxable_date = date("Y-m-d", $d);

            $effectiveDate = date('Y-m-d', strtotime("+" . ($insts - 1) . " months", strtotime(request()->input('idate'))));

            $First = date('Y-m-01', strtotime(request()->input('idate')));
            $Last = date('Y-m-t', strtotime($effectiveDate));

            $nontaxable->first_day_month = $First;

            $nontaxable->last_day_month = $Last;

        } else {
            $nontaxable->instalments = '1';
            $a = str_replace(',', '', request()->input('amount'));
            $nontaxable->nontaxable_amount = $a;

            $d = strtotime(request()->input('idate'));

            $nontaxable->nontaxable_date = date("Y-m-d", $d);

            $First = date('Y-m-01', strtotime(request()->input('idate')));
            $Last = date('Y-m-t', strtotime(request()->input('idate')));


            $nontaxable->first_day_month = $First;

            $nontaxable->last_day_month = $Last;

        }


        $nontaxable->save();

        Audit::logaudit(date('Y-m-d'),Auth::user()->username,'Employeenontaxables',  'assigned: ' . $nontaxable->nontaxable_amount . ' to ' . Employee::getEmployeeName(request('employee')));

        return Redirect::route('employeenontaxables.index')->withFlashMessage('Employee non taxable income successfully created!');
    }

    /**
     * Display the specified branch.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $nontaxable = Employeenontaxable::findOrFail($id);

        return View::make('employeenontaxables.show', compact('nontaxable'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $nontax = Employeenontaxable::find($id);
        $employees = Employee::where('organization_id', Auth::user()->organization_id)->get();
        $nontaxables = Nontaxable::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
        $currency = Currency::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->first();
        return View::make('employeenontaxables.edit', compact('nontax', 'employees', 'nontaxables', 'currency'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param int $id
     * @return Response
     */
    public function update($id)
    {
        $nontaxable = Employeenontaxable::findOrFail($id);

        $validator = Validator::make($data = request()->all(), Employeenontaxable::$rules, Employeenontaxable::$messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $nontaxable->nontaxable_id = request('income');

        $nontaxable->formular = request('formular');

        if (request('formular') == 'Instalments') {
            $nontaxable->instalments = request('instalments');
            $insts = request('instalments');

            $a = str_replace(',', '', request('amount'));
            $nontaxable->nontaxable_amount = $a;

            $d = strtotime(request('idate'));

            $nontaxable->nontaxable_date = date("Y-m-d", $d);

            $effectiveDate = date('Y-m-d', strtotime("+" . ($insts - 1) . " months", strtotime(request('idate'))));

            $First = date('Y-m-01', strtotime(request('idate')));
            $Last = date('Y-m-t', strtotime($effectiveDate));

            $nontaxable->first_day_month = $First;

            $nontaxable->last_day_month = $Last;

        } else {
            $nontaxable->instalments = '1';
            $a = str_replace(',', '', request('amount'));
            $nontaxable->nontaxable_amount = $a;

            $d = strtotime(request('idate'));

            $nontaxable->nontaxable_date = date("Y-m-d", $d);

            $First = date('Y-m-01', strtotime(request('idate')));
            $Last = date('Y-m-t', strtotime(request('idate')));


            $nontaxable->first_day_month = $First;

            $nontaxable->last_day_month = $Last;

        }

        $nontaxable->update();

        Audit::logaudit('employeenontaxables', 'update', 'assigned: ' . $nontaxable->nontaxable_amount . ' for ' . Employee::getEmployeeName($nontaxable->employee_id));

        return Redirect::route('employeenontaxables.index')->withFlashMessage('Employee non taxable income successfully updated!');
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $nontaxable = Employeenontaxable::findOrFail($id);
        Employeenontaxable::destroy($id);

        Audit::logaudit('Employeenontaxables', 'delete', 'deleted: ' . $nontaxable->nontaxable_amount . ' for ' . Employee::getEmployeeName($nontaxable->employee_id));

        return Redirect::route('employeenontaxables.index')->withDeleteMessage('Employee non taxable income successfully deleted!');
    }

    public function view($id)
    {

        $nontaxable = DB::table('x_employee')
            ->join('x_employeenontaxables', 'x_employee.id', '=', 'x_employeenontaxables.employee_id')
            ->join('x_nontaxables', 'x_employeenontaxables.nontaxable_id', '=', 'x_nontaxables.id')
            ->where('x_employeenontaxables.id', '=', $id)
            ->where('x_employee.organization_id', Auth::user()->organization_id)
            ->select('x_employeenontaxables.id', 'first_name', 'last_name', 'middle_name', 'formular', 'instalments', 'nontaxable_amount', 'name', 'nontaxable_date', 'last_day_month', 'photo', 'signature')
            ->first();

        $organization = Organization::find(Auth::user()->organization_id);

        return View::make('employeenontaxables.view', compact('nontaxable'));

    }

}
