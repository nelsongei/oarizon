<?php namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Organization;
use Barryvdh\DomPDF\PDF;
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

                $currencies = DB::table('currencies')
                    ->select('shortname')
                    ->get();

                $organization = Organization::find(1);

                $fyear = '';
                $fperiod = '';

                $part = explode("-", $period);

                if ($part[0] == 1) {
                    $fyear = 'January_' . $part[1];
                } else if ($part[0] == 2) {
                    $fyear = 'Febraury_' . $part[1];
                } else if ($part[0] == 3) {
                    $fyear = 'March_' . $part[1];
                } else if ($part[0] == 4) {
                    $fyear = 'April_' . $part[1];
                } else if ($part[0] == 5) {
                    $fyear = 'May_' . $part[1];
                } else if ($part[0] == 6) {
                    $fyear = 'June_' . $part[1];
                } else if ($part[0] == 7) {
                    $fyear = 'July_' . $part[1];
                } else if ($part[0] == 8) {
                    $fyear = 'August_' . $part[1];
                } else if ($part[0] == 9) {
                    $fyear = 'September_' . $part[1];
                } else if ($part[0] == 10) {
                    $fyear = 'October_' . $part[1];
                } else if ($part[0] == 11) {
                    $fyear = 'November_' . $part[1];
                } else if ($part[0] == 12) {
                    $fyear = 'December_' . $part[1];
                }

                if ($part[0] == 1) {
                    $fperiod = 'January-' . $part[1];
                } else if ($part[0] == 2) {
                    $fperiod = 'Febraury-' . $part[1];
                } else if ($part[0] == 3) {
                    $fperiod = 'March-' . $part[1];
                } else if ($part[0] == 4) {
                    $fperiod = 'April-' . $part[1];
                } else if ($part[0] == 5) {
                    $fperiod = 'May-' . $part[1];
                } else if ($part[0] == 6) {
                    $fperiod = 'June-' . $part[1];
                } else if ($part[0] == 7) {
                    $fperiod = 'July-' . $part[1];
                } else if ($part[0] == 8) {
                    $fperiod = 'August-' . $part[1];
                } else if ($part[0] == 9) {
                    $fperiod = 'September-' . $part[1];
                } else if ($part[0] == 10) {
                    $fperiod = 'October-' . $part[1];
                } else if ($part[0] == 11) {
                    $fperiod = 'November-' . $part[1];
                } else if ($part[0] == 12) {
                    $fperiod = 'December-' . $part[1];
                }


                $fileName = $user->first_name . '_' . $user->last_name . '_' . $fyear . '.pdf';
                $filePath = 'app/views/temp/';
                $pdf = PDF::loadView('pdf.monthlySlip', compact('employees', 'transacts', 'allws', 'deds', 'earnings', 'period', 'currencies', 'organization'))->setPaper('a4')->setOrientation('potrait');

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

            $emps = DB::table('employee')->count();

            $id = request('employeeid');

            $employee = Employee::find($id);

            $transacts = DB::table('transact')
                ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
                ->where('financial_month_year', '=', request('period'))
                ->where('employee.id', '=', request('employeeid'))
                ->get();

            $allws = DB::table('transact_allowances')
                ->join('employee', 'transact_allowances.employee_id', '=', 'employee.id')
                ->where('financial_month_year', '=', request('period'))
                ->where('employee.id', '=', request('employeeid'))
                ->groupBy('allowance_name')
                ->get();

            $earnings = DB::table('transact_earnings')
                ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
                ->where('financial_month_year', '=', request('period'))
                ->where('employee.id', '=', request('employeeid'))
                ->groupBy('earning_name')
                ->get();

            $deds = DB::table('transact_deductions')
                ->join('employee', 'transact_deductions.employee_id', '=', 'employee.id')
                ->where('financial_month_year', '=', request('period'))
                ->where('employee.id', '=', request('employeeid'))
                ->groupBy('deduction_name')
                ->get();

            $currencies = DB::table('currencies')
                ->select('shortname')
                ->get();

            $organization = Organization::find(1);

            $fyear = '';
            $fperiod = '';

            $part = explode("-", $period);

            if ($part[0] == 1) {
                $fyear = 'January_' . $part[1];
            } else if ($part[0] == 2) {
                $fyear = 'Febraury_' . $part[1];
            } else if ($part[0] == 3) {
                $fyear = 'March_' . $part[1];
            } else if ($part[0] == 4) {
                $fyear = 'April_' . $part[1];
            } else if ($part[0] == 5) {
                $fyear = 'May_' . $part[1];
            } else if ($part[0] == 6) {
                $fyear = 'June_' . $part[1];
            } else if ($part[0] == 7) {
                $fyear = 'July_' . $part[1];
            } else if ($part[0] == 8) {
                $fyear = 'August_' . $part[1];
            } else if ($part[0] == 9) {
                $fyear = 'September_' . $part[1];
            } else if ($part[0] == 10) {
                $fyear = 'October_' . $part[1];
            } else if ($part[0] == 11) {
                $fyear = 'November_' . $part[1];
            } else if ($part[0] == 12) {
                $fyear = 'December_' . $part[1];
            }

            if ($part[0] == 1) {
                $fperiod = 'January-' . $part[1];
            } else if ($part[0] == 2) {
                $fperiod = 'Febraury-' . $part[1];
            } else if ($part[0] == 3) {
                $fperiod = 'March-' . $part[1];
            } else if ($part[0] == 4) {
                $fperiod = 'April-' . $part[1];
            } else if ($part[0] == 5) {
                $fperiod = 'May-' . $part[1];
            } else if ($part[0] == 6) {
                $fperiod = 'June-' . $part[1];
            } else if ($part[0] == 7) {
                $fperiod = 'July-' . $part[1];
            } else if ($part[0] == 8) {
                $fperiod = 'August-' . $part[1];
            } else if ($part[0] == 9) {
                $fperiod = 'September-' . $part[1];
            } else if ($part[0] == 10) {
                $fperiod = 'October-' . $part[1];
            } else if ($part[0] == 11) {
                $fperiod = 'November-' . $part[1];
            } else if ($part[0] == 12) {
                $fperiod = 'December-' . $part[1];
            }


            $fileName = $employee->first_name . '_' . $employee->last_name . '_' . $fyear . '.pdf';
            $filePath = 'app/views/temp/';
            $pdf = PDF::loadView('pdf.monthlySlip', compact('employee', 'transacts', 'allws', 'deds', 'earnings', 'period', 'currencies', 'organization'))->setPaper('a4')->setOrientation('potrait');

            $pdf->save($filePath . $fileName);

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
