<?php namespace App\Http\Controllers;

use App\Models\Advance;
use App\Models\Deduction;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Audit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Symfony\Component\Console\Input\Input;

class AdvanceController extends Controller
{

    /**
     * Display a listing of branches
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $accounts = Account::where('organization_id', Auth::user()->organization_id)->where('active', true)->get();

        return View::make('advances.index', compact('accounts'));
    }

    public function createaccount()
    {
        $postaccount = Input::all();
        $data = array('name' => $postaccount['name'],
            'code' => $postaccount['code'],
            'category' => $postaccount['category'],
            'active' => 1,
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('accounts')->insertGetId($data);

        if ($check > 0) {

            Audit::logaudit('Accounts', 'create', 'created: ' . $postaccount['name']);
            return $check;
        } else {
            return 1;
        }

    }

    public function preview_advance()
    {

        $employees = DB::table('employee')
            ->join('employee_deductions', 'employee.id', '=', 'employee_deductions.employee_id')
            ->where('in_employment', '=', 'Y')
            ->where('organization_id', '=', Auth::user()->organization_id)
            ->where('deduction_id', 1)
            ->get();

        //print_r($accounts);

        Audit::logaudit('advance salary', 'preview', 'previewed advance salaries');


        return View::make('advances.preview', compact('employees'));
    }

    public function valid()
    {
        $period = Input::get('period');

        //print_r($accounts);

        return View::make('advances.valid', compact('period'));
    }

    /**
     * Show the form for creating a new branch
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $employees = DB::table('x_employee')
            ->join('x_employee_deductions', 'x_employee.id', '=', 'x_employee_deductions.employee_id')
            ->where('in_employment', '=', 'Y')
            ->where('organization_id', '=', Auth::user()->organization_id)
            ->where('deduction_id', 1)
            ->where('instalments', '>', 0)
            ->get();
//		$period = Input::get('period');
        $period = request()->input('period');
//		$account = Input::get('account');
        $account = request()->input('account');

        //print_r($accounts);

        Audit::logaudit(now('Africa/Nairobi'), Auth::user()->username, 'Advance Salaries', 'previewed advance salaries');

        return View::make('advances.preview', compact('employees', 'period', 'account'));
    }

    public function del_exist()
    {
        $postedit = Input::all();
        $part1 = $postedit['period1'];
        $part2 = $postedit['period2'];
        $part3 = $postedit['period3'];

        $period = $part1 . $part2 . $part3;

        $data = DB::table('transact_advances')->where('financial_month_year', '=', $period)->where('organization_id', '=', Auth::user()->organization_id)->delete();

        if ($data > 0) {
            return 0;
        } else {
            return 1;
        }


        exit();
    }

    /**
     * Store a newly created branch in storage.
     *
     * @return Response
     */
    public function store()
    {
        $employees = DB::table('x_employee')
            ->join('x_employee_deductions', 'x_employee.id', '=', 'x_employee_deductions.employee_id')
            ->where('in_employment', '=', 'Y')
            ->where('organization_id', '=', Auth::user()->organization_id)
            ->where('deduction_id', 1)
            ->where('instalments', '>', 0)
            ->get();
        foreach ($employees as $employee) {
            $advance = new Advance;
            $advance->employee_id = $employee->personal_file_number;
            $advance->amount = $employee->deduction_amount;
            $advance->financial_month_year = request('period');
            $advance->account_id = request('account');
            $advance->organization_id = Auth::user()->organization_id;
            $advance->save();
        }

        $period = request('period');
        Audit::logaudit(date('Y-m-d'),Auth::user()->name,'Advance Salaries', 'process',);

        return Redirect::route('advance.index')->withFlashMessage('Advance Salaries successfully processed!');


    }


    /**
     * Display the specified branch.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $advance = Advance::findOrFail($id);

        return View::make('advances.show', compact('advance'));
    }

    /**
     * Show the form for editing the specified branch.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $deduction = Deduction::find($id);

        return View::make('deductions.edit', compact('deduction'));
    }

    /**
     * Update the specified branch in storage.
     *
     * @param int $id
     * @return Response
     */
    public function update($id)
    {
        $deduction = Deduction::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Deduction::$rules, Deduction::$messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $deduction->deduction_name = Input::get('name');
        $deduction->update();

        return Redirect::route('deductions.index');
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        Deduction::destroy($id);

        return Redirect::route('deductions.index');
    }

}
