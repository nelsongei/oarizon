<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\AdvanceController;
use App\Http\Controllers\Api\MpesaController;
use App\Http\Controllers\AppraisalCategoryController;
use App\Http\Controllers\AppraisalsController;
use App\Http\Controllers\AppraisalSettingsController;
use App\Http\Controllers\AuditsController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BankBranchController;
use App\Http\Controllers\BanksController;
use App\Http\Controllers\OfficeShiftController;
use App\Http\Controllers\BenefitSettingsController;
use App\Http\Controllers\BranchesController;
use App\Http\Controllers\CitizenshipController;
use App\Http\Controllers\NonTaxablesController;
use App\Http\Controllers\CurrenciesController;
use App\Http\Controllers\DeductionsController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\EarningsController;
use App\Http\Controllers\EmployeeAllowancesController;
use App\Http\Controllers\AllowancesController;
use App\Http\Controllers\EmployeeDeductionsController;
use App\Http\Controllers\EmployeeNonTaxableController;
use App\Http\Controllers\EmployeeReliefController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\EmployeeTypeController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\HolidaysController;
use App\Http\Controllers\JobGroupController;
use App\Http\Controllers\LeaveapplicationsController;
use App\Http\Controllers\LeavetypesController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\LoanrepaymentsController;
use App\Http\Controllers\NhifController;
use App\Http\Controllers\NssfController;
use App\Http\Controllers\OccurencesController;
use App\Http\Controllers\OccurencesettingsController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\OvertimesController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\payslipEmailController;
use App\Http\Controllers\PromotionsController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\ReliefsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\Account;
use App\Models\AccountTransaction;
use App\Models\Audit;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Client;
use App\Models\Erporder;
use App\Models\Erporderitem;
use App\Models\Holiday;
use App\Models\Branch;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\ItemTracker;
use App\Models\Jobgroup;
use App\Models\Currency;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Journal;
use App\Models\Leaveapplication;
use App\Models\Leavetype;
use App\Models\Location;
use App\Models\Organization;
use App\Models\Payment;
use App\Models\Promotion;
use App\Models\Stations;
use App\Models\Stock;
use App\Models\Tax;
use App\Models\TaxOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
/*
 * Users
 * */
Route::resource('users', UserController::class);
/*
 * Roles
 * */
Route::resource('roles', RoleController::class);

/*
 *
 * Employees
 * */
Route::resource('employees', EmployeesController::class);
Route::get('employees/show/{id}', [EmployeesController::class, 'show']);


Route::get('employees/create', [EmployeesController::class, 'create']);

//    Route::resource('employees', 'EmployeesController');
Route::post('employees/update/{id}', [EmployeesController::class, 'update']);
Route::get('employees/deactivate/{id}', [EmployeesController::class, 'deactivate']);
Route::get('employees/activate/{id}', [EmployeesController::class, 'activate']);
Route::get('employees/edit/{id}', [EmployeesController::class, 'edit']);
Route::get('employees/view/{id}', [EmployeesController::class, 'view']);
Route::get('employees/viewdeactive/{id}', [EmployeesController::class, 'viewdeactive']);

Route::post('createCitizenship', [EmployeesController::class, 'createcitizenship']);
Route::post('createEducation', [EmployeesController::class, 'createeducation']);
Route::post('createBank', [EmployeesController::class, 'createbank']);
Route::post('createBankBranch', [EmployeesController::class, 'createbankbranch']);
Route::post('createBranch', [EmployeesController::class, 'createbranch']);
Route::post('createDepartment', [EmployeesController::class, 'createdepartment']);
Route::post('createType', [EmployeesController::class, 'createtype']);
Route::post('createJobtitle', [EmployeesController::class, 'createjobtitle']);

Route::post('createGroup', [EmployeesController::class, 'creategroup']);
Route::post('createEmployee', [EmployeesController::class, 'serializeDoc']);
Route::get('employeeIndex', [EmployeesController::class, 'getIndex']);


/*
 * Employee Appraisals
 * */
Route::resource('Appraisals', AppraisalsController::class);
Route::post('Appraisals/update/{id}', [AppraisalsController::class, 'update']);
Route::get('Appraisals/delete/{id}', [AppraisalsController::class, 'destroy']);
Route::get('Appraisals/edit/{id}', [AppraisalsController::class, 'edit']);
Route::get('Appraisals/view/{id}', [AppraisalsController::class, 'view']);
Route::post('createQuestion', [AppraisalsController::class, 'createquestion']);


Route::resource('AppraisalSettings', AppraisalSettingsController::class);
Route::post('AppraisalSettings/update/{id}', [AppraisalSettingsController::class, 'update']);
Route::get('AppraisalSettings/delete/{id}', [AppraisalSettingsController::class, 'destroy']);
Route::get('AppraisalSettings/edit/{id}', [AppraisalSettingsController::class, 'edit']);
Route::post('createCategory', [AppraisalSettingsController::class, 'createcategory']);

Route::resource('appraisalcategories', AppraisalCategoryController::class);
Route::post('appraisalcategories/update/{id}', [AppraisalCategoryController::class, 'update']);
Route::get('appraisalcategories/delete/{id}', [AppraisalCategoryController::class, 'destroy']);
Route::get('appraisalcategories/edit/{id}', [AppraisalCategoryController::class, 'edit']);

/**
 * occurence settings routes
 */
Route::resource('occurencesettings', OccurencesettingsController::class);
Route::post('occurencesettings/update/{id}', [OccurencesettingsController::class, 'update']);
Route::get('occurencesettings/delete/{id}', [OccurencesettingsController::class, 'destroy']);
Route::get('occurencesettings/edit/{id}', [OccurencesettingsController::class, 'edit']);

/**
 * Occurence routes
 */
Route::resource('occurences', OccurencesController::class);
Route::post('occurences/update/{id}', [OccurencesController::class, 'update']);
Route::get('occurences/delete/{id}', [OccurencesController::class, 'destroy']);
Route::get('occurences/edit/{id}', [OccurencesController::class, 'edit']);
Route::get('occurences/view/{id}', [OccurencesController::class, 'view']);
Route::get('occurences/download/{id}', [OccurencesController::class, 'getDownload']);
Route::post('createOccurence', [OccurencesController::class, 'createoccurence']);

/*
 * Activate/Deactivate
 * */
Route::get('deactives', function () {

    $employees = Employee::getDeactiveEmployee();

    return view('employees.activate', compact('employees'));

});

/***************
 * Employee promotions
 */
Route::get('employee_promotion', function () {
    $promotions = Promotion::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();

    Audit::logaudit(now('Africa/Nairobi'), Auth::user()->username, 'view', 'viewed promotions');

    return view('promotions.index', compact('promotions'));

});


/**
 * Promotions controller
 */
Route::resource('promotions', PromotionsController::class);
Route::get('promotions/edit/{id}', [PromotionsController::class, 'edit']);
Route::post('promotions/update/{id}', [PromotionsController::class, 'update']);
Route::get('promotions/delete/{id}', [PromotionsController::class, 'destroy']);
Route::get('promotions/create', [PromotionsController::class, 'create']);
Route::get('promotions/letters/{id}', [PromotionsController::class, 'promotionletter']);
Route::get('transfer/letters/{id}', [PromotionsController::class, 'transferletter']);
Route::get('promotions/show/{id}', [PromotionsController::class, 'show']);

/**/

//Route::group(['middleware'=>['can:manage_holiday']],function (){
/**
 * Holiday routes
 */
Route::resource('holidays', HolidaysController::class);
Route::get('holidays/edit/{id}', [HolidaysController::class, 'edit']);
Route::get('holidays/delete/{id}', [HolidaysController::class, 'destroy']);
Route::post('holidays/update/{id}', [HolidaysController::class, 'update']);
//});

//Route::group(['middleware'=>['can:manage_leavetype']],function (){
Route::resource('leavetypes', LeavetypesController::class);
Route::get('leavetypes/edit/{id}', [LeavetypesController::class, 'edit']);
Route::get('leavetypes/delete/{id}', [LeavetypesController::class, 'destroy']);
Route::post('leavetypes/update/{id}', [LeavetypesController::class, 'update']);
//});

//Route::group(['middleware'=>['can:manage_leave']],function (){
/**LEAVE APPLICATION ROUTES */
Route::resource('leaveapplications', LeaveapplicationsController::class);
Route::get('leaveapplications/edit/{id}', [LeaveapplicationsController::class, 'edit']);
Route::get('leaveapplications/delete/{id}', [LeaveapplicationsController::class, 'destroy']);
Route::post('leaveapplications/update/{id}', [LeaveapplicationsController::class, 'update']);
Route::get('leaveapplications/approve/{id}', [LeaveapplicationsController::class, 'approve']);
Route::post('leaveapplications/approve/{id}', [LeaveapplicationsController::class, 'doapprove']);
Route::get('leaveapplications/cancel/{id}', [LeaveapplicationsController::class, 'cancel']);
//Route::get('leaveapplications/cancel/{id}', 'LeaveapplicationsController@cancel');
Route::get('leaveapplications/reject/{id}', [LeaveapplicationsController::class, 'reject']);
Route::get('leaveapplications/show/{id}', [LeaveapplicationsController::class, 'show']);

Route::get('leaveapplications/approvals', [LeaveapplicationsController::class, 'approvals']);
Route::get('leaveapplications/rejects', [LeaveapplicationsController::class, 'rejects']);
Route::get('leaveapplications/cancellations', [LeaveapplicationsController::class, 'cancellations']);
Route::get('leaveapplications/amends', [LeaveapplicationsController::class, 'amended']);
Route::get('ajaxfetchleaveEnd', function () {
    $fdate = date("Y-m-d", strtotime(request('fdate')));
    $leave_id = request('leavetype');
    $fdate2 = date("Y-m-d", strtotime($fdate));
    $leave = Leavetype::find($leave_id);
    $leave_days = $leave->days;
    $off_weekends = $leave->off_weekends;
    $off_holidays = $leave->off_holidays;
    for ($i = 1; $i <= $leave_days; $i++) {
        if ($i == 1) {
            $holidate = Holiday::where("date", "=", $fdate)->count();
            $weekend = date("w", strtotime($fdate));
            if ($weekend == 6 && $off_weekends == 1) {
                $curr_date = date('Y-m-d', strtotime($fdate . '+ 2 days'));
            } else if ($weekend == 0 && $off_weekends == 1) {
                $curr_date = date('Y-m-d', strtotime($fdate . '+ 1 days'));
            } else if ($holidate > 0 && $off_holidays == 1) {
                $curr_date = date('Y-m-d', strtotime($fdate . '+ 1 days'));
            } else {
                $curr_date = $fdate;
            }
        } else {
            $curr_date = $_SESSION['curr_date'];
            $next_date = date('Y-m-d', strtotime($curr_date . '+ 1 days'));
            $holidate = Holiday::where("date", "=", $next_date)->count();
            $weekend = date("w", strtotime($next_date));
            if ($weekend == 6 && $off_weekends == 1) {
                $curr_date = date('Y-m-d', strtotime($curr_date . '+ 3 days'));
            } elseif ($holidate > 0 && $off_holidays == 1) {
                $curr_date = date('Y-m-d', strtotime($curr_date . '+ 2 days'));
            } else {
                $curr_date = date('Y-m-d', strtotime($curr_date . '+ 1 days'));
            }
        }
        $_SESSION['curr_date'] = $curr_date;
    }
    session_unset();
    return $curr_date;
});
/*
 *
 * Form
 *
 * */
Route::get('EmployeeForm', function () {

    $organization = Organization::find(Auth::user()->organization_id);

    $pdf = PDF::loadView('pdf.employee_form', compact('organization'))->setPaper('a4');

    return $pdf->stream('Employee_Form.pdf');


});
Route::get('api/dropdown', function (Request $request) {
    $id = request()->option;
    $bbranch = Bank::find($id)->bankbranch;
    //$branches = $bbranch->pluck('id','bank_branch_name');
    $branches = $bbranch->all();
    return response()->json(array('branches' => $branches));
});

Route::get('leavemgmt', function () {
    $leaveapplications = Leaveapplication::where('organization_id', Auth::user()->organization_id)->get();
    return View::make('leavemgmt', compact('leaveapplications'));
});

Route::get('leaveamends', function () {

    $leaveapplications = Leaveapplication::all();

    return View::make('leaveapplications.amended', compact('leaveapplications'));

});

Route::get('leaveapprovals', function () {

    $leaveapplications = Leaveapplication::all();

    return View::make('leaveapplications.approved', compact('leaveapplications'));

});
Route::get('leaverejects', function () {

    $leaveapplications = Leaveapplication::all();

    return View::make('leaveapplications.rejected', compact('leaveapplications'));

});
Route::get('api/leavetypes', function () {
    $leavetypes = Leavetype::where('organization_id', Auth::user()->organization_id)->get();
    return $leavetypes->pluck('name', 'id');
});

