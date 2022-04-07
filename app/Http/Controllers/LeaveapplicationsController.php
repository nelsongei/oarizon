<?php namespace App\Http\Controllers;

use App\models\Employee;
use App\models\Leaveapplication;
use App\Models\Leavetype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class LeaveapplicationsController extends Controller
{

    /*
     * Display a listing of leaveapplications
     *
     * @return Response
     */
    public function index()
    {
        $leaveapplications = Leaveapplication::all();

        return Redirect::to('leavemgmt');
    }

    /*
     * Show the form for creating a new leaveapplication
     *
     * @return Response
     */
    public function create()
    {
        $employees = Employee::all();

        $leavetypes = Leavetype::all();

        return view('leaveapplications.create', compact('employees', 'leavetypes'));
    }

    /*
     * Store a newly created leaveapplication in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($data = $request->all(), Leaveapplication::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Leaveapplication::createLeaveApplication($data);

        if (Auth::user()->user_type == 'admin') {
            return Redirect::to('leavemgmt');
        } else {

            return Redirect::to('css/leave')->with('notice', 'Successfully applied vacation');
        }
    }

    /*
     * Display the specified leaveapplication.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $leaveapplication = Leaveapplication::findOrFail($id);

        return view('leaveapplications.show', compact('leaveapplication'));
    }

    /*
     * Show the form for editing the specified leaveapplication.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $leaveapplication = Leaveapplication::find($id);

        $employees = Employee::all();

        $leavetypes = Leavetype::all();

        return view('leaveapplications.edit', compact('leaveapplication', 'employees', 'leavetypes'));
    }

    /*
     * Update the specified leaveapplication in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $leaveapplication = Leaveapplication::findOrFail($id);

        $validator = Validator::make($data = $request->all(), Leaveapplication::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Leaveapplication::amendLeaveApplication($data, $id);

        return Redirect::to('leavemgmt');
    }

    /*
     * Remove the specified leaveapplication from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Leaveapplication::destroy($id);

        return Redirect::to('leavemgmt');
    }


    public function approve($id)
    {

        $leaveapplication = Leaveapplication::find($id);

        return view('leaveapplications.approve', compact('leaveapplication'));


    }


    public function doApprove(Request $request, $id)
    {


        $data = $request->all();

        Leaveapplication::approveLeaveApplication($data, $id);

        return Redirect::route('leaveapplications.index');

    }


    public function reject($id)
    {

        Leaveapplication::rejectLeaveApplication($id);
        return Redirect::route('leaveapplications.index');

    }

    public function cancel($id)
    {

        Leaveapplication::cancelLeaveApplication($id);
        return Redirect::route('leaveapplications.index');

    }

    public function redeem(Request $request)
    {

        $employee = Employee::find($request->get('employee_id'));
        $leavetype = Leavetype::find($request->get('leavetype_id'));

        Leaveapplication::RedeemLeaveDays($employee, $leavetype);

        return Redirect::route('leaveapplications.index');

    }


    public function approvals()
    {
        $leaveapplications = Leaveapplication::all();

        return view('leaveapplications.approved', compact('leaveapplications'));
    }


    public function amended()
    {
        $leaveapplications = Leaveapplication::all();

        return view('leaveapplications.amended', compact('leaveapplications'));
    }

    public function rejects()
    {
        $leaveapplications = Leaveapplication::all();

        return view('leaveapplications.rejected', compact('leaveapplications'));
    }

    public function cancellations()
    {
        $leaveapplications = Leaveapplication::all();

        return view('leaveapplications.cancelled', compact('leaveapplications'));
    }

}
