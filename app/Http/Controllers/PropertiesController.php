<?php namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\Organization;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class PropertiesController extends Controller {

    /*
     * Display a listing of kins
     *
     * @return Response
     */
    public function index()
    {
        $properties = DB::table('x_employee')
            ->join('x_properties', 'x_employee.id', '=', 'x_properties.employee_id')
            ->where('in_employment','=','Y')
            ->where('organization_id',Auth::user()->organization_id)
            ->get();

        $date = now();
        $user = Auth::user()->username;

        Audit::logaudit($date, $user, 'viewed company properties');

        return View::make('properties.index', compact('properties'));
    }

    /*
     * Show the form for creating a new kin
     *
     * @return Response
     */
    public function create()
    {
        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->first();
        $employees = DB::table('employee')
            ->where('in_employment','=','Y')
            ->where('organization_id',Auth::user()->organization_id)
            ->get();
        return View::make('properties.create', compact('employees','currency'));
    }

    /*
     * Store a newly created kin in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($data = $request->all(), Property::$rules,Property::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }


        $property = new Property;

        $property->employee_id= $request->get('employee_id');
        $property->name = $request->get('name');
        $property->description = $request->get('desc');
        $property->serial = $request->get('serial');
        $property->digitalserial = $request->get('dserial');
        $a = str_replace( ',', '', $request->get('amount') );
        $property->monetary = $a;
        $property->issued_by = Auth::user()->id;
        $property->issue_date = $request->get('idate');
        $property->scheduled_return_date = $request->get('sdate');
        if(filter_var($request->get('active'), FILTER_VALIDATE_BOOLEAN)){
            $property->state = 1;
            $property->received_by = Auth::user()->id;
            $property->return_date = $request->get('idate');
        }else{
            $property->state = 0;
            $property->received_by = 0;
            $property->return_date = null;
        }
        $property->save();

        $date = now();
        $user = Auth::user()->username;
        Audit::logaudit($date, $user, 'created: '.$property->name.' for '
            .Employee::getEmployeeName($request->get('employee_id')));


        return Redirect::to('Properties/view/'.$property->id)->withFlashMessage('Company property successfully created!');
    }

    /*
     * Display the specified kin.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $property = Property::findOrFail($id);

        return View::make('properties.show', compact('property'));
    }

    /*
     * Show the form for editing the specified kin.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $property = Property::find($id);

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Auth::user()->organization_id)->first();
        $user = User::findOrFail($property->issued_by);
        if($property->received_by>0){
            $retuser = User::findOrFail($property->received_by);
        }

        return View::make('properties.edit', compact('currency','property','user','retuser'));
    }

    /*
     * Update the specified kin in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $property = Property::findOrFail($id);

        $validator = Validator::make($data = $request->all(), Property::$rules,Property::$messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $property->name = $request->get('name');
        $property->description = $request->get('desc');
        $property->serial = $request->get('serial');
        $property->digitalserial = $request->get('dserial');
        $a = str_replace( ',', '', $request->get('amount') );
        $property->monetary = $a;
        $property->issue_date = $request->get('idate');
        $property->scheduled_return_date = $request->get('sdate');
        if(filter_var($request->get('active'), FILTER_VALIDATE_BOOLEAN)){
            $property->state = 1;
            $property->received_by = Auth::user()->id;
            $property->return_date = date('Y-m-d');
        }else{
            $property->state = 0;
            $property->received_by = Auth::user()->id;
            $property->return_date = null;
        }

        $property->update();

        $date = now();
        $user = Auth::user()->username;

        Audit::logaudit($date, $user, 'updated: '.$property->name.' for '.Employee::getEmployeeName($property->employee_id));

        return Redirect::to('Properties/view/'.$id)->withFlashMessage('Company Property successfully updated!');
    }

    /*
     * Remove the specified kin from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $property = Property::findOrFail($id);

        Property::destroy($id);

        $date= now();
        $user = Auth::user()->username;

        Audit::logaudit($date, $user, 'deleted: '.$property->name.' for '.Employee::getEmployeeName($property->employee_id));

        return Redirect::to('employees/view/'.$property->employee_id)->withDeleteMessage('Company Property successfully deleted!');
    }

    public function view($id){

        $property = Property::find($id);

        $user = User::findOrFail($property->issued_by);

        if($property->received_by>0){
            $retuser = User::findOrFail($property->received_by);
        }else{
            $retuser=User::find(1);
        }

        $organization = Organization::find(Auth::user()->organization_id);

        return View::make('properties.view', compact('property','user','retuser'));

    }

}