/*
 * Properties
 * */
Route::resource('Properties', PropertiesController::class);
Route::post('Properties/update/{id}', [PropertiesController::class, 'update']);
Route::get('Properties/delete/{id}', [PropertiesController::class, 'destroy']);
Route::get('Properties/edit/{id}', [PropertiesController::class, 'edit']);
Route::get('Properties/view/{id}', [PropertiesController::class, 'view']);
/*
 * Organization
 * */
Route::resource('organizations', OrganizationsController::class);

Route::post('organizations/update/{id}', [OrganizationsController::class, 'update']);
Route::post('organizations/logo/{id}', [OrganizationsController::class, 'logo']);
Route::get('language/{lang}',
    array(
        'as' => 'language.select',
        'uses' => [OrganizationsController::class, 'language']
    )
);

/**
 * branches routes
 */

Route::resource('branches', BranchesController::class);
Route::post('branches/update/{id}', [BranchesController::class, 'update']);
Route::get('branches/delete/{id}', [BranchesController::class, 'destroy']);
Route::get('branches/edit/{id}', [BranchesController::class, 'edit']);

//=================GROUP ROUTES ===============================//
Route::resource('groups', GroupsController::class);
Route::post('groups/update/{id}', [GroupsController::class, 'update']);
Route::get('groups/delete/{id}', [GroupsController::class, 'destroy']);
Route::get('groups/edit/{id}', [GroupsController::class, 'edit']);
//==============================END GROUP ROUTES =============//

/*
* departments routes
*/
Route::resource('departments', DepartmentsController::class);
Route::post('departments/update/{id}', [DepartmentsController::class, 'update']);
Route::get('departments/delete/{id}', [DepartmentsController::class, 'destroy']);
Route::get('departments/edit/{id}', [DepartmentsController::class, 'edit']);

/**
 * Currencies
 */
Route::resource('currencies', CurrenciesController::class);
Route::get('currencies/edit/{id}', [CurrenciesController::class, 'edit']);
Route::post('currencies/update/{id}', [CurrenciesController::class, 'update']);
Route::get('currencies/delete/{id}', [CurrenciesController::class, 'destroy']);
Route::get('currencies/create', [CurrenciesController::class, 'create']);

/*
 *
 * Banks
 * */
Route::resource('banks', BanksController::class);
Route::post('banks/update/{id}', [BanksController::class, 'update']);
Route::get('banks/delete/{id}', [BanksController::class, 'destroy']);
Route::get('banks/edit/{id}', [BanksController::class, 'edit']);

/*
 * Bank Branches
 * */
Route::resource('bankbranches', BankBranchController::class);
Route::post('bankbranches/update/{id}', [BankBranchController::class, 'update']);
Route::get('bankbranches/delete/{id}', [BankBranchController::class, 'destroy']);
Route::get('bankbranches/edit/{id}', [BankBranchController::class, 'edit']);
Route::get('bankbranchesimport', function () {
    return View::make('bank_branch.import');
});

/*
* employee type routes
*/
Route::resource('employee_type', EmployeeTypeController::class);
Route::post('employee_type/update/{id}', [EmployeeTypeController::class, 'update']);
Route::get('employee_type/delete/{id}', [EmployeeTypeController::class, 'destroy']);
Route::get('employee_type/edit/{id}', [EmployeeTypeController::class, 'edit']);


/*
* employee earnings routes
*/
Route::resource('other_earnings', EarningsController::class);
Route::post('other_earnings/update/{id}', [EarningsController::class, 'update']);
Route::get('other_earnings/delete/{id}', [EarningsController::class, 'destroy']);
Route::get('other_earnings/edit/{id}', [EarningsController::class, 'edit']);
Route::get('other_earnings/view/{id}', [EarningsController::class, 'view']);
Route::post('createEarning', [EarningsController::class, 'createearning']);

/*
* employee reliefs routes
*/
Route::resource('employee_relief', EmployeeReliefController::class);
Route::post('employee_relief/update/{id}', [EmployeeReliefController::class, 'update']);
Route::get('employee_relief/delete/{id}', [EmployeeReliefController::class, 'destroy']);
Route::get('employee_relief/edit/{id}', [EmployeeReliefController::class, 'edit']);
Route::get('employee_relief/view/{id}', [EmployeeReliefController::class, 'view']);
Route::post('createRelief', [EmployeeReliefController::class, 'createrelief']);

/*
* employee allowances routes
*/
Route::resource('employee_allowances', EmployeeAllowancesController::class);
Route::post('employee_allowances/update/{id}', [EmployeeAllowancesController::class, 'update']);
Route::get('employee_allowances/delete/{id}', [EmployeeAllowancesController::class, 'destroy']);
Route::get('employee_allowances/edit/{id}', [EmployeeAllowancesController::class, 'edit']);
Route::get('employee_allowances/view/{id}', [EmployeeAllowancesController::class, 'view']);
Route::post('createAllowance', [EmployeeAllowancesController::class, 'createallowance']);
Route::post('reloaddata', [EmployeeAllowancesController::class, 'display']);

/*
* employee nontaxables routes
*/

Route::resource('employeenontaxables', EmployeeNonTaxableController::class);
Route::post('employeenontaxables/update/{id}', [EmployeeNonTaxableController::class, 'update']);
Route::get('employeenontaxables/delete/{id}', [EmployeeNonTaxableController::class, 'destroy']);
Route::get('employeenontaxables/edit/{id}', [EmployeeNonTaxableController::class, 'edit']);
Route::get('employeenontaxables/view/{id}', [EmployeeNonTaxableController::class, 'view']);
Route::post('createNontaxable', [EmployeeNonTaxableController::class, 'createnontaxable']);

/*
* employee deductions routes
*/
Route::resource('employee_deductions', EmployeeDeductionsController::class);
Route::post('employee_deductions/update/{id}', [EmployeeDeductionsController::class, 'update']);
Route::get('employee_deductions/delete/{id}', [EmployeeDeductionsController::class, 'destroy']);
Route::get('employee_deductions/edit/{id}', [EmployeeDeductionsController::class, 'edit']);
Route::get('employee_deductions/view/{id}', [EmployeeDeductionsController::class, 'view']);
Route::post('createDeduction', [EmployeeDeductionsController::class, 'creatededuction']);

/*
* benefits setting routes
*/

Route::resource('benefitsettings', BenefitSettingsController::class);
Route::post('benefitsettings/update/{id}', [BenefitSettingsController::class, 'update']);
Route::get('benefitsettings/delete/{id}', [BenefitSettingsController::class, 'destroy']);
Route::get('benefitsettings/edit/{id}', [BenefitSettingsController::class, 'edit']);

/*
 * Overtimes
 * */
Route::resource('overtimes', OvertimesController::class);
Route::get('overtimes/edit/{id}', [OvertimesController::class, 'edit']);
Route::post('overtimes/update/{id}', [OvertimesController::class, 'update']);
Route::get('overtimes/delete/{id}', [OvertimesController::class, 'destroy']);
Route::get('overtimes/view/{id}', [OvertimesController::class, 'view']);

/*
* job group routes
*/

Route::resource('job_group', JobGroupController::class);
Route::post('job_group/update/{id}', [JobGroupController::class, 'update']);
Route::get('job_group/delete/{id}', [JobGroupController::class, 'destroy']);
Route::get('job_group/edit/{id}', [JobGroupController::class, 'edit']);
Route::get('job_group/show/{id}', [JobGroupController::class, 'show']);
/*
 *
 * HR Reports
 * */
Route::get('reports/CompanyProperty/selectPeriod', [ReportsController::class, 'propertyperiod']);
Route::post('reports/companyproperty', [ReportsController::class, 'property']);
Route::get('advanceReports/selectSummaryPeriod', [ReportsController::class, 'period_advsummary']);
Route::post('advanceReports/advanceSummary', [ReportsController::class, 'payAdvSummary']);
Route::get('payrollReports/selectPeriod', [ReportsController::class, 'period_payslip']);
Route::post('payrollReports/payslip', [ReportsController::class, 'payslip']);
Route::get('payrollReports/selectAllowance', [ReportsController::class, 'employee_allowances']);
Route::post('payrollReports/allowances', [ReportsController::class, 'allowances']);
Route::get('payrollReports/selectEarning', [ReportsController::class, 'employee_earnings']);
Route::post('payrollReports/earnings', [ReportsController::class, 'earnings']);
Route::get('payrollReports/selectOvertime', [ReportsController::class, 'employee_overtimes']);
Route::post('payrollReports/overtimes', [ReportsController::class, 'overtimes']);
Route::get('payrollReports/selectRelief', [ReportsController::class, 'employee_reliefs']);
Route::post('payrollReports/reliefs', [ReportsController::class, 'reliefs']);
Route::get('payrollReports/selectDeduction', [ReportsController::class, 'employee_deductions']);
Route::get('payrollReports/selectPension', [ReportsController::class, 'employee_pensions']);
Route::post('payrollReports/deductions', [ReportsController::class, 'deductions']);
Route::get('payrollReports/selectnontaxableincome', [ReportsController::class, 'employeenontaxableselect']);
Route::post('payrollReports/nontaxables', [ReportsController::class, 'employeenontaxables']);
Route::get('payrollReports/selectPayePeriod', [ReportsController::class, 'period_paye']);
Route::post('payrollReports/payeReturns', [ReportsController::class, 'payeReturns']);
Route::post('payrollReports/p9form', [ReportsController::class, 'p9form1']);
Route::get('payrollReports/selectRemittancePeriod', [ReportsController::class, 'period_rem']);
Route::post('payrollReports/payRemittances', [ReportsController::class, 'payeRems']);
Route::get('payrollReports/selectSummaryPeriod', [ReportsController::class, 'period_summary']);
Route::post('payrollReports/payrollSummary', [ReportsController::class, 'paySummary']);
Route::get('payrollReports/selectNssfPeriod', [ReportsController::class, 'period_nssf']);
Route::post('payrollReports/nssfReturns', [ReportsController::class, 'nssfReturns']);
Route::get('payrollReports/selectNhifPeriod', [ReportsController::class, 'period_nhif']);
Route::post('payrollReports/nhifReturns', [ReportsController::class, 'nhifReturns']);
Route::get('payrollReports/selectNssfExcelPeriod', [ReportsController::class, 'period_excel']);
Route::post('payrollReports/nssfExcel', [ReportsController::class, 'export']);
Route::post('payrollReports/pensions', [ReportsController::class, 'pensions']);
Route::get('mergeStatutory/selectPeriod', [ReportsController::class,'mergeperiod']);
Route::post('mergeStatutory/report', [ReportsController::class,'mergestatutory']);
Route::get('advanceReports/selectRemittancePeriod', [ReportsController::class,'period_advrem']);
Route::post('advanceReports/advanceRemittances', [ReportsController::class,'payeAdvRems']);
Route::get('itax/download', [ReportsController::class,'getDownload']);
Route::get('reports/blank', [ReportsController::class,'template']);
/*
 * Pension
 * */
Route::get('import_repayments', [LoanrepaymentsController::class, 'importView']);
Route::post('import_repayments', [LoanrepaymentsController::class, 'importRepayment']);
Route::get('repayments_template', [LoanrepaymentsController::class, 'createTemplate']);
/*
 *
 * Payroll Calculator
 * */
Route::get('payrollcalculator', function () {
    $currency = Currency::find(1);
    return View::make('payroll.payroll_calculator', compact('currency'));

});

//
Route::get('email/payslip', [payslipEmailController::class, 'index']);
Route::post('email/payslip/employees', [payslipEmailController::class, 'sendEmail']);
/*
* advance routes
*/
Route::resource('advance', AdvanceController::class);
Route::post('deleteadvance', [AdvanceController::class, 'del_exist']);
Route::post('advance/preview', [AdvanceController::class, 'create']);
Route::post('createAccount', [AdvanceController::class, 'createaccount']);
/**
 * payroll routes
 */
Route::resource('payroll', PayrollController::class);
Route::post('deleterow', [PayrollController::class, 'del_exist']);
Route::post('payroll/preview', [PayrollController::class, 'create']);
Route::post('payroll/edit{id}', [PayrollController::class, 'edit']);

Route::post('showrecord', [PayrollController::class, 'display']);
Route::post('shownet', [PayrollController::class, 'disp']);
Route::post('showgross', [PayrollController::class, 'dispgross']);
Route::get('payrollpreviewprint/{period}', [PayrollController::class, 'previewprint']);
Route::get('unlockpayroll/index', [PayrollController::class, 'unlockindex']);
Route::get('payroll/view/{id}', [PayrollController::class, 'viewpayroll']);
Route::get('unlockpayroll/{id}', [PayrollController::class, 'unlockpayroll']);
Route::post('unlockpayroll', [PayrollController::class, 'dounlockpayroll']);
Route::post('createNewAccount', [PayrollController::class, 'createaccount']);

