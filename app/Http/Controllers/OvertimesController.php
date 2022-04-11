<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\Organization;
use App\Models\Overtime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class OvertimesController extends Controller
{

    /**
     * Display a listing of branches
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $overtimes = DB::table('x_employee')
            ->join('x_overtimes', 'x_employee.id', '=', 'x_overtimes.employee_id')
            ->where('in_employment', '=', 'Y')
            ->where('x_employee.organization_id', Auth::user()->organization_id)
            ->select('x_overtimes.id', 'type', 'first_name', 'middle_name', 'last_name', 'amount', 'period')
            ->get();

        Audit::logaudit(date('Y-m-d'),AUth::user()->username, 'view', 'viewed employee overtime');

        return View::make('overtime.index', compact('overtimes'));
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
        $currency = Currency::whereNull('organization_id')
            ->orWhere('organization_id', Auth::user()->organization_id)->first();
        return View::make('overtime.create', compact('employees', 'currency'));
    }

    /**
     * Store a newly created branch in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $validator = Validator::make($data = request()->all(), Overtime::$rules, Overtime::$messsages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $overtime = new Overtime;

        $overtime->employee_id = request()->input('employee');

        $overtime->type = request()->input('type');

        $overtime->period = request()->input('period');

        $overtime->formular = request()->input('formular');

        if (request()->input('formular') == 'Instalments') {
            $overtime->instalments = request()->input('instalments');
            $insts = request()->input('instalments');

            $a = str_replace(',', '', request()->input('amount'));

            $overtime->amount = $a;

            $d = strtotime(request()->input('odate'));

            $overtime->overtime_date = date("Y-m-d", $d);

            $effectiveDate = date('Y-m-d', strtotime("+" . ($insts - 1) . " months", strtotime(request()->input('odate'))));

            $First = date('Y-m-01', strtotime(request()->input('odate')));
            $Last = date('Y-m-t', strtotime($effectiveDate));

            $overtime->first_day_month = $First;

            $overtime->last_day_month = $Last;

        } else {
            $overtime->instalments = '1';
            $a = str_replace(',', '', request()->input('amount'));

            $overtime->amount = $a;

            $d = strtotime(request()->input('odate'));

            $overtime->overtime_date = date("Y-m-d", $d);

            $First = date('Y-m-01', strtotime(request()->input('odate')));
            $Last = date('Y-m-t', strtotime(request()->input('odate')));


            $overtime->first_day_month = $First;

            $overtime->last_day_month = $Last;

        }


        $overtime->save();

        Audit::logaudit('Overtimes', 'create', 'created: ' . $overtime->type . ' for ' . Employee::getEmployeeName(Input::get('employee')));


        return Redirect::route('overtimes.index')->withFlashMessage('Employee Overtime successfully created!');
    }

    /**
     * Display the specified branch.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $overtime = Overtime::findOrFail($id);

        return View::make('overtime.show', compact('overtime'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $overtime = Overtime::find($id);
        $currency = Currency::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->first();

        return View::make('overtime.edit', compact('overtime', 'currency'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $overtime = Overtime::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Overtime::$rules, Overtime::$messsages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $overtime->type = request()->input('type');

        $overtime->period = request()->input('period');

        $overtime->formular = request()->input('formular');

        if (request()->input('formular') == 'Instalments') {
            $overtime->instalments = request()->input('instalments');
            $insts = request()->input('instalments');

            $a = str_replace(',', '', request()->input('amount'));

            $overtime->amount = $a;

            $d = strtotime(request()->input('odate'));

            $overtime->overtime_date = date("Y-m-d", $d);

            $effectiveDate = date('Y-m-d', strtotime("+" . ($insts - 1) . " months", strtotime(request()->input('odate'))));

            $First = date('Y-m-01', strtotime(request()->input('odate')));
            $Last = date('Y-m-t', strtotime($effectiveDate));

            $overtime->first_day_month = $First;

            $overtime->last_day_month = $Last;

        } else {
            $overtime->instalments = '1';
            $a = str_replace(',', '', request()->input('amount'));

            $overtime->amount = $a;

            $d = strtotime(request()->input('odate'));

            $overtime->overtime_date = date("Y-m-d", $d);

            $First = date('Y-m-01', strtotime(request()->input('odate')));
            $Last = date('Y-m-t', strtotime(request()->input('odate')));


            $overtime->first_day_month = $First;

            $overtime->last_day_month = $Last;

        }

        $overtime->update();

        Audit::logaudit('Overtimes', 'update', 'updated: ' . $overtime->type . ' for ' . Employee::getEmployeeName($overtime->employee_id));

        return Redirect::route('overtimes.index')->withFlashMessage('Employee Overtime successfully updated!');
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $overtime = Overtime::findOrFail($id);
        Overtime::destroy($id);

        Audit::logaudit('Overtimes', 'delete', 'deleted: ' . $overtime->type . ' for ' . Employee::getEmployeeName($overtime->employee_id));

        return Redirect::route('overtimes.index')->withDeleteMessage('Employee Overtime successfully deleted!');
    }

    public function view($id)
    {

        $overtime = Overtime::find($id);

        $organization = Organization::find(Auth::user()->organization_id);

        return View::make('overtime.view', compact('overtime'));

    }

}
