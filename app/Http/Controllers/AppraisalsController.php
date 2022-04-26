<?php namespace App\Http\Controllers;

use App\Models\Appraisal;
use App\Models\Appraisalcategory;
use App\Models\Appraisalquestion;
use App\Models\Audit;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AppraisalsController extends Controller {

    /*
     * Display a listing of branches
     *
     * @return Response
     */
    public function index()
    {
        $employees = Appraisal::where('organization_id',Auth::user()->organization_id)->get();

        $appraisals = DB::table('x_employee')
            ->join('x_appraisals', 'x_employee.id', '=', 'x_appraisals.employee_id')
            ->join('x_appraisalquestions', 'x_appraisals.appraisalquestion_id', '=', 'x_appraisalquestions.id')
            ->where('in_employment','=','Y')
            ->where('x_employee.organization_id',Auth::user()->organization_id)
            ->select('x_appraisals.id','appraisalquestion_id','first_name','middle_name','last_name','question','performance','x_appraisals.rate')
            ->get();

        $user = Auth::user()->name;
        $date = now();

        Audit::logaudit($date, $user, 'viewed appraisals');

        return View::make('appraisals.index', compact('appraisals'));
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
        $appraisals = Appraisalquestion::where('organization_id',Auth::user()->organization_id)->get();
        $categories = Appraisalcategory::whereNull('organization_id')
            ->orWhere('organization_id',Auth::user()->organization_id)->get();

        return View::make('appraisals.create',compact('employees','appraisals','categories'));
    }

    public function createquestion(Request $request)
    {
        $postapp = $request->all();
        $data = array('appraisalcategory_id' => $postapp['category'],
            'rate' => $postapp['rate'],
            'question' => $postapp['question'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('appraisalquestions')->insertGetId( $data );
        $user = Auth::user()->username;
        $date = date('Y-m-d');

        if($check > 0){
            Audit::logaudit($date, $user, 'created: '.$postapp['question']);
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
        $validator = Validator::make($data = $request->all(),
            Appraisal::$rules,
            Appraisal::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $appraisal = new Appraisal;

        $appraisal->employee_id = $request->get('employee_id');

        $appraisal->appraisalquestion_id = $request->get('appraisal_id');

        $appraisal->performance = $request->get('performance');

        $appraisal->rate = $request->get('score');

        $appraisal->examiner = Auth::user()->id;

        $appraisal->appraisaldate = $request->get('date');

        $appraisal->comment = $request->get('comment');

        $appraisal->organization_id = Auth::user()->organization_id;

        $appraisal->save();

        Audit::logaudit('Employee Appraisal', 'create', 'created: '.$appraisal->question.' for '.Employee::getEmployeeName($request->get('employee_id')));


        return Redirect::to('Appraisals/view/'.$appraisal->id)->withFlashMessage('Employee Appraisal successfully created!');
    }

    /*
     * Display the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $appraisal = Appraisal::findOrFail($id);

        return View::make('appraisals.show', compact('appraisal'));
    }

    /*
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $appraisal = Appraisal::find($id);
        $appraisalqs = Appraisalquestion::where('organization_id',Auth::user()->organization_id)->get();
        $user = User::find($appraisal->examiner);
        $categories = Appraisalcategory::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->get();
        return View::make('appraisals.edit', compact('appraisal','appraisalqs','user','categories'));
    }

    /*
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $appraisal = Appraisal::findOrFail($id);

        $validator = Validator::make($data = $request->all(), Appraisal::$rules,Appraisal::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $appraisal->appraisalquestion_id = $request->get('appraisal_id');

        $appraisal->performance = $request->get('performance');

        $appraisal->rate = $request->get('score');

        $appraisal->appraisaldate = $request->get('date');

        $appraisal->comment = $request->get('comment');

        $appraisal->organization_id= Auth::user()->organization_id;

        $appraisal->update();

        $user = Auth::user()->username;
        $date = date('Y-m-d');

        Audit::logaudit($date, $user, 'updated: '.$appraisal->question.' for '.Employee::getEmployeeName($appraisal->employee_id));


        return Redirect::to('Appraisals/view/'.$id)->withFlashMessage('Employee Appraisal successfully updated!');
    }

    /*
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $appraisal = Appraisal::findOrFail($id);

        Appraisal::destroy($id);

        Audit::logaudit('Employee Appraisal', 'delete', 'deleted: '.$appraisal->question.' for '.Employee::getEmployeeName($appraisal->employee_id));


        return Redirect::to('employees/view/'.$appraisal->employee_id)->withDeleteMessage('Employee Appraisal successfully deleted!');
    }

    public function view($id){

        $appraisal = Appraisal::find($id);

        $user = User::find($appraisal->examiner);

        $organization = Organization::find(Auth::user()->organization_id);

        return View::make('appraisals.view', compact('appraisal','user'));

    }

}