Route::get('payrollcalculator', function () {
    $currency = Currency::find(1);
    return View::make('payroll.payroll_calculator', compact('currency'));

});

Route::get('payrollReports', function () {

    return view('employees.payrollreports');
});

Route::get('payrollReports/selectYear', function () {
    $branches = Branch::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
    $departments = Department::whereNull('organization_id')->orWhere('organization_id', Auth::user()->organization_id)->get();
    $employees = Employee::where('organization_id', Auth::user()->organization_id)->get();
    return view('pdf.p9Select', compact('employees', 'branches', 'departments'));
});


/**
 * Advance reports
 */
Route::get('advanceReports', function () {
    return view('employees.advancereports');
});


/**
 * statutory reports
 */
Route::get('statutoryReports', function () {
    return view('employees.statutoryreports');
});

Route::resource('accounts', AccountsController::class);
Route::post('accounts/update/{id}', [AccountsController::class, 'update']);
Route::get('accounts/delete/{id}', [AccountsController::class, 'destroy']);
Route::get('accounts/edit/{id}', [AccountsController::class, 'edit']);
Route::get('accounts/show/{id}', [AccountsController::class, 'show']);
Route::get('accounts/create/{id}', [AccountsController::class, 'create']);

//
Route::group(['before' => 'manage_settings'], function () {

    Route::get('migrate', function () {

        return View::make('migration');

    });

});

/*
* allowances routes
*/

Route::resource('allowances', AllowancesController::class);
Route::post('allowances/update/{id}', [AllowancesController::class, 'update']);
Route::get('allowances/delete/{id}', [AllowancesController::class, 'destroy']);
Route::get('allowances/edit/{id}', [AllowancesController::class, 'edit']);

/*
* reliefs routes
*/

Route::resource('reliefs', ReliefsController::class);
Route::post('reliefs/update/{id}', [ReliefsController::class, 'update']);
Route::get('reliefs/delete/{id}', [ReliefsController::class, 'destroy']);
Route::get('reliefs/edit/{id}', [ReliefsController::class, 'edit']);
/*
* deductions routes
*/

Route::resource('deductions', DeductionsController::class);
Route::post('deductions/update/{id}', [DeductionsController::class, 'update']);
Route::get('deductions/delete/{id}', [DeductionsController::class, 'destroy']);
Route::get('deductions/edit/{id}', [DeductionsController::class, 'edit']);
/*
* nssf routes
*/

Route::resource('nssf', NssfController::class);
Route::post('nssf/update/{id}', [NssfController::class, 'update']);
Route::get('nssf/delete/{id}', [NssfController::class, 'destroy']);
Route::get('nssf/edit/{id}', [NssfController::class, 'edit']);

/*
* nhif routes
*/

Route::resource('nhif', NhifController::class);
Route::post('nhif/update/{id}', [NhifController::class, 'update']);
Route::get('nhif/delete/{id}', [NhifController::class, 'destroy']);
Route::get('nhif/edit/{id}', [NhifController::class, 'edit']);
//
Route::get('api/pay', function () {
    $id = request('option');
    $employee = Employee::find($id);
    return number_format($employee->basic_pay, 2);
});
/**/

Route::resource('nontaxables', NonTaxablesController::class);
Route::post('nontaxables/update/{id}', [NonTaxablesController::class, 'update']);
Route::get('nontaxables/delete/{id}', [NonTaxablesController::class, 'destroy']);
Route::get('nontaxables/edit/{id}', [NonTaxablesController::class, 'edit']);
/**
 * citizenship routes
 */

Route::resource('citizenships', CitizenshipController::class);
Route::post('citizenships/update/{id}', [CitizenshipController::class, 'update']);
Route::get('citizenships/delete/{id}', [CitizenshipController::class, 'destroy']);
Route::get('citizenships/edit/{id}', [CitizenshipController::class, 'edit']);

//Route::group(['middleware' => 'can:manage_audits'], function () {
Route::resource('audits', AuditsController::class);
//});
// ================== Mpesa END API ROUTES organizations================================//
Route::get('/licence', [MpesaController::class, 'index']);
Route::get('/license/data', [MpesaController::class, 'getLicenseData']);
Route::get('/license/date/{id}/{module}/{end}', [LicenseController::class, 'updateDates']);
Route::get('/license/data/{id}', [MpesaController::class, 'getModuleData']);
Route::post('/stkPush', [LicenseController::class, 'stkPush']);
Route::get('mpesaTransactions/{id}/{transaction}', [MpesaController::class, 'view']);
Route::post('create/organization',[LicenseController::class,'createOrganization']);
/*
 * Employees Apis
 * */
Route::get('api/branchemployee', function () {
    $bid = request('option');
    $did = request('deptid');
    $seltype = request('type');
    $employee = array();
    $department = Department::where('name', 'Management')
        ->where(function ($query) {
            $query->whereNull('organization_id')
                ->orWhere('organization_id', Auth::user()->organization_id);
        })->first();


    $jgroup = Jobgroup::where(function ($query) {
        $query->whereNull('organization_id')
            ->orWhere('organization_id', Auth::user()->organization_id);
    })->where('job_group_name', 'Management')
        ->first();

    if (($bid == 'All' || $bid == '' || $bid == 0) && ($did == 'All' || $did == '' || $did == 0)) {
        if (Gate::allows('manager_payroll')) {
            $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
                ->where('organization_id', Auth::user()->organization_id)
                ->pluck('full_name', 'id');
        } else {
            $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
                ->where('organization_id', Auth::user()->organization_id)
                ->where('job_group_id', '!=', $jgroup->id)
                ->pluck('full_name', 'id');
        }
    } else if (($bid != 'All' || $bid != '' || $bid != 0) && ($did == 'All' || $did == '' || $did == 0)) {
        if (Gate::allows('manager_payroll')) {
            $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
                ->where('branch_id', $bid)
                ->where('organization_id', Auth::user()->organization_id)
                ->pluck('full_name', 'id');
        } else {
            $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
                ->where('branch_id', $bid)
                ->where('organization_id', Auth::user()->organization_id)
                ->where('job_group_id', '!=', $jgroup->id)
                ->pluck('full_name', 'id');
        }
    } else if (($did != 'All' || $did != '' || $did != 0) && ($bid != 'All' || $bid != '' || $bid != 0)) {
        if (Gate::allows('manager_payroll')) {
            $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
                ->where('branch_id', $bid)
                ->where('organization_id', Auth::user()->organization_id)
                ->where('department_id', $did)
                ->pluck('full_name', 'id');
        } else {
            $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
                ->where('branch_id', $bid)
                ->where('organization_id', Auth::user()->organization_id)
                ->where('job_group_id', '!=', $jgroup->id)
                ->where('department_id', $did)
                ->pluck('full_name', 'id');
        }
    } else if (($did != 'All' || $did != '' || $did != 0) && ($bid == 'All' || $bid == '' || $bid == 0)) {
        if (Gate::allows('manager_payroll')) {
            $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
                ->where('department_id', $did)
                ->where('organization_id', Auth::user()->organization_id)
                ->pluck('full_name', 'id');
        } else {
            $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
                ->where('department_id', $did)
                ->where('organization_id', Auth::user()->organization_id)
                ->where('job_group_id', '!=', $jgroup->id)
                ->pluck('full_name', 'id');
        }
    }
    return $employee;
});
Route::get('api/deptemployee', function () {
    $did = request('option');
    $bid = request('bid');
    $seltype = request('type');
    $employee = array();
    $department = Department::where('name', 'Management')
        ->where(function ($query) {
            $query->whereNull('organization_id')
                ->orWhere('organization_id', Auth::user()->organization_id);
        })->first();


    $jgroup = Jobgroup::where(function ($query) {
        $query->whereNull('organization_id')
            ->orWhere('organization_id', Auth::user()->organization_id);
    })->where('job_group_name', 'Management')
        ->first();

    if (($did == 'All' || $did == '' || $did == 0) && ($bid == 'All' || $bid == '' || $bid == 0)) {
        if (Gate::allows('manager_payroll')) {
            $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
                ->where('organization_id', Auth::user()->organization_id)
                ->pluck('full_name', 'id');
        } else {
            $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
                ->where('organization_id', Auth::user()->organization_id)
                ->where('job_group_id', '!=', $jgroup->id)
                ->pluck('full_name', 'id');
        }
    } else if (($did != 'All' || $did != '' || $did != 0) && ($bid == 'All' || $bid == '' || $bid == 0)) {
        if (Gate::allows('manager_payroll')) {
            $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
                ->where('department_id', $did)
                ->where('organization_id', Auth::user()->organization_id)
                ->pluck('full_name', 'id');
        } else {
            $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
                ->where('department_id', $did)
                ->where('organization_id', Auth::user()->organization_id)
                ->where('job_group_id', '!=', $jgroup->id)
                ->pluck('full_name', 'id');
        }
    } else if (($did != 'All' || $did != '' || $did != 0) && ($bid != 'All' || $bid != '' || $bid != 0)) {
        if (Gate::allows('manager_payroll')) {
            $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
                ->where('branch_id', $bid)
                ->where('organization_id', Auth::user()->organization_id)
                ->where('department_id', $did)
                ->pluck('full_name', 'id');
        } else {
            $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
                ->where('branch_id', $bid)
                ->where('organization_id', Auth::user()->organization_id)
                ->where('job_group_id', '!=', $jgroup->id)
                ->where('department_id', $did)
                ->pluck('full_name', 'id');
        }
    }
    return $employee;
});

/*
 * Timesheet
 */
Route::group(['prefix' => 'timesheet'], function () {
    Route::get('work_shift', [OfficeShiftController::class,'index']);
    Route::get('work_shift/create', [OfficeShiftController::class,'create']);
    Route::post('work_shift/save', [OfficeShiftController::class,'store']);
    Route::post('work_shift/deactivate', [OfficeShiftController::class,'destroy']);
    //Route::resource('attendances','AttendanceController');
    Route::get('attendances', [AttendanceController::class,'index']);

    Route::get('monthlyAttendance', 'AttendanceController@monthlyAttendance');
    Route::get('dailyAttendance', 'AttendanceController@dateWiseAttendance');
});
/*
 * ERP Alvin
 * */
Route::resource('items', 'App\Http\Controllers\ItemsController');
Route::get('items/edit/{id}', 'App\Http\Controllers\ItemsController@edit');
Route::post('items/update/{id}', 'App\Http\Controllers\ItemsController@update');
Route::get('items/delete/{id}', 'App\Http\Controllers\ItemsController@destroy');

// Items Category routes
Route::resource('itemscategory', 'App\Http\Controllers\ItemscategoryController');
Route::post('itemscategory', 'App\Http\Controllers\ItemscategoryController@store');
Route::get('itemscategory/edit/{id}', 'App\Http\Controllers\ItemscategoryController@edit');
Route::get('itemscategory/show/{id}', 'App\Http\Controllers\ItemscategoryController@show');
Route::post('itemscategory/update/{id}', 'App\Http\Controllers\ItemscategoryController@update');

Route::resource('expenses', 'App\Http\Controllers\ExpensesController');
Route::get('expenses/edit/{id}', 'App\Http\Controllers\ExpensesController@edit');
Route::post('expenses/update/{id}', 'App\Http\Controllers\ExpensesController@update');
Route::get('expenses/delete/{id}', 'App\Http\Controllers\ExpensesController@destroy');
/*
* client routes come here
*/

Route::resource('clients', 'App\Http\Controllers\ClientsController');
Route::get('clients/show/{id}', 'App\Http\Controllers\ClientsController@show');
Route::get('clients/edit/{id}', 'App\Http\Controllers\ClientsController@edit');
Route::post('clients/update/{id}', 'App\Http\Controllers\ClientsController@update');
Route::resource('suppliers', 'App\Http\Controllers\SuppliersController');

/**
 *Sales Order
 *
 */
Route::get('salesorders', function () {

    $orders = Erporder::orderBy('date', 'DESC')->get();
    $items = Item::all();
    $locations = Location::all();

    return View::make('erporders.index', compact('items', 'locations', 'orders'));
});
Route::get('salesorders/create', function () {

    $count = DB::table('erporders')->count();
    $order_number = date("Y/m/d/") . str_pad($count + 1, 4, "0", STR_PAD_LEFT);
    $items = Item::all();
    $locations = Location::all();
    $accounts = Account::all();
    $stations = Stations::all();

    $clients = Client::all();

    return View::make('erporders.create', compact('items', 'locations', 'order_number', 'clients', 'accounts', 'stations'));
});
/*
 * Purchase
 * */
