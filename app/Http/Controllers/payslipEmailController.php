<?php namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Organization;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class payslipEmailController extends Controller
{

    /**
     * Display a listing of branches
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $employees = Employee::all();
        return View::make('payslips.index', compact('employees'));
    }

    public function sendEmail()
    {
        if (!empty(request()->input('sel'))) {
            $period = request()->input('period');
            $employees = Employee::all();

            $emps = DB::table('x_employee')->count();

            foreach ($employees as $user) {

                $transacts = DB::table('x_transact')
                    ->join('x_employee', 'x_transact.employee_id', '=', 'x_employee.personal_file_number')
                    ->where('financial_month_year', '=', request('period'))
                    ->where('x_employee.id', '=', $user->id)
                    ->get();
                $allws = DB::table('x_transact_allowances')
                    ->join('x_employee', 'x_transact_allowances.employee_id', '=', 'x_employee.id')
                    ->where('financial_month_year', '=', request('period'))
                    ->where('x_employee.id', '=', $user->id)
                    ->groupBy('allowance_name')
                    ->get();

                $earnings = DB::table('x_transact_earnings')
                    ->join('x_employee', 'x_transact_earnings.employee_id', '=', 'x_employee.id')
                    ->where('financial_month_year', '=', request('period'))
                    ->where('x_employee.id', '=', $user->id)
                    ->groupBy('earning_name')
                    ->get();

                $deds = DB::table('x_transact_deductions')
                    ->join('x_employee', 'x_transact_deductions.employee_id', '=', 'x_employee.id')
                    ->where('financial_month_year', '=', request('period'))
                    ->where('x_employee.id', '=', $user->id)
                    ->groupBy('deduction_name')
                    ->get();

                $currencies = DB::table('x_currencies')
                    ->select('shortname')
                    ->get();

                $organization = Organization::find(1);

                $fyear = '';
                $fperiod = '';

                $part = explode("-", $period);
//                dd($part[1]);
                if ($part[1] == 1) {
                    $fyear = 'January_' . $part[0];
                } else if ($part[1] == 2) {
                    $fyear = 'Febraury_' . $part[0];
                } else if ($part[1] == 3) {
                    $fyear = 'March_' . $part[0];
                } else if ($part[1] == 4) {
                    $fyear = 'April_' . $part[0];
                } else if ($part[1] == 5) {
                    $fyear = 'May_' . $part[0];
                } else if ($part[1] == 6) {
                    $fyear = 'June_' . $part[0];
                } else if ($part[1] == 7) {
                    $fyear = 'July_' . $part[0];
                } else if ($part[1] == 8) {
                    $fyear = 'August_' . $part[0];
                } else if ($part[1] == 9) {
                    $fyear = 'September_' . $part[0];
                } else if ($part[1] == 10) {
                    $fyear = 'October_' . $part[0];
                } else if ($part[1] == 11) {
                    $fyear = 'November_' . $part[0];
                } else if ($part[1] == 12) {
                    $fyear = 'December_' . $part[0];
                }
//                dd($fyear);
                if ($part[1] == 1) {
                    $fperiod = 'January-' . $part[0];
                } else if ($part[1] == 2) {
                    $fperiod = 'Febraury-' . $part[0];
                } else if ($part[1] == 3) {
                    $fperiod = 'March-' . $part[0];
                } else if ($part[1] == 4) {
                    $fperiod = 'April-' . $part[0];
                } else if ($part[1] == 5) {
                    $fperiod = 'May-' . $part[0];
                } else if ($part[1] == 6) {
                    $fperiod = 'June-' . $part[0];
                } else if ($part[1] == 7) {
                    $fperiod = 'July-' . $part[0];
                } else if ($part[1] == 8) {
                    $fperiod = 'August-' . $part[0];
                } else if ($part[1] == 9) {
                    $fperiod = 'September-' . $part[0];
                } else if ($part[1] == 10) {
                    $fperiod = 'October-' . $part[0];
                } else if ($part[1] == 11) {
                    $fperiod = 'November-' . $part[0];
                } else if ($part[1] == 12) {
                    $fperiod = 'December-' . $part[0];
                }

                $select = "ALL";

                $fileName = $user->first_name . '_' . $user->last_name . '_' . $fyear . '.pdf';
                $filePath = 'app/views/temp/';
                $pdf = PDF::loadView('pdf.monthlySlip', compact('employees', 'select', 'transacts', 'allws', 'deds', 'earnings', 'period', 'currencies', 'organization'))->setPaper('a4')->setOrientation('potrait');

                $pdf->save($filePath . $fileName);

                Mail::send('payslips.message', compact('fperiod', 'user'), function ($message) use ($user, $filePath, $fileName) {
                    $message->to($user->email_office, $user->first_name . ' ' . $user->last_name)->subject('Payslip');
                    $message->attach($filePath . $fileName);
                });
                unlink($filePath . $fileName);
            }
            return Redirect::back()->with('success', 'Email Sent!');
        } else if (empty(request('sel')) && !empty(request('employeeid'))) {
            $period = request('period');
            $employees = Employee::all();

            $emps = DB::table('x_employee')->count();

            $id = request('employeeid');

            $employee = Employee::find($id);
            $transacts = DB::table('x_transact')
                ->join('x_employee', 'x_transact.employee_id', '=', 'x_employee.personal_file_number')
                ->where('financial_month_year', '=', request('period'))
                ->where('x_employee.id', '=', request('employeeid'))
                ->get();
//            dd($transacts);

            $allws = DB::table('x_transact_allowances')
                ->join('x_employee', 'x_transact_allowances.employee_id', '=', 'x_employee.id')
                ->where('financial_month_year', '=', request('period'))
                ->where('x_employee.id', '=', request('employeeid'))
                ->groupBy('allowance_name')
                ->get();
            $overtimes = DB::table('x_transact_overtimes')
                ->join('x_employee', 'x_transact_overtimes.employee_id', '=', 'x_employee.id')
                ->where('financial_month_year', '=', request('period'))
                ->where('x_employee.id', '=', request('employeeid'))
                ->groupBy('employee_id')
                ->get();

            $earnings = DB::table('x_transact_earnings')
                ->join('x_employee', 'x_transact_earnings.employee_id', '=', 'x_employee.id')
                ->where('financial_month_year', '=', request('period'))
                ->where('x_employee.id', '=', request('employeeid'))
                ->groupBy('earning_name')
                ->get();

            $deds = DB::table('x_transact_deductions')
                ->join('x_employee', 'x_transact_deductions.employee_id', '=', 'x_employee.id')
                ->where('financial_month_year', '=', request('period'))
                ->where('x_employee.id', '=', request('employeeid'))
                ->groupBy('deduction_name')
                ->get();
            $nontaxables = DB::table('x_transact_nontaxables')
                ->join('x_employee', 'x_transact_nontaxables.employee_id', '=', 'x_employee.id')
                ->where('financial_month_year', '=', request('period'))
                ->where('x_employee.id', '=', request('period'))
                ->groupBy('nontaxable_name')
                ->get();
            $rels = DB::table('x_transact_reliefs')
                ->join('x_employee','x_transact_reliefs.employee_id','=','x_employee.id')
                ->where('financial_month_year','=',request('period'))
                ->where('x_employee.id','=',request('employeeid'))
                ->groupBy('relief_name')
                ->get();
            $pension = DB::table('x_transact_pensions')
                ->join('x_employee','x_transact_pensions.employee_id','=','x_employee.id')
                ->where('financial_month_year','=',request('period'))
                ->where('x_employee.id','=',request('employeeid'))
                ->first()
            ;

            $currencies = DB::table('x_currencies')
                ->pluck('shortname')
                ->first();

            $organization = Organization::find(1);

            $fyear = '';
            $fperiod = '';

            $part = explode("-", $period);
            if ($part[1] == 1) {
                $fyear = 'January_' . $part[0];
            } else if ($part[1] == 2) {
                $fyear = 'Febraury_' . $part[0];
            } else if ($part[1] == 3) {
                $fyear = 'March_' . $part[0];
            } else if ($part[1] == 4) {
                $fyear = 'April_' . $part[0];
            } else if ($part[1] == 5) {
                $fyear = 'May_' . $part[0];
            } else if ($part[1] == 6) {
                $fyear = 'June_' . $part[0];
            } else if ($part[1] == 7) {
                $fyear = 'July_' . $part[0];
            } else if ($part[1] == 8) {
                $fyear = 'August_' . $part[0];
            } else if ($part[1] == 9) {
                $fyear = 'September_' . $part[0];
            } else if ($part[1] == 10) {
                $fyear = 'October_' . $part[0];
            } else if ($part[1] == 11) {
                $fyear = 'November_' . $part[0];
            } else if ($part[1] == 12) {
                $fyear = 'December_' . $part[0];
            }

            if ($part[1] == 1) {
                $fperiod = 'January-' . $part[0];
            } else if ($part[1] == 2) {
                $fperiod = 'Febraury-' . $part[0];
            } else if ($part[1] == 3) {
                $fperiod = 'March-' . $part[0];
            } else if ($part[1] == 4) {
                $fperiod = 'April-' . $part[0];
            } else if ($part[1] == 5) {
                $fperiod = 'May-' . $part[0];
            } else if ($part[1] == 6) {
                $fperiod = 'June-' . $part[0];
            } else if ($part[1] == 7) {
                $fperiod = 'July-' . $part[0];
            } else if ($part[1] == 8) {
                $fperiod = 'August-' . $part[0];
            } else if ($part[1] == 9) {
                $fperiod = 'September-' . $part[0];
            } else if ($part[1] == 10) {
                $fperiod = 'October-' . $part[0];
            } else if ($part[1] == 11) {
                $fperiod = 'November-' . $part[0];
            } else if ($part[1] == 12) {
                $fperiod = 'December-' . $part[0];
            }
            $select = "";
//            dd($overtimes);
            $fileName = $employee->first_name . '_' . $employee->last_name . '_' . $fyear . '.pdf';
            $filePath = 'resources/views/temp/';
            $pdf = PDF::loadView('pdf.monthlySlip', compact('employee', 'nontaxables', 'select', 'transacts', 'allws', 'deds', 'earnings', 'period', 'currencies', 'organization', 'overtimes','rels','pension'))->setPaper('a4');
//            $pdf->save($filePath . $fileName);

            $user = Employee::find($id);


            Mail::send('payslips.message', compact('fperiod', 'user'), function ($message) use ($user, $filePath, $fileName) {
                $message->to($user->email_office, $user->first_name . ' ' . $user->last_name)->subject('Payslip');
                $message->attach($filePath . $fileName);
            });
            unlink($filePath . $fileName);

        }
        return Redirect::back()->with('success', 'Email Sent!');
    }
}
