<?php namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Models\Occurence;
use App\Models\Occurencesetting;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class OccurencesController extends Controller {

    /*
     * Display a listing of branches
     *
     * @return Response
     */
    public function index()
    {
        $occurences = DB::table('x_employee')
            ->join('x_occurences', 'x_employee.id', '=', 'x_occurences.employee_id')
            ->where('in_employment','=','Y')
            ->where('x_employee.organization_id',Auth::user()->organization_id)
            ->get();

        $date = now();
        $user = Auth::user()->name;

        Audit::logaudit($date, $user, 'viewed occurences');

        return View::make('occurences.index', compact('occurences'));
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
            ->where('organization_id',Auth::user()->organization_id)
            ->get();
        $occurences = Occurencesetting::all();
        return View::make('occurences.create',compact('employees','occurences'));
    }

    public function createoccurence(Request $request)
    {
        $postocc = $request->all();
        $data = array('occurence_type' => $postocc['name'],
            'organization_id' => Auth::user()->organization_id,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'));
        $check = DB::table('occurencesettings')->insertGetId( $data );
        // $id = DB::table('earningsettings')->insertGetId( $data );

        $user = Auth::user()->username;
        $date = now();

        if($check > 0){

            Audit::logaudit($date, $user, 'created: '.$postocc['name']);
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
        $validator = Validator::make($data = $request->all(), Occurence::$rules, Occurence::$messsages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $occurence = new Occurence;

        $occurence->occurence_brief = $request->get('brief');

        $occurence->employee_id = $request->get('employee');

        $occurence->occurencesetting_id = $request->get('type');

        $occurence->narrative = $request->get('narrative');

        $occurence->occurence_date = $request->get('date');

        if ( $request->hasFile('path')) {

            $file = $request->file('path');
            $name = $file->getClientOriginalName();
            $file = $file->move('public/uploads/employees/documents/', $name);
            $input['file'] = '/public/uploads/employees/documents/'.$name;
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $occurence->doc_path = $name;
        }

        $occurence->organization_id = Auth::user()->organization_id;

        $occurence->save();

        $date = now();
        $user = Auth::user()->username;

        Audit::logaudit($date, $user, 'created: '.$occurence->occurence_brief.' for '.Employee::getEmployeeName($request->get('employee')));


        return Redirect::to('occurences/view/'.$occurence->id)->withFlashMessage('Occurence successfully created!');
    }

    /*
     * Display the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $occurence = Occurence::findOrFail($id);

        return View::make('occurences.show', compact('occurence'));
    }

    /*
     * Show the form for editing the specified branch.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $occurence = Occurence::find($id);

        $occurencesettings = Occurencesetting::all();

        $employees = Employee::all();

        return View::make('occurences.edit', compact('occurence','employees','occurencesettings'));
    }

    /*
     * Update the specified branch in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $occurence = Occurence::findOrFail($id);

        $validator = Validator::make($data = $request->all(), Occurence::$rules, Occurence::$messsages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $occurence->occurence_brief = $request->get('brief');

        $occurence->occurencesetting_id = $request->get('type');

        $occurence->narrative = $request->get('narrative');

        $occurence->occurence_date = $request->get('date');

        if ( $request->hasFile('path')) {

            $file = $request->file('path');
            $name = $file->getClientOriginalName();
            $file = $file->move('public/uploads/employees/documents/', $name);
            $input['file'] = '/public/uploads/employees/documents/'.$name;
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $occurence->doc_path = $name;
        }

        $occurence->update();

        Audit::logaudit('Occurences', 'update', 'updated: '.$occurence->occurence_brief.' for '.Employee::getEmployeeName($request->get('employee')));

        return Redirect::to('occurences/view/'.$id)->withFlashMessage('Occurence successfully updated!');
    }

    /*
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $occurence = Occurence::findOrFail($id);
        Occurence::destroy($id);

        Audit::logaudit('Occurences', 'delete', 'deleted: '.$occurence->occurence_brief.' for '.Employee::getEmployeeName($occurence->employee_id));

        return Redirect::to('employees/view/'.$occurence->employee_id)->withDeleteMessage('Occurence successfully deleted!');
    }

    public function view($id){

        $occurence = Occurence::find($id);

        $organization = Organization::find(Auth::user()->organization_id);

        return View::make('occurences.view', compact('occurence'));

    }

    public function getDownload($id){
        //PDF file is stored under project/public/download/info.pdf
        $occurence = Occurence::findOrFail($id);
        $file= public_path(). "/uploads/employees/documents/".$occurence->doc_path;

        return Response::download($file, $occurence->doc_path);
    }

}