Route::get('purchaseorders', function () {

    $purchases = Erporder::orderBy('date', 'DESC')->get();
    //$purchases = Erporder::all();
    $items = Item::all();
    $locations = Location::all();
    $payments = Payment::all();


    return View::make('erppurchases.index', compact('items', 'locations', 'payments', 'purchases'));
});
Route::get('purchaseorders/create', function () {

    $count = DB::table('erporders')->count();
    $order_number = date("Y/m/d/") . str_pad($count + 1, 4, "0", STR_PAD_LEFT);
    $items = Item::all();
    $locations = Location::all();
    $accounts = Account::all();

    $clients = Client::all();

    return View::make('erppurchases.create', compact('items', 'locations', 'order_number', 'clients', 'accounts'));
});
/*
 * Delivery Notes
 * */
Route::get('deliverynotes', 'App\Http\Controllers\ErpordersController@listDelivery');
/*
 *quotationorders
 * */
Route::get('quotationorders', function () {

//    $quotations = Erporder::all();
    $quotations = Erporder::orderBy('date', 'DESC')->get();
    $items = Item::all();
    $locations = Location::all();
    $items = Item::all();
    $locations = Location::all();
    $invoices = Invoice::all();


    return View::make('erpquotations.index', compact('items', 'locations', 'quotations', 'invoices'));
});
Route::get('quotationorders/create', function () {
    Request::all();
    $count = DB::table('erporders')->count();
    $order_number = date("Y/m/d/") . str_pad($count + 1, 4, "0", STR_PAD_LEFT);;
    $items = Item::all();
    $service = Item::where('type', '=', 'service')->get();
    $locations = Location::all();
    $clients = Client::all();
    $bank_accounts = BankAccount::all();

    return View::make('erpquotations.create', compact('items', 'locations', 'order_number', 'clients', 'service', 'bank_accounts'));
});

/* PAYMENT METHODS */
Route::resource('paymentmethods', 'App\Http\Controllers\PaymentmethodsController');
Route::get('paymentmethods/edit/{id}', 'App\Http\Controllers\PaymentmethodsController@edit');
Route::post('paymentmethods/update/{id}', 'App\Http\Controllers\PaymentmethodsController@update');
Route::get('paymentmethods/delete/{id}', 'App\Http\Controllers\PaymentmethodsController@destroy');
/*
 * Payments
 * */
Route::resource('payments', 'App\Http\Controllers\PaymentsController');

/*
 * STOCKS
 * */
Route::resource('stocks', 'App\Http\Controllers\StocksController');
Route::get('stocks/index', 'App\Http\Controllers\StocksController@index');
Route::get('stock/tracking', function () {
    $stocks = Stock::all();
    $items = Item::all();
    $clients = Client::all();
    $location = Location::all();
//     $leased = ItemTracker::all();
//    dd(Auth::user()->can('create_employee'));
//    return View::make('stocks/track', compact('stocks', 'items', 'clients', 'location'));
//    return View::make('stocks/track', compact('stocks', 'items', 'clients', 'location', 'leased'));
    if (!Auth::user()->can('track_stock')) // Checks the current user
    {
        return Redirect::to('dashboard')->with('notice', 'you do not have access to this resource. Contact your system admin');
    } else {
        return View::make('stocks/track', compact('stocks', 'items', 'clients', 'location', 'leased'));
    }
});

Route::get('confirmstock/{id}/{name}/{confirmer}/{key}', function ($id, $name, $confirmer, $key) {
    $stock = Stock::find($id);
    if ($stock->confirmation_code != $key) {
        $stock->is_confirmed = 1;
        $stock->confirmed_id = $confirmer;
        $stock->confirmation_code = $key;
        $stock->update();

        /*$order = Erporder::findorfail($erporder_id);
$order->status = 'delivered';
$order->update();*/

        $notifications = Notification::where('confirmation_code', $key)->get();
        foreach ($notifications as $notification) {
            $notification->is_read = 1;
            $notification->update();
        }

        return "<strong><span style='color:green'>Stock for item " . $name . " confirmed as received!</span></strong>";
    } else {
        return "<strong><span style='color:red'>Stock for item " . $name . " already received!</span></strong>";
    }
});
/*
*Locations
 *
 */

Route::resource('locations', 'App\Http\Controllers\LocationsController');
Route::get('locations/edit/{id}', 'App\Http\Controllers\LocationsController@edit');
Route::get('locations/delete/{id}', 'App\Http\Controllers\LocationsController@destroy');
Route::post('locations/update/{id}', 'App\Http\Controllers\LocationsController@update');
/*
 * STATIONS
 * */
Route::resource('stations', 'App\Http\Controllers\StationsController');
Route::get('stations/edit/{id}', 'App\Http\Controllers\StationsController@edit');
Route::post('stations/update/{id}', 'App\Http\Controllers\StationsController@update');
Route::get('stations/delete/{id}', 'App\Http\Controllers\StationsController@destroy');
Route::get('stations/show/{id}', 'App\Http\Controllers\StationsController@show');
/*
 *
 * Taxes
 * */

Route::resource('taxes', 'App\Http\Controllers\TaxController');
Route::post('taxes/update/{id}', 'App\Http\Controllers\TaxController@update');
Route::get('taxes/delete/{id}', 'App\Http\Controllers\TaxController@destroy');
Route::get('taxes/edit/{id}', 'App\Http\Controllers\TaxController@edit');

/*
*##########################ERP REPORTS#######################################
*/

Route::get('erpReports', function () {

    return view('erpreports.erpReports');
});

Route::post('erpReports/clients', 'App\Http\Controllers\ErpReportsController@clients');
Route::get('erpReports/selectClientsPeriod', 'App\Http\Controllers\ErpReportsController@selectClientsPeriod');

Route::get('erpReports/claims', 'App\Http\Controllers\ErpReportsController@claims');

Route::post('erpReports/items', 'App\Http\Controllers\ErpReportsController@items');
Route::get('erpReports/selectItemsPeriod', 'App\Http\Controllers\ErpReportsController@selectItemsPeriod');

Route::post('erpReports/expenses', 'App\Http\Controllers\ErpReportsController@expenses');
Route::get('erpReports/selectExpensesPeriod', 'App\Http\Controllers\ErpReportsController@selectExpensesPeriod');


Route::get('erpReports/paymentmethods', 'App\Http\Controllers\ErpReportsController@paymentmethods');

Route::post('erpReports/payments', 'App\Http\Controllers\ErpReportsController@payments');
Route::get('erpReports/selectPaymentsPeriod', 'App\Http\Controllers\ErpReportsController@selectPaymentsPeriod');

Route::get('erpReports/invoice/{id}', 'App\Http\Controllers\ErpReportsController@showInvoice');


Route::post('erpReports/sales', 'App\Http\Controllers\ErpReportsController@sales');
Route::get('erpReports/sales_summary', 'App\Http\Controllers\ErpReportsController@sales_Summary');
Route::get('erpReports/selectSalesPeriod', 'App\Http\Controllers\ErpReportsController@selectSalesPeriod');


Route::post('erpReports/purchases', 'App\Http\Controllers\ErpReportsController@purchases');
Route::get('erpReports/selectPurchasesPeriod', 'App\Http\Controllers\ErpReportsController@selectPurchasesPeriod');


Route::get('erpReports/quotation/{id}', 'App\Http\Controllers\ErpReportsController@quotation');
Route::get('erpReports/product/{id}', 'App\Http\Controllers\ErpReportsController@product');
Route::get('erpReports/pricelist', 'App\Http\Controllers\ErpReportsController@pricelist');
Route::get('erpReports/receipt/{id}', 'App\Http\Controllers\ErpReportsController@receipt');
Route::get('erpReports/PurchaseOrder/{id}', 'App\Http\Controllers\ErpReportsController@PurchaseOrder');

Route::get('erpReports/locations', 'App\Http\Controllers\ErpReportsController@locations');

Route::post('erpReports/stocks', 'App\Http\Controllers\ErpReportsController@stock');
Route::get('erpReports/currentstocks', 'App\Http\Controllers\ErpReportsController@currentStock');
Route::get('erpReports/selectStockPeriod', 'App\Http\Controllers\ErpReportsController@selectStockPeriod');


Route::get('erpReports/accounts', 'App\Http\Controllers\ErpReportsController@accounts');
Route::get('erpReports/itemscategory', 'App\Http\Controllers\ErpReportsController@itemscategory');

Route::get('api/getpurchaseorders', function () {
    $id = request('option');

    $data = array();

    Erporder::join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
        ->join('items', 'erporderitems.item_id', '=', 'items.id')
        ->where('client_id', $id)
        ->where('erporders.status', '!=', 'cancelled')
        // ->whereNotNull('authorized_by')
        ->select('erporders.id', DB::raw('CONCAT(order_number," : ",name ," (Remaining qty: ", quantity,")") AS erporder'))
        ->pluck('erporder', 'id');


    $nostockerps = Erporderitem::join('items', 'erporderitems.item_id', '=', 'items.id')
        ->join('erporders', 'erporderitems.erporder_id', '=', 'erporders.id')
        ->where('client_id', $id)
        ->where('erporders.status', '!=', 'cancelled')
        ->where('erporders.status', '=', 'APPROVED')
        // ->whereNotNull('authorized_by')
        ->select(DB::raw('CONCAT(erporders.id," : ",items.id) AS id'), DB::raw('CONCAT(order_number," : ",name ," (Remaining qty: ", quantity,")") AS erporder'))
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('stocks')->where('stocks.is_confirmed', 1)
                ->whereRaw('stocks.itm_id = items.id and stocks.item_id = erporders.id');
        })->get('erporder', 'id');

    $data["nostock"] = $nostockerps;

    $temptable = DB::raw('(SELECT sum(quantity_in) as qty FROM stocks t WHERE t.itm_id=erporderitems.item_id and t.item_id=erporders.id) AS s');

    $hasstockerps = Erporderitem::join('items', 'erporderitems.item_id', '=', 'items.id')
        ->join('erporders', 'erporderitems.erporder_id', '=', 'erporders.id')
        // ->join($temptable, 'items.id', '=', 's.itm_id')
        //  ->join("stocks","erporders.id","=","stocks.item_id")
        ->where('client_id', $id)
        ->where('erporders.status', '!=', 'cancelled')
        ->where('erporders.status', '=', 'APPROVED')
        //->whereNotNull('authorized_by')
        ->havingRaw('balance > 0')
        ->select(DB::raw('CONCAT(erporders.id," : ",items.id) AS id'), DB::raw('(SELECT quantity-sum(quantity_in) FROM stocks t WHERE t.itm_id=erporderitems.item_id and t.item_id=erporders.id) AS balance'), DB::raw('(SELECT CONCAT(order_number," : ",name ," (Remaining qty: ", quantity-sum(quantity_in),")") as erporder FROM stocks t WHERE t.itm_id=erporderitems.item_id and t.item_id=erporders.id) AS erporder'))
        ->groupBy('erporders.id', 'items.id')
        ->whereIn(DB::raw('(erporders.id, items.id)'), function ($query) {
            $query->select('item_id', 'itm_id')
                ->from('stocks');
        })->get('erporder', 'id');
    $data["hasstock"] = $hasstockerps;


    return json_encode($data);
});

Route::get('api/getprice', function () {
    $id = Input::get('option');
    $item = Item::find($id);
    return $item->purchase_price;
});


Route::get('api/getpurchased', function () {
    $id = Input::get('option');
    $erporderitems = Erporderitem::find($id);
    return $erporderitems->item_id;

    $client = Client::find($id);
    $order = 0;


    if ($client->type == 'Customer') {
        $order = DB::table('erporders')
            ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
            ->join('clients', 'erporders.client_id', '=', 'clients.id')
            ->where('clients.id', $id)
            ->where('erporders.type', '!=', 'quotations')
            ->where('erporders.status', '!=', 'cancelled')->selectRaw('SUM((price * quantity)) as total')
            ->pluck('total');
        //->where('status', '<>', 'cancelled')

        $tax = DB::table('erporders')
            ->join('clients', 'erporders.client_id', '=', 'clients.id')
            ->join('tax_orders', 'erporders.order_number', '=', 'tax_orders.order_number')
            ->where('clients.id', $id)
            ->where('erporders.type', '!=', 'quotations')
            ->where('erporders.status', '!=', 'cancelled')->selectRaw('SUM(COALESCE(amount,0))as total')
            ->pluck('total');

        $order = $order + $tax;
    } else {
        $order = DB::table('erporders')
            ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
            ->join('clients', 'erporders.client_id', '=', 'clients.id')
            ->where('clients.id', $id)
            ->where('erporders.status', '!=', 'cancelled')->selectRaw('SUM((price * quantity))as total')
            ->pluck('total');
    }

    $paid = DB::table('clients')
        ->join('payments', 'clients.id', '=', 'payments.client_id')
        ->where('clients.id', $id)->selectRaw('COALESCE(SUM(amount_paid),0) as due')
        ->pluck('due');

    return number_format($order - $paid, 2);
});

