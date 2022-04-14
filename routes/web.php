<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\AdvanceController;
use App\Http\Controllers\AppraisalCategoryController;
use App\Http\Controllers\AppraisalsController;
use App\Http\Controllers\AppraisalSettingsController;
use App\Http\Controllers\BankBranchController;
use App\Http\Controllers\BanksController;
use App\Http\Controllers\BenefitSettingsController;
use App\Http\Controllers\BranchesController;
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
use App\Models\Audit;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\Leaveapplication;
use App\Models\Leavetype;
use App\Models\Organization;
use App\Models\Promotion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
Route::resource('users',UserController::class);
/*
 * Roles
 * */
Route::resource('roles',RoleController::class);

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
Route::post('payrollReports/p9form', [ReportsController::class, 'p9form']);
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
Route::post('nssf/update/{id}', [NssfController::class,'update']);
Route::get('nssf/delete/{id}', [NssfController::class,'destroy']);
Route::get('nssf/edit/{id}', [NssfController::class,'edit']);

/*
* nhif routes
*/

Route::resource('nhif', NhifController::class);
Route::post('nhif/update/{id}', [NhifController::class,'update']);
Route::get('nhif/delete/{id}', [NhifController::class,'destroy']);
Route::get('nhif/edit/{id}', [NhifController::class,'edit']);
//
Route::get('api/pay', function () {
    $id = request('option');
    $employee = Employee::find($id);
    return number_format($employee->basic_pay, 2);
});
