<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\OvertimeSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OvertimeSettingsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $settings = OvertimeSettings::query()->where('organization_id', Auth::user()->organization_id)->get();
        return view('overtime_setting.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'type' => 'required',
            'min' => 'required',
            'max' => 'required',
            'rate' => 'required'
        ]);
        if ($validate->fails()) {
            toast('Failed To Validate Input', 'warning');
            return redirect()->back();
        }
        $settings = new OvertimeSettings();
        $settings->type = $request->type;
        $settings->rate = $request->rate;
        $settings->min = $request->min;
        $settings->organization_id = Auth::user()->organization_id;
        $settings->max = $request->max;
        $settings->save();
        if ($settings) {
            toast('Success','success');
        }
        return  redirect()->back();
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $settings = OvertimeSettings::where('id',$id)->findOrFail($id);
        $settings->type = $request->type;
        $settings->rate = $request->rate;
        $settings->min = $request->min;
        $settings->max = $request->max;
        $settings->push();
        if ($settings) {
            toast('Updated','info');
        }
        return  redirect()->back();
    }
    public function fetch(Request $request)
    {
        $type = $request->type;
        $salary = $request->salary;
        $data = OvertimeSettings::where('type',$type)->where('min','<',$salary)->where('max','>',$salary)->pluck('rate')->first();
        return $data;
    }
    public function fetchSalary($id)
    {
        $emp = Employee::find($id);
        return ($emp->basic_pay);
//        return number_format($emp->basic_pay, 2);
    }
}