Route::get('api/total', function () {
    //$id = Input::get('option');
    $id = explode(" : ", Input::get('option'));
    $price = Erporderitem::join('items', 'erporderitems.item_id', '=', 'items.id')
        ->where('erporder_id', $id[0])->select(DB::raw('sum(price * quantity ) AS total'))->first();
    $payment = Payment::where('erporder_id', $id[0])->sum('amount_paid');

    return ($price->total) - $payment;
});

Route::get('api/totalsales', function () {
    //$id = Input::get('option');
    $id = explode(" : ", Input::get('option'));
    /**$price = Erporderitem::join('erporders','erporderitems.erporder_id','=','erporders.id')->where('erporder_id',$id[0])->where('erporders.status','!=','cancelled')->select(DB::raw('sum(price * quantity) AS total'))->first();**/
    $price = Erporder::where('id', $id[0])->where('erporders.status', '!=', 'cancelled')->first();
    $payment = Payment::where('erporder_id', $id[0])->sum('amount_paid');
    $p = Erporderitem::join('erporders', 'erporderitems.erporder_id', '=', 'erporders.id')
        ->where('erporder_id', $id[0])
        ->where('erporders.status', '!=', 'cancelled')
        ->where('item_id', $id[1])
        ->select(DB::raw('sum(client_discount/quantity) AS discount'))
        ->first();
    //dd($price);
    //return ($price->total) - $payment - $p->discount;
    return ($price->total_amount) - $payment - $p->discount;
});
Route::post('erporders/create', function(){

    $data = request()->all();

    $client = Client::findOrFail(Arr::get($data, 'client'));

    /*
$erporder = array(
'order_number' => array_get($data, 'order_number'),
'client' => $client,
'date' => array_get($data, 'date')

);
*/

    Session::put( 'erporder', array(
            'order_number' => Arr::get($data, 'order_number'),
            'client' => $client,
            'date' => Arr::get($data, 'date'),
            'credit_ac' => Arr::get($data, 'credit_ac'),
            'debit_ac' => Arr::get($data, 'debit_ac'),
            'transaction_desc' => Arr::get($data, 'transaction_desc'),
            'payment_type' => Arr::get($data, 'payment_type')
        )
    );
    Session::put('orderitems', []);

    $orderitems =Session::get('orderitems');

    /*
$erporder = new Erporder;

$erporder->date = date('Y-m-d', strtotime(array_get($data, 'date')));
$erporder->order_number = array_get($data, 'order_number');
$erporder->client()->associate($client);
$erporder->payment_type = array_get($data, 'payment_type');
$erporder->type = 'sales';
$erporder->save();

*/

    $items = Item::all();
    $locations = Location::all();
    $taxes = Tax::all();

    return View::make('erporders.orderitems', compact( 'items', 'locations', 'taxes','orderitems'));

});

Route::post('erporders/returnInwards',function(){
    $quantity = Input::get('quantity'); $item_id=Input::get('item_id');
    $orderitem_id=Input::get('erporder_id'); $payment_type=Input::get('payment_type');
    $pay_method=Input::get('pay_method'); $credit=Input::get('incredit');
    $item=Item::find($item_id); $orderitem=Erporderitem::find($orderitem_id);
    $total_price=(int)$item->selling_price*(int)$quantity;
    if($quantity>$orderitem->quantity){
        return Redirect::back()->with('delete_message', 'Quantity submitted is more than what was ordered');
    }
    $oitem=Erporderitem::find($orderitem_id); $oitem->last_return=$quantity; $oitem->update();
    Erporderitem::where('id', $orderitem_id)->decrement('quantity', $quantity);
    Erporderitem::where('id', $orderitem_id)->increment('total_return', $quantity);


    if($credit=="yes"){
        $credit_acc=16; $debit_acc=15;
    }else{
        if($pay_method==2 || $pay_method==1){
            $credit_acc=3; $debit_acc=15;
        }else if($pay_method==4){
            $credit_acc=14; $debit_acc=15;
        }else if($pay_method==3){
            $credit_acc=14; $debit_acc=15;
        }else{ $credit_acc=14; $debit_acc=15;}
    }
    $data = array(
        'credit_account' =>$credit_acc,
        'debit_account' =>$debit_acc,
        'date' => date('Y-m-d'),
        'amount' => $total_price,
        'initiated_by' => 'system',
        'description' => 'return inwards'
    );

    $journal = new Journal;
    $journal->journal_entry($data);

    return Redirect::back()->with('flash_message', 'Items successfully received from client');
});

Route::post('erporders/returnOutwards',function(){
    $quantity = Input::get('quantity'); $item_id=Input::get('item_id');
    $orderitem_id=Input::get('erporder_id'); $payment_type=Input::get('payment_type');
    $pay_method=Input::get('pay_method'); $item=Item::find($item_id);
    $total_price=(int)$item->selling_price*(int)$quantity; $credit=Input::get('outcredit');
    $orderitem=Erporderitem::find($orderitem_id);
    if($quantity>$orderitem->quantity){
        return Redirect::back()->with('delete_message', 'Quantity submitted is more than what was ordered');
    }
    Erporderitem::where('id', $orderitem_id)->decrement('quantity', $quantity);
    if($credit=="yes"){
        $credit_acc=15; $debit_acc=17;
    }else{
        if($pay_method==2 || $pay_method==1){
            $credit_acc=15; $debit_acc=3;
        }else if($pay_method==4){
            $credit_acc=15; $debit_acc=14;
        }else if($pay_method==3){
            $credit_acc=15; $debit_acc=14;
        }else{$credit_acc=15; $debit_acc=14;}
    }
    $data = array(
        'credit_account' =>$credit_acc,
        'debit_account' =>$debit_acc,
        'date' => date('Y-m-d'),
        'amount' => $total_price,
        'initiated_by' => 'system',
        'description' => 'return outwards'
    );

    $journal = new Journal;
    $journal->journal_entry($data);

    return Redirect::back()->with('flash_message', 'Items successfully returned to supplier');
});

Route::get('api/getQuantity', function(){
    $id = request('item');
    $item = Item::find($id);
    return $item->type;
});


Route::post('erppurchases/create', function(){

    $data = Input::all();

    $client = Client::findOrFail(array_get($data, 'client'));

    /*
$erporder = array(
'order_number' => array_get($data, 'order_number'),
'client' => $client,
'date' => array_get($data, 'date')

);
*/

    Session::put( 'erporder', array(
            'order_number' => array_get($data, 'order_number'),
            'client' => $client,
            'payment_type' => array_get($data, 'payment_type'),
            'date' => array_get($data, 'date'),
            'lpo_no' => array_get($data, 'lpo_no'),
            'credit_ac' => array_get($data, 'credit_ac'),
            'debit_ac' => array_get($data, 'debit_ac'),
            'transaction_desc' => array_get($data, 'transaction_desc')
        )
    );
    Session::put('purchaseitems', []);

    $orderitems =Session::get('purchaseitems');

    /*
$erporder = new Erporder;

$erporder->date = date('Y-m-d', strtotime(array_get($data, 'date')));
$erporder->order_number = array_get($data, 'order_number');
$erporder->client()->associate($client);
$erporder->payment_type = array_get($data, 'payment_type');
$erporder->type = 'sales';
$erporder->save();

*/

    $items = Item::where('type', '!=', 'service')->get();
    $locations = Location::all();
    $taxes = Tax::all();

    return View::make('erppurchases.purchaseitems', compact('items', 'locations','taxes','orderitems'));

});

Route::post('erpquotations/create', function(){

    $data = Input::all();
    $client = Client::findOrFail(array_get($data, 'client'));
    $service = Item::find(array_get($data,'service'));
    $bank_account=BankAccount::find(array_get($data,'bank'));

    /*
$erporder = array(
'order_number' => array_get($data, 'order_number'),
'client' => $client,
'date' => array_get($data, 'date')

);
*/

    Session::put( 'erporder', array(
            'order_number' => array_get($data, 'order_number'),
            'lpo_no' => array_get($data, 'lpo_no'),
            'client' => $client,
            'date' => array_get($data, 'date'),
            'bank' =>array_get($data,'bank'),
            'type' => $data['type']
        )
    );

    // Session::put('orderservice', array(
    //    $service->id => $service
    // ));

    Session::put('quotationitems', []);
    // return Session::get('erporder')['service'];

    /*
$erporder = new Erporder;

$erporder->date = date('Y-m-d', strtotime(array_get($data, 'date')));
$erporder->order_number = array_get($data, 'order_number');
$erporder->client()->associate($client);
$erporder->payment_type = array_get($data, 'payment_type');
$erporder->type = 'sales';
$erporder->save();

*/

    $items = Item::where('type','=','product')->get();
    Session::put('items', $items);

    $locations = Location::all();
    Session::put('locations', $locations);

    $taxes = Tax::all();
    Session::put('taxes', $taxes);

    $servall = Item::where('type','=','service')->get();
    Session::put('servall', $servall);

    $allItems = Item::all();
    Session::put('allItems', $allItems);


    if($data['type']=='product'){
        $client = Client::findOrFail(array_get($data, 'client'));
        $service = Item::find(array_get($data,'product'));
        $bank_account=BankAccount::find(array_get($data,'bank'));
// return $data;

        Session::put( 'erporder', array(
                'order_number' => array_get($data, 'order_number'),
                'lpo_no' => array_get($data, 'lpo_no'),
                'client' => $client,
                'bank'=>array_get($data,'bank'),
                'date' => array_get($data, 'date'),
                'type' => $data['type']
            )
        );

        Session::put('quotationitems', []);

        $items = Item::where('type','=','product')->get();
        Session::put('items', $items);

        $locations = Location::all();
        Session::put('locations', $locations);

        $taxes = Tax::all();
        Session::put('taxes', $taxes);

        $servall = Item::where('type','=','service')->get();
        Session::put('servall', $servall);

        return View::make('erpquotations.product2');
    }

    return View::make('erpquotations.quotationitems');

});
Route::post('erpquotations/create2', function(){

    $data = Input::all();

    $client = Client::findOrFail(array_get($data, 'client'));
    $service = Item::find(array_get($data,'service'));
    $bank_account=BankAccount::find(array_get($data,'bank'));

    /*
$erporder = array(
'order_number' => array_get($data, 'order_number'),
'client' => $client,
'date' => array_get($data, 'date')

);
*/

    Session::put( 'erporder', array(
            'order_number' => array_get($data, 'order_number'),
            'bank'=> array_get($data,'bank'),
            'lpo_no' => array_get($data, 'lpo_no'),
            'client' => $client,
            'date' => array_get($data, 'date'),
            'payment_type' => "credit",
            'type' => $data['type']
        )
    );

    // Session::put('orderservice', array(
    //    $service->id => $service
    // ));

    Session::put('invoiceitems', []);
    // return Session::get('erporder')['service'];

    /*
$erporder = new Erporder;

$erporder->date = date('Y-m-d', strtotime(array_get($data, 'date')));
$erporder->order_number = array_get($data, 'order_number');
$erporder->client()->associate($client);
$erporder->payment_type = array_get($data, 'payment_type');
$erporder->type = 'sales';
$erporder->save();

*/

    $items = Item::where('type','=','product')->get();
    Session::put('items', $items);

    $locations = Location::all();
    Session::put('locations', $locations);

    $taxes = Tax::all();
    Session::put('taxes', $taxes);

    $servall = Item::where('type','=','service')->get();
    Session::put('servall', $servall);

    $allItems = Item::all();
    Session::put('allItems', $allItems);

    if($data['type']=='product'){
        $client = Client::findOrFail(array_get($data, 'client'));
        $service = Item::find(array_get($data,'product'));
        $bank_account=BankAccount::find(array_get($data,'bank'));
// return $data;

        Session::put( 'erporder', array(
                'order_number' => array_get($data, 'order_number'),
                'lpo_no' => array_get($data, 'lpo_no'),
                'client' => $client,
                'bank'=>array_get($data,'bank'),
                'date' => array_get($data, 'date'),
                'type' => $data['type']
            )
        );

        Session::put('quotationitems', []);

        $items = Item::where('type','=','product')->get();
        Session::put('items', $items);

        $locations = Location::all();
        Session::put('locations', $locations);

        $taxes = Tax::all();
        Session::put('taxes', $taxes);

        $servall = Item::where('type','=','service')->get();
        Session::put('servall', $servall);

        return View::make('erpquotations.product');
    }


    return View::make('erpquotations.invoiceitems');

});
Route::get('api/getmax', function(){
    $id = request('option');
    $item  = Item::find($id);
    if($item->type == 'product'){
        $stock_in = DB::table('stocks')
            ->join('items', 'stocks.item_id', '=', 'items.id')
            ->where('item_id',$id)
            ->sum('quantity_in');

        $stock_out = DB::table('stocks')
            ->join('items', 'stocks.item_id', '=', 'items.id')
            ->where('item_id',$id)
            ->sum('quantity_out');
        return $stock_in-$stock_out;
    }
});

