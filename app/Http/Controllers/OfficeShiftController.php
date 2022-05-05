<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Models\OfficeShift;


class OfficeShiftController extends BaseController
{
    public function index()
    {

        $shifts = OfficeShift::all();

        return View::make('timesheet.work_shift.index',compact('shifts'));
    }

    public function create()
    {
        return View::make('timesheet.work_shift.create');
    }

    public  function store(){
        $validator = Validator::make(request()->all(),[
            'shift_name' => 'required'
        ]);

        if($validator->fails()){
            return Redirect::back()->with(['errors'=> $validator->errors()->all()]);
        }

        $data = [];

        $data['shift_name'] = request('shift_name');
        $data['monday_in'] = request("monday_in");
        $data['monday_out'] =  request("monday_out");
        $data['tuesday_in'] =  request("tuesday_in");
        $data['tuesday_out'] =  request("tuesday_out");
        $data['wednesday_in'] =  request("wednesday_in");
        $data['wednesday_out'] =  request("wednesday_out");
        $data['thursday_in'] =  request("thursday_in");
        $data['thursday_out'] =  request("thursday_out");
        $data['friday_in'] =  request("friday_in");
        $data['friday_out'] =  request("friday_out");
        $data['saturday_in'] = request("saturday_in");
        $data['saturday_out'] = request("saturday_out");
        $data['sunday_in'] =  request("sunday_in");
        $data['sunday_out'] =  request("sunday_out");
        $data['organization_id'] = 1;

        OfficeShift::create($data);

        return Redirect::to('timesheet/work_shift')->with('success','Data created Successfully');
    }

    public function edit($id)
    {
        $office_shift = OfficeShift::findOrFail($id);
        //$organization_name
        $orgs = Organization::select('id','organization')->get();

        return View::make('timesheet.office_shift.edit',compact(''));
    }

    public function destroy($id){
        OfficeShift::where('id',$id)->delete();
        return Redirect::to('timesheet/work_shift')->with('success','Data created Successfully');
    }
}
