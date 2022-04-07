<?php

use App\Http\Controllers\AppraisalCategoryController;
use App\Http\Controllers\AppraisalsController;
use App\Http\Controllers\AppraisalSettingsController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\HolidaysController;
use App\Http\Controllers\LeaveapplicationsController;
use App\Http\Controllers\LeavetypesController;
use App\Http\Controllers\OccurencesController;
use App\Http\Controllers\OccurencesettingsController;
use App\Http\Controllers\PromotionsController;
use App\Models\Audit;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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
Route::get('promotions/edit/{id}', [PromotionsController::class,'edit']);
Route::post('promotions/update/{id}', [PromotionsController::class,'update']);
Route::get('promotions/delete/{id}', [PromotionsController::class,'destroy']);
Route::get('promotions/create', [PromotionsController::class,'create']);
Route::get('promotions/letters/{id}', [PromotionsController::class,'promotionletter']);
Route::get('transfer/letters/{id}', [PromotionsController::class,'transferletter']);
Route::get('promotions/show/{id}', [PromotionsController::class,'show']);

/**/

//Route::group(['middleware'=>['can:manage_holiday']],function (){
/**
 * Holiday routes
 */
Route::resource('holidays', HolidaysController::class);
Route::get('holidays/edit/{id}', [HolidaysController::class,'edit']);
Route::get('holidays/delete/{id}', [HolidaysController::class,'destroy']);
Route::post('holidays/update/{id}', [HolidaysController::class,'update']);
//});

//Route::group(['middleware'=>['can:manage_leavetype']],function (){
Route::resource('leavetypes', LeavetypesController::class);
Route::get('leavetypes/edit/{id}', [LeavetypesController::class,'edit']);
Route::get('leavetypes/delete/{id}', [LeavetypesController::class,'destroy']);
Route::post('leavetypes/update/{id}', [LeavetypesController::class,'update']);
//});

//Route::group(['middleware'=>['can:manage_leave']],function (){
/**LEAVE APPLICATION ROUTES */
Route::resource('leaveapplications', LeaveapplicationsController::class);
Route::get('leaveapplications/edit/{id}', [LeaveapplicationsController::class,'edit']);
Route::get('leaveapplications/delete/{id}', [LeaveapplicationsController::class,'destroy']);
Route::post('leaveapplications/update/{id}', [LeaveapplicationsController::class,'update']);
Route::get('leaveapplications/approve/{id}', [LeaveapplicationsController::class,'approve']);
Route::post('leaveapplications/approve/{id}', [LeaveapplicationsController::class,'doapprove']);
Route::get('leaveapplications/cancel/{id}', [LeaveapplicationsController::class,'cancel']);
//Route::get('leaveapplications/cancel/{id}', 'LeaveapplicationsController@cancel');
Route::get('leaveapplications/reject/{id}', [LeaveapplicationsController::class,'reject']);
Route::get('leaveapplications/show/{id}', [LeaveapplicationsController::class,'show']);

Route::get('leaveapplications/approvals', [LeaveapplicationsController::class,'approvals']);
Route::get('leaveapplications/rejects', [LeaveapplicationsController::class,'rejects']);
Route::get('leaveapplications/cancellations', [LeaveapplicationsController::class,'cancellations']);
Route::get('leaveapplications/amends', [LeaveapplicationsController::class,'amended']);
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