Route::post('erporders/create', function(){

    $data = request()->all();

    $client = Client::findOrFail(Arr::get($data, 'client'));

    /*
$erporder = array(
'order_number' => array_get($data, 'order_number'),
'client' => $client,
'date' => array_get($data, 'date')

);
*/

    Session::put( 'erporder', array(
            'order_number' => Arr::get($data, 'order_number'),
            'client' => $client,
            'date' => Arr::get($data, 'date'),
            'credit_ac' => Arr::get($data, 'credit_ac'),
            'debit_ac' => Arr::get($data, 'debit_ac'),
            'transaction_desc' => Arr::get($data, 'transaction_desc'),
            'payment_type' => Arr::get($data, 'payment_type')
        )
    );
    Session::put('orderitems', []);

    $orderitems =Session::get('orderitems');

    /*
$erporder = new Erporder;

$erporder->date = date('Y-m-d', strtotime(array_get($data, 'date')));
$erporder->order_number = array_get($data, 'order_number');
$erporder->client()->associate($client);
$erporder->payment_type = array_get($data, 'payment_type');
$erporder->type = 'sales';
$erporder->save();

*/

    $items = Item::all();
    $locations = Location::all();
    $taxes = Tax::all();

    return View::make('erporders.orderitems', compact( 'items', 'locations', 'taxes','orderitems'));

});

Route::post('erporders/returnInwards',function(){
    $quantity = Input::get('quantity'); $item_id=Input::get('item_id');
    $orderitem_id=Input::get('erporder_id'); $payment_type=Input::get('payment_type');
    $pay_method=Input::get('pay_method'); $credit=Input::get('incredit');
    $item=Item::find($item_id); $orderitem=Erporderitem::find($orderitem_id);
    $total_price=(int)$item->selling_price*(int)$quantity;
    if($quantity>$orderitem->quantity){
        return Redirect::back()->with('delete_message', 'Quantity submitted is more than what was ordered');
    }
    $oitem=Erporderitem::find($orderitem_id); $oitem->last_return=$quantity; $oitem->update();
    Erporderitem::where('id', $orderitem_id)->decrement('quantity', $quantity);
    Erporderitem::where('id', $orderitem_id)->increment('total_return', $quantity);


    if($credit=="yes"){
        $credit_acc=16; $debit_acc=15;
    }else{
        if($pay_method==2 || $pay_method==1){
            $credit_acc=3; $debit_acc=15;
        }else if($pay_method==4){
            $credit_acc=14; $debit_acc=15;
        }else if($pay_method==3){
            $credit_acc=14; $debit_acc=15;
        }else{ $credit_acc=14; $debit_acc=15;}
    }
    $data = array(
        'credit_account' =>$credit_acc,
        'debit_account' =>$debit_acc,
        'date' => date('Y-m-d'),
        'amount' => $total_price,
        'initiated_by' => 'system',
        'description' => 'return inwards'
    );

    $journal = new Journal;
    $journal->journal_entry($data);

    return Redirect::back()->with('flash_message', 'Items successfully received from client');
});

Route::post('erporders/returnOutwards',function(){
    $quantity = Input::get('quantity'); $item_id=Input::get('item_id');
    $orderitem_id=Input::get('erporder_id'); $payment_type=Input::get('payment_type');
    $pay_method=Input::get('pay_method'); $item=Item::find($item_id);
    $total_price=(int)$item->selling_price*(int)$quantity; $credit=Input::get('outcredit');
    $orderitem=Erporderitem::find($orderitem_id);
    if($quantity>$orderitem->quantity){
        return Redirect::back()->with('delete_message', 'Quantity submitted is more than what was ordered');
    }
    Erporderitem::where('id', $orderitem_id)->decrement('quantity', $quantity);
    if($credit=="yes"){
        $credit_acc=15; $debit_acc=17;
    }else{
        if($pay_method==2 || $pay_method==1){
            $credit_acc=15; $debit_acc=3;
        }else if($pay_method==4){
            $credit_acc=15; $debit_acc=14;
        }else if($pay_method==3){
            $credit_acc=15; $debit_acc=14;
        }else{$credit_acc=15; $debit_acc=14;}
    }
    $data = array(
        'credit_account' =>$credit_acc,
        'debit_account' =>$debit_acc,
        'date' => date('Y-m-d'),
        'amount' => $total_price,
        'initiated_by' => 'system',
        'description' => 'return outwards'
    );

    $journal = new Journal;
    $journal->journal_entry($data);

    return Redirect::back()->with('flash_message', 'Items successfully returned to supplier');
});

Route::get('api/getQuantity', function(){
    $id = request('item');
    $item = Item::find($id);
    return $item->type;
});


Route::post('erppurchases/create', function(){

    $data = Input::all();

    $client = Client::findOrFail(array_get($data, 'client'));

    /*
$erporder = array(
'order_number' => array_get($data, 'order_number'),
'client' => $client,
'date' => array_get($data, 'date')

);
*/

    Session::put( 'erporder', array(
            'order_number' => array_get($data, 'order_number'),
            'client' => $client,
            'payment_type' => array_get($data, 'payment_type'),
            'date' => array_get($data, 'date'),
            'lpo_no' => array_get($data, 'lpo_no'),
            'credit_ac' => array_get($data, 'credit_ac'),
            'debit_ac' => array_get($data, 'debit_ac'),
            'transaction_desc' => array_get($data, 'transaction_desc')
        )
    );
    Session::put('purchaseitems', []);

    $orderitems =Session::get('purchaseitems');

    /*
$erporder = new Erporder;

$erporder->date = date('Y-m-d', strtotime(array_get($data, 'date')));
$erporder->order_number = array_get($data, 'order_number');
$erporder->client()->associate($client);
$erporder->payment_type = array_get($data, 'payment_type');
$erporder->type = 'sales';
$erporder->save();

*/

    $items = Item::where('type', '!=', 'service')->get();
    $locations = Location::all();
    $taxes = Tax::all();

    return View::make('erppurchases.purchaseitems', compact('items', 'locations','taxes','orderitems'));

});





Route::post('erpquotations/create', function(){

    $data = Input::all();
    $client = Client::findOrFail(array_get($data, 'client'));
    $service = Item::find(array_get($data,'service'));
    $bank_account=BankAccount::find(array_get($data,'bank'));

    /*
$erporder = array(
'order_number' => array_get($data, 'order_number'),
'client' => $client,
'date' => array_get($data, 'date')

);
*/

    Session::put( 'erporder', array(
            'order_number' => array_get($data, 'order_number'),
            'lpo_no' => array_get($data, 'lpo_no'),
            'client' => $client,
            'date' => array_get($data, 'date'),
            'bank' =>array_get($data,'bank'),
            'type' => $data['type']
        )
    );

    // Session::put('orderservice', array(
    //    $service->id => $service
    // ));

    Session::put('quotationitems', []);
    // return Session::get('erporder')['service'];

    /*
$erporder = new Erporder;

$erporder->date = date('Y-m-d', strtotime(array_get($data, 'date')));
$erporder->order_number = array_get($data, 'order_number');
$erporder->client()->associate($client);
$erporder->payment_type = array_get($data, 'payment_type');
$erporder->type = 'sales';
$erporder->save();

*/

    $items = Item::where('type','=','product')->get();
    Session::put('items', $items);

    $locations = Location::all();
    Session::put('locations', $locations);

    $taxes = Tax::all();
    Session::put('taxes', $taxes);

    $servall = Item::where('type','=','service')->get();
    Session::put('servall', $servall);

    $allItems = Item::all();
    Session::put('allItems', $allItems);


    if($data['type']=='product'){
        $client = Client::findOrFail(array_get($data, 'client'));
        $service = Item::find(array_get($data,'product'));
        $bank_account=BankAccount::find(array_get($data,'bank'));
// return $data;

        Session::put( 'erporder', array(
                'order_number' => array_get($data, 'order_number'),
                'lpo_no' => array_get($data, 'lpo_no'),
                'client' => $client,
                'bank'=>array_get($data,'bank'),
                'date' => array_get($data, 'date'),
                'type' => $data['type']
            )
        );

        Session::put('quotationitems', []);

        $items = Item::where('type','=','product')->get();
        Session::put('items', $items);

        $locations = Location::all();
        Session::put('locations', $locations);

        $taxes = Tax::all();
        Session::put('taxes', $taxes);

        $servall = Item::where('type','=','service')->get();
        Session::put('servall', $servall);

        return View::make('erpquotations.product2');
    }

    return View::make('erpquotations.quotationitems');

});
Route::post('erpquotations/create2', function(){

    $data = Input::all();

    $client = Client::findOrFail(array_get($data, 'client'));
    $service = Item::find(array_get($data,'service'));
    $bank_account=BankAccount::find(array_get($data,'bank'));

    /*
$erporder = array(
'order_number' => array_get($data, 'order_number'),
'client' => $client,
'date' => array_get($data, 'date')

);
*/

    Session::put( 'erporder', array(
            'order_number' => array_get($data, 'order_number'),
            'bank'=> array_get($data,'bank'),
            'lpo_no' => array_get($data, 'lpo_no'),
            'client' => $client,
            'date' => array_get($data, 'date'),
            'payment_type' => "credit",
            'type' => $data['type']
        )
    );

    // Session::put('orderservice', array(
    //    $service->id => $service
    // ));

    Session::put('invoiceitems', []);
    // return Session::get('erporder')['service'];

    /*
$erporder = new Erporder;

$erporder->date = date('Y-m-d', strtotime(array_get($data, 'date')));
$erporder->order_number = array_get($data, 'order_number');
$erporder->client()->associate($client);
$erporder->payment_type = array_get($data, 'payment_type');
$erporder->type = 'sales';
$erporder->save();

*/

    $items = Item::where('type','=','product')->get();
    Session::put('items', $items);

    $locations = Location::all();
    Session::put('locations', $locations);

    $taxes = Tax::all();
    Session::put('taxes', $taxes);

    $servall = Item::where('type','=','service')->get();
    Session::put('servall', $servall);

    $allItems = Item::all();
    Session::put('allItems', $allItems);

    if($data['type']=='product'){
        $client = Client::findOrFail(array_get($data, 'client'));
        $service = Item::find(array_get($data,'product'));
        $bank_account=BankAccount::find(array_get($data,'bank'));
// return $data;

        Session::put( 'erporder', array(
                'order_number' => array_get($data, 'order_number'),
                'lpo_no' => array_get($data, 'lpo_no'),
                'client' => $client,
                'bank'=>array_get($data,'bank'),
                'date' => array_get($data, 'date'),
                'type' => $data['type']
            )
        );

        Session::put('quotationitems', []);

        $items = Item::where('type','=','product')->get();
        Session::put('items', $items);

        $locations = Location::all();
        Session::put('locations', $locations);

        $taxes = Tax::all();
        Session::put('taxes', $taxes);

        $servall = Item::where('type','=','service')->get();
        Session::put('servall', $servall);

        return View::make('erpquotations.product');
    }


    return View::make('erpquotations.invoiceitems');

});

/**
 * =====================================
 * ORDERITEMS {SALES ORDER}
 */
Route::post('orderitems/create', function(){

    $data = request()->all();

    $item = Item::findOrFail(Arr::get($data, 'item'));

    $item_name = $item->name;
    $price = $item->selling_price;
    $quantity = request('quantity');
    $duration = request('duration');
    $item_id = $item->id;
    $location = request('location');

    Session::push('orderitems', [
        'itemid' => $item_id,
        'item' => $item_name,
        'price' => $price,
        'quantity' => $quantity,
        'duration' => $duration,
        'location' =>$location
    ]);



    $orderitems = Session::get('orderitems');

    $items = Item::all();
    $locations = Location::all();
    $taxes = Tax::all();

    return View::make('erporders.orderitems', compact('items', 'locations', 'taxes','orderitems'));

});


/**
 * =================================================================
 * ORDERITEMS EDITING
 * Editing order item session
 */
Route::get('orderitems/edit/{count}', function($count){
    $editItem = Session::get('orderitems')[$count];

    return View::make('erporders.edit', compact('editItem', 'count'));
});

Route::post('orderitems/edit/{count}', function($sesItemID){
    $quantity = request('qty');
    $price = (float) request('price');
    //return $data['qty'].' - '.$data['price'];

    $ses = Session::get('orderitems');
    //unset($ses);
    $ses[$sesItemID]['quantity']=$quantity;
    $ses[$sesItemID]['price']=$price;
    Session::put('orderitems', $ses);

    $orderitems = Session::get('orderitems');
    $items = Item::all();
    $locations = Location::all();
    $taxes = Tax::all();

    return View::make('erporders.orderitems', compact('items', 'locations', 'taxes','orderitems'));

});


/**
 * =====================================
 * Deleting an order item session item
 */
Route::get('orderitems/remove/{count}', function($count){
    $item = Session::get('orderitems');
    unset($item[$count]);
    $newItems = array_values($item);
    Session::put('orderitems', $newItems);


    $orderitems = Session::get('orderitems');
    $items = Item::all();
    $locations = Location::all();
    $taxes = Tax::all();

    return View::make('erporders.orderitems', compact('items', 'locations', 'taxes','orderitems'));
});



/**
 * =========================
 * PURCHASES
 */
Route::post('purchaseitems/create', function(){

    $data = Input::all();

    $item = Item::findOrFail(array_get($data, 'item'));

    $item_name = $item->name;
    $price = $item->purchase_price;
    $quantity = Input::get('quantity');
    $duration = Input::get('duration');
    $description = Input::get('description');
    $item_id = $item->id;

    Session::push('purchaseitems', [
        'itemid' => $item_id,
        'item' => $item_name,
        'price' => $price,
        'quantity' => $quantity,
        'duration' => $duration,
        'description' => $description
    ]);



    $orderitems = Session::get('purchaseitems');

    $items = Item::where('type', 'product')->get();
    $locations = Location::all();
    $taxes = Tax::all();

    return View::make('erppurchases.purchaseitems', compact('items', 'locations', 'taxes','orderitems'));

});



/**
 * ==========================================================================
 * EDITING PURCHASE ORDER SESSION
 * Editing a purchase order session item
 */
Route::get('purchaseitems/edit/{count}', function($count){
    $editItem = Session::get('purchaseitems')[$count];

    return View::make('erppurchases.edit', compact('editItem', 'count'));
});

Route::post('erppurchases/edit/{count}', function($sesItemID){
    $quantity = Input::get('qty');
    $price = (float) Input::get('price');
    //return $data['qty'].' - '.$data['price'];

    $ses = Session::get('purchaseitems');
    //unset($ses);
    $ses[$sesItemID]['quantity']=$quantity;
    $ses[$sesItemID]['price']=$price;
    Session::put('purchaseitems', $ses);

    $orderitems = Session::get('purchaseitems');
    $items = Item::where('type', 'product')->get();
    $locations = Location::all();
    $taxes = Tax::all();

    return View::make('erppurchases.purchaseitems', compact('items', 'locations', 'taxes','orderitems'));

});


/**
 * =========================================================================
 * Deleting a purchase order session
 */
Route::get('purchaseitems/remove/{count}', function($count){
    $items = Session::get('purchaseitems');
    unset($items[$count]);
    $newItems = array_values($items);
    Session::put('purchaseitems', $newItems);


    $orderitems = Session::get('purchaseitems');
    $items = Item::where('type', 'product')->get();
    $locations = Location::all();
    $taxes = Tax::all();


    return View::make('erppurchases.purchaseitems', compact('items', 'locations', 'taxes','orderitems'));
});


/**
 * ===================
 * QUOTATION
 */
Route::post('quotationitems/create', function(){
    // if (Input::get('saveservice')) {
    //   $data = Input::all();
    // }

    $data = Input::all();

    $item = Item::findOrFail(array_get($data, 'item'));
    $services = Item::where('type','=','service')->get();
    $item_name = $item->name;
    $price = $item->selling_price;
    $quantity = Input::get('quantity');
    $duration = Input::get('duration');
    $description = Input::get('description');
    $item_id = $item->id;
    $service = "none";//Item::find($data['service']);

    Session::push('quotationitems', [
        'itemid' => $item_id,
        'item' => $item_name,
        'price' => $price,
        'quantity' => $quantity,
        'duration' => $duration,
        'description' => $description,
        'service' => $service
    ]);


    $orderitems = Session::get('quotationitems');

    $items = Item::all();
    $locations = Location::all();
    $taxes = Tax::all();

    return View::make('erpquotations.quotationitems');

});
Route::post('invoiceitems/create', function(){
    // if (Input::get('saveservice')) {
    //   $data = Input::all();
    // }

    $data = Input::all();

    $item = Item::findOrFail(array_get($data, 'item'));
    $services = Item::where('type','=','service')->get();
    $item_name = $item->name;
    $price = $item->selling_price;
    $quantity = Input::get('quantity');
    $duration = Input::get('duration'); $description=Input::get('description');
    $item_id = $item->id;
    $service = "none";//Item::find($data['service']);

    Session::push('invoiceitems', [
        'itemid' => $item_id,
        'item' => $item_name,
        'price' => $price,
        'quantity' => $quantity,
        'duration' => $duration,
        'description' => $description,
        'service' => $service
    ]);


    $orderitems = Session::get('invoiceitems');

    $items = Item::all();
    $locations = Location::all();
    $taxes = Tax::all();
    // return Redirect::back();
    return View::make('erpquotations.invoiceitems');

});

Route::post('invoiceitems/create2', function(){
    // if (Input::get('saveservice')) {
    //   $data = Input::all();
    // }

    $data = Input::all();

    $item = Item::findOrFail(array_get($data, 'item'));
    $services = Item::where('type','=','service')->get();
    $item_name = $item->name;
    $price = $item->selling_price;
    $quantity = Input::get('quantity');
    $duration = Input::get('duration'); $description=Input::get('description');
    $item_id = $item->id;
    if(!empty(array_get($data,'service')))
    {
        $service = Item::find($data['service']);
    }
    else
    {
        $service = "";
    }

    Session::push('invoiceitems', [
        'itemid' => $item_id,
        'item' => $item_name,
        'price' => $price,
        'quantity' => $quantity,
        'duration' => $duration,
        'service' => $service,
        'description' => $description
    ]);


    $orderitems = Session::get('invoiceitems');

    $items = Item::all();
    $locations = Location::all();
    $taxes = Tax::all();

    return View::make('erpquotations.product');

});

Route::post('quotationitems/create2', function(){

    $data = Input::all();

    $item = Item::findOrFail(array_get($data, 'item'));
    $services = Item::where('type','=','service')->get();
    $item_name = $item->name;
    $price = $item->selling_price;
    $quantity = Input::get('quantity');
    $duration = Input::get('duration');
    $description=Input::get('description');
    $item_id = $item->id;


    Session::push('quotationitems', [
        'itemid' => $item_id,
        'item' => $item_name,
        'price' => $price,
        'quantity' => $quantity,
        'duration' => $duration,
        'description' => $description
    ]);


    $orderitems = Session::get('quotationitems');

    $items = Item::all();
    $locations = Location::all();
    $taxes = Tax::all();

    return View::make('erpquotations.product2');

});
Route::post('erporder/commit', function(){

    $erporder = Session::get('erporder');

    $erporderitems = Session::get('orderitems');

    $total = request()->all();

    // $client = Client: :findorfail(array_get($erporder, 'client'));

    // print_r($total);

    // Create a session to hold journal entry data
    Session::put('sales_journal', [
        'credit_account' => $erporder['credit_ac'],
        'debit_account' => $erporder['debit_ac'],
        'date' => date('Y-m-d', strtotime(Arr::get($erporder, 'date'))),
        'amount' => $total['grand'],
        'description' => $erporder['transaction_desc'],
        'initiated_by' => Auth::user()->name
    ]);

    $data = Session::get('sales_journal');

    // Create a new sales order
    $order = new Erporder;
    $order->order_number = Arr::get($erporder, 'order_number');
    $order->client()->associate(Arr::get($erporder, 'client'));
    $order->date = date('Y-m-d', strtotime(Arr::get($erporder, 'date')));
    $order->status = 'new';
    $order->discount_amount = Arr::get($total, 'discount');
    $order->payment_type = Arr::get($erporder,'payment_type');
    $order->type = 'sales';
    $order->save();

    // Create a new Journal Entry
    $jEntry = new Journal;
    $jEntry->journal_entry($data);

    // Create a new Account Transaction
    $acTransaction = new AccountTransaction;
    $acTransaction->createTransaction($data);

    Session::forget('sales_journal');


    // Insert data into Erporderitem table
    foreach($erporderitems as $item){

        $itm = Item::findOrFail($item['itemid']);


        $ord = Erporder::findOrFail($order->id);



        $location_id = $item['location'];

        $location = Location::find($location_id);

        $date = date('Y-m-d', strtotime(Arr::get($erporder, 'date')));

        $orderitem = new Erporderitem;
        $orderitem->erporder()->associate($ord);
        $orderitem->item()->associate($itm);
        $orderitem->price = $item['price'];
        $orderitem->quantity = $item['quantity'];
        $orderitem->duration = $item['duration'];
        $orderitem->save();


        if($itm->type=='product')
        {

            Stock::removeStock($itm,$location, $item['quantity'], $date);

        }

    }


    $tax = request('tax');
    $rate = request('rate');



    for($i=0; $i < count([$rate]);  $i++){

        $txOrder = new TaxOrder;

        $txOrder->tax_id = $rate[$i];
        $txOrder->order_number = Arr::get($erporder, 'order_number');
        $txOrder->amount = $tax[$i];
        $txOrder->save();

    }


//Session::flush('orderitems');
//Session::flush('erporder');


    $order_no=Arr::get($erporder, 'order_number');

    Audit::logaudit('ERP Orders', 'created sales order ', 'Placed  sales order no. '.$order_no.' in the system');
    return redirect('salesorders')->withFlashMessage('Order Successfully Placed!');



});







Route::post('erppurchase/commit', function(){

    //$orderitems = Session::get('erppurchase');

    $erporder = Session::get('erporder');

    $orderitems = Session::get('purchaseitems');

    $total = Input::all();
    // $client = Client: :findorfail(array_get($erporder, 'client'));

    // print_r($total);

    // Create a session to hold journal entry data
    Session::put('purchase_journal', [
        'credit_account' => $erporder['credit_ac'],
        'debit_account' => $erporder['debit_ac'],
        'date' => date('Y-m-d', strtotime(array_get($erporder, 'date'))),
        'amount' => $total['grand'],
        'description' => $erporder['transaction_desc'],
        'initiated_by' => Auth::user()->username
    ]);

    $data = Session::get('purchase_journal');

    $order = new Erporder;
    $order->order_number = array_get($erporder, 'order_number');
    $order->client()->associate(array_get($erporder, 'client'));
    $order->date = date('Y-m-d', strtotime(array_get($erporder, 'date')));
    $order->status = 'new';
    //$order->discount_amount = array_get($total, 'discount');
    $order->total_amount = array_get($total, 'grand');
    $order->payment_type = array_get($erporder, 'payment_type');
    $order->lpo_no =array_get($erporder, 'lpo_no');
    $order->debit_account = array_get($erporder,'debit_ac' );
    $order->credit_account =array_get($erporder,'credit_ac' );
    $order->type = 'purchases';
    $order->save();

    // Create a new Journal Entry
    //$jEntry = new Journal;
    //$jEntry->journal_entry($data);

    // Create a new Account Transaction
    $acTransaction = new AccountTransaction;
    $acTransaction->createTransaction($data);

    Session::forget('purchase_journal');


    // Insert data into Erporderitem table
    foreach($orderitems as $item){


        $itm = Item::findOrFail($item['itemid']);

        $ord = Erporder::findOrFail($order->id);

        $orderitem = new Erporderitem;
        $orderitem->erporder()->associate($ord);
        $orderitem->item()->associate($itm);
        $orderitem->order_description = $item['description'];
        $orderitem->price = $item['price'];
        $orderitem->quantity = $item['quantity'];
        //s$orderitem->duration = $item['duration'];
        $orderitem->save();
    }


    $order_no=array_get($erporder, 'order_number');

    Audit::logaudit('ERP Orders', 'created a purchase order ', 'Placed  sales order no. '.$order_no.' in the system');
    return Redirect::to('purchaseorders')->withFlashMessage('Order Successfully Placed!');;

});


Route::post('erpquotation/commit', function(){
    $data = Input::all();

    $erporder = Session::get('erporder');
    $organization = Organization::find(1);

    $erporderitems = Session::get('quotationitems');

    $orderservice = Session::get('orderservice');

    // $client = Client::findorfail(array_get($erporder, 'client'));

    // print_r($total);


    $order = new Erporder;
    $order->order_number = array_get($erporder, 'order_number');
    $order->bankaccount_id = array_get($erporder, 'bank');
    $order->client()->associate(array_get($erporder,'client'));      // }
    $order->date = date('Y-m-d', strtotime(array_get($erporder, 'date')));
    $order->lpo_no =array_get($erporder, 'lpo_no');
    $order->status = 'new';
    $order->discount_amount = array_get($data, 'discount');
    $order->total_amount = array_get($data,'grand');
    $order->type = 'quotations';
    $order->ordered_by = Auth::user()->id;
    $order->organization_id = $organization->id;
    if(array_get($erporder, 'type') == 'service')
        $order->service = 1;
    elseif(array_get($erporder, 'type') == 'product')
        $order->service = 0;
    else {
        $order->service = 2;
    }

    $order->save();





    foreach($erporderitems as $item){


        $itm = Item::findOrFail($item['itemid']);

        $ord = Erporder::findOrFail($order->id);



        //$location_id = $item['location'];

        //$location = Location::find($location_id);

        $date = date('Y-m-d', strtotime(array_get($erporder, 'date')));

        $orderitem = new Erporderitem;
        $orderitem->erporder()->associate($ord);
        $orderitem->item()->associate($itm);
        $orderitem->price = $item['price'];
        $orderitem->quantity = $item['quantity'];
        $orderitem->duration = $item['duration'];
        $orderitem->order_description = $item['description'];
        //if($item['service']->type == 'service')
        //$orderitem->service_id = $item['service']->id;
        $orderitem->save();
    }

    // Save the services
    foreach ($orderservice as $orderservice) {

        $orderserv = new Erporderservice;

        $orderserv->service_id = $orderservice->id;
        $orderserv->name = $orderservice->name;
        $orderserv->erporder()->associate($order);
        $orderserv->save();

    }

    $tax = Input::get('tax');
    $rate = Input::get('rate');

    for($i=0; $i < count($rate);  $i++){

        $txOrder = new TaxOrder;

        $txOrder->tax_id = $rate[$i];
        $txOrder->order_number = array_get($erporder, 'order_number');
        $txOrder->amount = $tax[$i];
        $txOrder->save();

    }

    //Session::flush('orderitems');
    //Session::flush('erporder');
    $order_no=array_get($erporder, 'order_number');

    Audit::logaudit('ERP Orders', 'created a Quotation ', 'Created a Quotation no. '.$order_no.' in the system');
    return Redirect::to('quotationorders');

});


Route::post('erpquotation/commit2', function(){
    $data = Input::all();

    $erporder = Session::get('erporder');
    $organization = Organization::find(1);


    $orderservice = Session::get('orderservice');

    // $client = Client::findorfail(array_get($erporder, 'client'));
    $od=array_get($erporder, 'order_number');

    $orderno=Erporder::where('order_number','=',$od)->count();
    if($orderno>0){
        return Redirect::to('quotations1')->withErrors('Order number already exists.Please try another one !');
    }

    // print_r($total);


    $order = new Erporder;
    $order->order_number = array_get($erporder, 'order_number');
    $order->bankaccount_id = array_get($erporder, 'bank');
    $order->client()->associate(array_get($erporder,'client'));      // }
    $order->date = date('Y-m-d', strtotime(array_get($erporder, 'date')));
    $order->lpo_no =array_get($erporder, 'lpo_no');
    $order->status = 'new';
    $order->discount_amount = array_get($data, 'discount');
    $order->total_amount = array_get($data,'grand');
    $order->type = 'invoice';
    $order->approved=0;
    $order->ordered_by = Auth::user()->id;
    $order->organization_id = $organization->id;
    $order->payment_type = array_get($data,'payment_type');
    if(array_get($erporder, 'type') == 'service')
        $order->service = 1;
    elseif(array_get($erporder, 'type') == 'product')
        $order->service = 0;
    else {
        $order->service = 2;
    }
    $order->save();


    $erporderitems = Session::get('quotationitems');
    $type = 'pr';
    if(empty($erporderitems))
        $erporderitems = Session::get('invoiceitems');

    if(empty($erporderitems))
        $type = 'se';

    $date = date('Y-m-d', strtotime(array_get($erporder, 'date')));

    $erporderitems;

    $date = date('Y-m-d', strtotime(array_get($erporder, 'date')));
    $totalp_price=0;
    foreach($erporderitems as $item){

        //  return $item;
        $itm = Item::findOrFail($item['itemid']);

        $ord = Erporder::findOrFail($order->id);

        //$location_id = $item['location'];

        //$location = Location::find($location_id);

        $orderitem = new Erporderitem;
        $orderitem->erporder()->associate($ord);
        $orderitem->item()->associate($itm);
        //if($item['service']->type == 'service')

        //$orderitem->service_id = $item['service']->id;
        $orderitem->service_id = '0';

        $orderitem->price = $item['price'];
        $orderitem->quantity = $item['quantity'];
        $orderitem->order_description = $item['description'];
        $orderitem->duration = $item['duration'];
        $orderitem->save();

        $p_price=$itm->purchase_price; $quantity=$item['quantity'];
        $purchase_price=(int)$p_price*(int)$quantity;
        $totalp_price+=$purchase_price;

        if($itm->type=='product')
        { $location = Location::find(1);
            Stock::removeStock($itm,$location, $item['quantity'], $date);
        }
    }

    $totals_price=array_get($data,'grand');
    $accs=Particular::where("name","like","%"."Sales invoice"."%")->get();
    foreach($accs as $acc){
        if(count($accs)>0){
            if($acc->name=="Sales invoice2"){$total=$totalp_price;}else{$total=$totals_price;}
            $data = array(
                'credit_account' => $acc->creditaccount_id,
                'debit_account' => $acc->debitaccount_id,
                'date' => $date,
                'amount' => $total,
                'initiated_by' => Auth::user()->username,
                'description' => 'Invoice'
            );

            $journal = new Journal;
            $journal->journal_entry($data);
        }
    }

    // Save the services
    foreach ($orderservice as $orderservice) {
        $orderserv = new Erporderservice;
        $orderserv->service_id = $orderservice->id;
        $orderserv->name = $orderservice->name;
        $orderserv->erporder()->associate($order);
        $orderserv->save();
    }

    $tax = Input::get('tax');
    $rate = Input::get('rate');
    if(!empty($rate) && $rate != ""){
        for($i=0; $i < count($rate);  $i++){

            $txOrder = new TaxOrder;

            $txOrder->tax_id = $rate[$i];
            $txOrder->order_number = array_get($erporder, 'order_number');
            $txOrder->amount = $tax[$i];
            $txOrder->save();

        }
    }

    $order_no=array_get($erporder, 'order_number');

    Audit::logaudit('ERP Orders', 'created an Invoice ', 'Created an Invoice no. '.$order_no.' in the system');

    $quotations = Erporder::all();
    $items = Item::all();
    $locations = Location::all();
    $items = Item::all();
    $locations = Location::all();
    $invoices = Invoice::all();

    return View::make('erpquotations.index', compact('items', 'locations', 'quotations', 'invoices'));



    //Session::flush('orderitems');
    //Session::flush('erporder');
    //return Redirect::to('quotationorders');
    //return Redirect::back();

});

Route::post('erpquotation/commit3', function(){
    $data = Input::all();

    $erporder = Session::get('erporder');
    $organization = Organization::find(1);

    $erporderitems = Session::get('invoiceitems');


    // $client = Client::findorfail(array_get($erporder, 'client'));

    // print_r($total);


    $order = new Erporder;
    $order->order_number = array_get($erporder, 'order_number');
    $order->bankaccount_id = array_get($erporder, 'bank');
    $order->client()->associate(array_get($erporder,'client'));      // }
    $order->date = date('Y-m-d', strtotime(array_get($erporder, 'date')));
    $order->status = 'new';
    $order->discount_amount = array_get($data, 'discount');
    $order->total_amount = array_get($data,'grand');
    $order->type = 'invoice';
    $order->ordered_by = Auth::user()->id;
    $order->organization_id = $organization->id;
    $order->save();





    foreach($erporderitems as $item){


        $itm = Item::findOrFail($item['itemid']);

        $ord = Erporder::findOrFail($order->id);



        //$location_id = $item['location'];

        //$location = Location::find($location_id);

        $date = date('Y-m-d', strtotime(array_get($erporder, 'date')));

        $orderitem = new Erporderitem;
        $orderitem->erporder()->associate($ord);
        $orderitem->item()->associate($itm);
        $orderitem->price = $item['price'];
        $orderitem->quantity = $item['quantity'];
        $orderitem->duration = $item['duration'];
        $orderitem->save();
    }



    $tax = Input::get('tax');
    $rate = Input::get('rate');
    if(!empty($rate) && $rate != ""){
        for($i=0; $i < count($rate);  $i++){

            $txOrder = new TaxOrder;

            $txOrder->tax_id = $rate[$i];
            $txOrder->order_number = array_get($erporder, 'order_number');
            $txOrder->amount = $tax[$i];
            $txOrder->save();

        }
    }


    //Session::flush('orderitems');
    //Session::flush('erporder');
    $order_no=array_get($erporder, 'order_number');

    Audit::logaudit('ERP Orders', 'created an Invoice ', 'Created an Invoice no. '.$order_no.' in the system');
    return Redirect::to('quotationorders');
});

Route::post('erpquotation/commit4', function(){
    $data = Input::all();
    // return $data = Input::all();


    $erporder = Session::get('erporder');
    $organization = Organization::find(1);

    $erporderitems = Session::get('quotationitems');





    $order = new Erporder;
    $order->order_number = array_get($erporder, 'order_number');
    $order->bankaccount_id = array_get($erporder, 'bank');
    $order->client()->associate(array_get($erporder,'client'));      // }
    $order->date = date('Y-m-d', strtotime(array_get($erporder, 'date')));
    $order->status = 'new';
    $order->discount_amount = array_get($data, 'discount');
    $order->total_amount = array_get($data,'grand');
    $order->type = 'quotations';
    $order->ordered_by = Auth::user()->id;
    $order->organization_id = $organization->id;
    $order->save();





    foreach($erporderitems as $item){


        $itm = Item::findOrFail($item['itemid']);

        $ord = Erporder::findOrFail($order->id);


        $date = date('Y-m-d', strtotime(array_get($erporder, 'date')));

        $orderitem = new Erporderitem;
        $orderitem->erporder()->associate($ord);
        $orderitem->item()->associate($itm);
        $orderitem->price = $item['price'];
        $orderitem->quantity = $item['quantity'];
        $orderitem->duration = $item['duration'];
        $orderitem->save();
    }



    $tax = Input::get('tax');
    $rate = Input::get('rate');
    if(!empty($rate) && $rate != ""){
        for($i=0; $i < count($rate);  $i++){

            $txOrder = new TaxOrder;

            $txOrder->tax_id = $rate[$i];
            $txOrder->order_number = array_get($erporder, 'order_number');
            $txOrder->amount = $tax[$i];
            $txOrder->save();

        }
    }
    $order_no=array_get($erporder, 'order_number');

    Audit::logaudit('ERP Orders', 'created a Quotation ', 'Created a Quotation no. '.$order_no.' in the system');

    return Redirect::to('quotationorders');
});





Route::get('erporders/cancel/{id}', function($id){

    $order = Erporder::findorfail($id);



    $order->status = 'cancelled';
    $order->update();

    return Redirect::to('salesorders');

});


Route::get('erporders/delivered/{id}', function($id){

    $order = Erporder::findorfail($id);



    $order->status = 'delivered';
    $order->update();

    return Redirect::to('salesorders');

});




Route::get('erppurchases/cancel/{id}', function($id){

    $order = Erporder::findorfail($id);



    $order->status = 'cancelled';
    $order->update();

    return Redirect::to('purchaseorders');

});



Route::get('erppurchases/delivered/{id}', function($id){

    $order = Erporder::findorfail($id);

    $order->status = 'delivered';
    $order->update();

    return Redirect::to('purchaseorders');

});




Route::get('erpquotations/cancel/{id}', function($id){

    $order = Erporder::findorfail($id);



    $order->status = 'cancelled';
    $order->update();

    return Redirect::to('quotationorders');

});




Route::get('erporders/show/{id}', function($id){

    $order = Erporder::findorfail($id);
//    dd($order);

    return View::make('erporders.show', compact('order'));

});



Route::get('erppurchases/show/{id}', function($id){
    $order = Erporder::findorfail($id);
    return View::make('erppurchases.show', compact('order'));
});


Route::get('erppurchases/payment/{id}', function($id){

    $payments = Payment::all();

    $purchase = Erporder::findorfail($id);

    $account = Accounts::all();

    return View::make('erppurchases.payment', compact('payments', 'purchase', 'account'));

});
